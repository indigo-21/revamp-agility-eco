<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ClientInstaller;
use App\Models\PropertyInspector;
use Carbon\Carbon;

class PropertyInspectorJobAllocationService
{
    public $property_inspector;

    public function __construct()
    {
        $property_inspectors = PropertyInspector::where('is_active', 1)
            ->where('id_expiry', '>=', now())
            ->get();

        $this->property_inspector = $property_inspectors;
    }

    public function PIAllocationProcess($request, $measure, $notFirmAvailable = false)
    {
        $postcode = self::getPostcode($request->postcode);

        self::getClientInstallers($request, $measure, $notFirmAvailable);
        self::postcodeLogic($postcode);
        self::jobTypeLogic($request);
        self::jobMeasureLogic($request);
        self::availabilityLogic($request, $measure);
        self::jobTypeRatingLogic($request);
        self::lowestNumberOfAllocatedLogic($request);

        if ($this->property_inspector->count() > 1) {
            // get random property inspector from the pool
            $random_property_inspector = $this->property_inspector->random();
            self::allocateJob($random_property_inspector);
        }

        return $this->property_inspector ?? null;
    }

    public function getPostcode($request)
    {
        if (preg_match('/^([A-Za-z]+)[0-9]/', $request, $matches)) {
            return $matches[1];
        }
        return false;

    }

    public function getClientInstallers($request, $measure, $notFirmAvailable)
    {
        $client_installers = Client::whereHas('clientInstallers', function ($query) use ($request) {
            $query->where('installer_id', $request->installer_id);
        })
            ->whereHas('clientKeyDetails', function ($query) use ($request) {
                $query->where('is_active', 1);
            })
            ->where('id', $request->client_id)
            ->exists();

        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($client_installers, $notFirmAvailable) {
            $accountLevel = $property_inspector->user->account_level_id;

            if ($notFirmAvailable) {
                return in_array($accountLevel, [7, 8]);
            }

            if ($client_installers) {
                return $accountLevel == 6;
            }

            return in_array($accountLevel, [7, 8]);
        });

        if ($client_installers && $property_inspector_pool->count() == 0) {
            self::PIAllocationProcess($request, $measure, true);
        }

        if ($property_inspector_pool->count() == 1) {
            self::allocateJob($property_inspector_pool->first());
        } else if ($property_inspector_pool->count() > 0) {
            $this->property_inspector = $property_inspector_pool; // Already a collection
        }

    }

    public function postcodeLogic($postcode)
    {
        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($postcode) {
            foreach ($property_inspector->propertyInspectorPostcodes as $inspector_postcode) {
                $property_inspector_postcode = $inspector_postcode->outwardPostcode->name;
                if ($property_inspector_postcode == $postcode) {
                    return true;
                }
            }
            return false;
        });

        if ($property_inspector_pool->count() == 1) {
            self::allocateJob($property_inspector_pool->first());
        } else if ($property_inspector_pool->count() > 0) {
            $this->property_inspector = $property_inspector_pool; // Already a collection
        }
    }

    public function jobTypeLogic($request)
    {
        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($request) {
            foreach ($property_inspector->propertyInspectorJobTypes as $inspector_job_type) {
                if ($inspector_job_type->job_type_id == $request->job_type_id) {
                    return true;
                }
            }
            return false;
        });

        if ($property_inspector_pool->count() == 1) {
            self::allocateJob($property_inspector_pool->first());
        } else if ($property_inspector_pool->count() > 0) {
            $this->property_inspector = $property_inspector_pool; // Already a collection
        }
    }

    public function jobMeasureLogic($request)
    {
        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($request) {
            foreach ($property_inspector->propertyInspectorMeasures as $inspector_job_measure) {
                if ($inspector_job_measure->job_measure_id == $request->job_measure_id) {
                    return true;
                }
            }
            return false;
        });

        if ($property_inspector_pool->count() == 1) {
            self::allocateJob($property_inspector_pool->first());
        } else if ($property_inspector_pool->count() > 0) {
            $this->property_inspector = $property_inspector_pool; // Already a collection
        }
    }

    public function availabilityLogic($request, $measure)
    {
        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($request, $measure) {
            $client = (new JobService)->getClient($request);
            $measure_data = (new JobService)->getMeasure($measure);
            $days_available = $client ? (int) $client->clientSlaMetric->job_deadline / 2 : 0;

            // count available days from now to 7 days and reduce the count if the property inspector work_sun and work_sat is equals to 0
            for ($i = 1; $i < $days_available + 1; $i++) {
                $date = Carbon::now()->addDays($i);
                if ($property_inspector->work_sun == 0 && $date->isSunday()) {
                    $days_available--;
                }
                if ($property_inspector->work_sat == 0 && $date->isSaturday()) {
                    $days_available--;
                }
            }

            // apply the pi sick dates and booked_job dates

            // apply the pi unbooked_jobs dates

            // $sample_date = Carbon::createFromFormat('Y-m-d', '2025-04-24');

            // // reduce again if this date "2025-04-24" is between the date today and date + 7 days
            // if ($sample_date->isBetween(now(), now()->addDays(7))) {
            //     $days_available--;
            // }

            $total_available_days = $days_available * $property_inspector->hours_spent;

            // check if the total available days is greater than the measure duration and positive
            if ($total_available_days > 0 && $total_available_days >= $measure_data->measure_duration) {
                return true;
            } else {
                return false;
            }

        });

        if ($property_inspector_pool->count() == 1) {
            self::allocateJob($property_inspector_pool->first());
        } else if ($property_inspector_pool->count() > 0) {
            $this->property_inspector = $property_inspector_pool; // Already a collection
        }
    }

    public function jobTypeRatingLogic($request)
    {
        // filter the property inspector with the highest rating and remove the lowest rating, if the property inspectors have same rating store in the $this->property_inspector pool
        $highest_rating = $this->property_inspector->max(function ($property_inspector) use ($request) {
            foreach ($property_inspector->propertyInspectorJobTypes as $inspector_job_type) {
                if ($inspector_job_type->job_type_id == $request->job_type_id) {
                    return $inspector_job_type->rating ?? 0;
                }
            }
            return 0;
        });

        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($request, $highest_rating) {
            foreach ($property_inspector->propertyInspectorJobTypes as $inspector_job_type) {
                if ($inspector_job_type->job_type_id == $request->job_type_id && $inspector_job_type->rating == $highest_rating) {
                    return true;
                }
            }
            return false;
        });

        if ($property_inspector_pool->count() == 1) {
            self::allocateJob($property_inspector_pool->first());
        } else if ($property_inspector_pool->count() > 0) {
            $this->property_inspector = $property_inspector_pool; // Already a collection
        }
    }

    public function lowestNumberOfAllocatedLogic($request)
    {

        $job_count = $this->property_inspector->mapWithKeys(fn($property_inspector) => [
            $property_inspector->id => $property_inspector->jobs ? $property_inspector->jobs->count() : 0
        ]);

        $lowest_job_count = $job_count->min();
        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($job_count, $lowest_job_count) {
            return $job_count[$property_inspector->id] == $lowest_job_count;
        });

        if ($property_inspector_pool->count() == 1) {
            self::allocateJob($property_inspector_pool->first());
        } else if ($property_inspector_pool->count() > 0) {
            $this->property_inspector = $property_inspector_pool; // Already a collection
        }
    }

    public function allocateJob($property_inspector)
    {
        // Ensure $this->property_inspector is always a collection
        $this->property_inspector = collect([$property_inspector]);
    }
}