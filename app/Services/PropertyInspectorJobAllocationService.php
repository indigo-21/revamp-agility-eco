<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Client;
use App\Models\ClientInstaller;
use App\Models\Job;
use App\Models\PropertyInspector;
use App\Models\SicknessHoliday;
use Carbon\Carbon;

class PropertyInspectorJobAllocationService
{
    public $property_inspector;

    private static ?int $lastAllocatedPropertyInspectorId = null;
    private static ?string $lastAllocatedCertNo = null;

    public function __construct()
    {
        $property_inspectors = PropertyInspector::where('is_active', 1)
            // ->where('id_expiry', '>=', now())
            ->get();

        $this->property_inspector = $property_inspectors;
    }

    public function PIAllocationProcess($request, $measure, $notFirmAvailable = false)
    {
        // check if the job has already allocated to a property inspector
        // if yes, then return the property inspector
        $job_pi_allocated = Job::with('jobMeasure')
            ->where('cert_no', $request->cert_no)
            ->get();

        if ($job_pi_allocated->count() > 0) {
            if ($job_pi_allocated->first()->propertyInspector) {
                $this->property_inspector = $job_pi_allocated->first()->propertyInspector;
                self::allocateJob($this->property_inspector);

                self::$lastAllocatedPropertyInspectorId = $this->property_inspector->first()?->id;
                self::$lastAllocatedCertNo = (string) $request->cert_no;

                return $this->property_inspector;
            }
        }

        // if no, then proceed with the allocation process

        $postcode = self::getPostcode($request->postcode);

        if ($this->property_inspector->count() == 0) {
            // return job status 22 - job data no property inspector
            return null;
        }

        self::getClientInstallers($request, $measure, $notFirmAvailable);
        self::postcodeLogic($postcode);
        self::jobTypeLogic($request);
        self::jobMeasureLogic($measure);
        self::availabilityLogic($request, $measure);
        self::jobTypeRatingLogic($request);
        self::lowestNumberOfAllocatedLogic($request);

        if ($this->property_inspector->count() > 1) {
            // get random property inspector from the pool.
            // If the previous job in this PHP process used a PI with a different cert_no,
            // prefer selecting a different PI while still keeping the same pipeline above.
            $candidate_pool = $this->property_inspector;

            if (
                self::$lastAllocatedPropertyInspectorId !== null
                && self::$lastAllocatedCertNo !== null
                && (string) $request->cert_no !== self::$lastAllocatedCertNo
            ) {
                $candidate_pool_without_previous = $candidate_pool
                    ->reject(fn($property_inspector) => $property_inspector->id === self::$lastAllocatedPropertyInspectorId)
                    ->values();

                if ($candidate_pool_without_previous->count() > 0) {
                    $candidate_pool = $candidate_pool_without_previous;
                }
            }

            $random_property_inspector = $candidate_pool->random();
            self::allocateJob($random_property_inspector);
        }

        if ($this->property_inspector && $this->property_inspector->count() > 0) {
            self::$lastAllocatedPropertyInspectorId = $this->property_inspector->first()?->id;
            self::$lastAllocatedCertNo = (string) $request->cert_no;
        }

        return $this->property_inspector ?? null;
        // return null;
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
            $this->property_inspector = $property_inspector_pool;
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

    public function jobMeasureLogic($measure)
    {
        $measure_data = (new JobService)->getMeasure($measure);

        $property_inspector_pool = $this->property_inspector->filter(function ($property_inspector) use ($measure_data) {
            foreach ($property_inspector->propertyInspectorMeasures as $inspector_job_measure) {
                // if ($inspector_job_measure->measure_id == $measure_data->id && $inspector_job_measure->expiry >= now()) {
                if ($inspector_job_measure->measure_id == $measure_data->id ) {
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
            $unbooked_jobs_count = 0;

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

            $start_date = Carbon::now()->startOfDay()->toDateTimeString();
            $end_date = Carbon::now()->addDays($days_available)->endOfDay()->toDateTimeString();

            $booking_date = Job::where('job_status_id', 1)
                ->where('property_inspector_id', $property_inspector->id)
                ->whereBetween('schedule_date', [$start_date, $end_date])
                ->count();

            $days_available -= $booking_date;

            // $sicknessHolidays = SicknessHoliday::where('property_inspector_id', $property_inspector->id)
            //     ->whereBetween('start_date', [$start_date, $end_date])
            //     ->orWhereBetween('end_date', [$start_date, $end_date])
            //     ->count();

            // $days_available -= $sicknessHolidays;

            // apply the pi unbooked_jobs dates

            foreach ($property_inspector->job as $job) {
                if ($job->status == 25) {
                    $unbooked_jobs_count++;
                }
            }

            $total_available_days = $days_available * $property_inspector->hours_spent - $unbooked_jobs_count;

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