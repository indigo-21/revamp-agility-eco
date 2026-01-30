<?php

namespace App\DataTables;

use App\DataTables\Concerns\ExportsAllRows;
use App\Models\Booking;
use App\Models\Job;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JobsDataTable extends DataTable
{
    use ExportsAllRows;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Job> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($job) {
                return view('components.job-actions', [
                    'job' => $job
                ])->render();
            })
            ->addColumn('umr', function ($job) {
                return $job->jobMeasure?->umr ?? 'N/A';
            })
            ->addColumn('job_status_id', function ($job) {
                return '<span class="right badge badge-' . ($job->jobStatus?->color_scheme ?? 'secondary') . '">' .
                    ($job->jobStatus?->description ?? 'N/A') .
                    '</span>';
            })
            ->rawColumns(['job_status_id', 'action'])
            ->addColumn('propertyInspector', function ($job) {
                $firstname = $job->propertyInspector?->user?->firstname;
                $lastname = $job->propertyInspector?->user?->lastname;

                return trim(($firstname ?? '') . ' ' . ($lastname ?? '')) ?: 'N/A';
            })
            ->addColumn('booked_date', function ($job) {
                return $job->bookings ?? 'N/A';
            })
            ->addColumn('postcode', function ($job) {
                return $job->property?->postcode ?? 'N/A';
            })
            ->addColumn('installer', function ($job) {
                return $job->installer?->user?->firstname ?? 'N/A';
            })
            ->addColumn('reminder', function ($job) {
                return $job->sent_reminder === 1 ? 'Yes' : 'No';
            })
            ->addColumn('invoice_status_id', function ($job) {
                return $job->invoiceStatus?->name ?? 'N/A';
            })
            ->addColumn('booked_date', function ($job) {
                if (empty($job->job_number) || strlen($job->job_number) < 3) {
                    return 'N/A';
                }

                $jobGroup = substr($job->job_number, 0, strlen($job->job_number) - 3);

                $booking = Booking::where('job_number', 'LIKE', "%{$jobGroup}%")
                    ->where('booking_outcome', 'Booked')
                    ->latest();

                return $booking->exists() ? $booking->first()->booking_date : 'N/A';
            })

            ->filterColumn('job_status_id', function ($query, $keyword) {
                $query->whereHas('jobStatus', function ($q) use ($keyword) {
                    $q->where('description', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('propertyInspector', function ($query, $keyword) {
                $query->whereHas('propertyInspector.user', function ($q) use ($keyword) {
                    $q->whereRaw("concat(firstname, ' ', lastname) like ?", ["%{$keyword}%"])
                        ->orWhere('firstname', 'like', "%{$keyword}%")
                        ->orWhere('lastname', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('installer', function ($query, $keyword) {
                $query->whereHas('installer.user', function ($q) use ($keyword) {
                    $q->whereRaw("concat(firstname, ' ', lastname) like ?", ["%{$keyword}%"])
                        ->orWhere('firstname', 'like', "%{$keyword}%")
                        ->orWhere('lastname', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('postcode', function ($query, $keyword) {
                $query->whereHas('property', function ($q) use ($keyword) {
                    $q->where('postcode', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('umr', function ($query, $keyword) {
                $query->whereHas('jobMeasure', function ($q) use ($keyword) {
                    $q->where('umr', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('invoice_status_id', function ($query, $keyword) {
                $query->whereHas('invoiceStatus', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->orderColumn('umr', function ($query, $order) {
                $query->orderBy(
                    DB::table('job_measures')
                        ->select('umr')
                        ->whereColumn('job_measures.job_id', 'jobs.id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('job_status_id', function ($query, $order) {
                $query->orderBy(
                    DB::table('job_statuses')
                        ->select('description')
                        ->whereColumn('job_statuses.id', 'jobs.job_status_id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('propertyInspector', function ($query, $order) {
                $query->orderBy(
                    DB::table('users')
                        ->selectRaw("concat(users.firstname, ' ', users.lastname)")
                        ->join('property_inspectors', 'property_inspectors.user_id', '=', 'users.id')
                        ->whereColumn('property_inspectors.id', 'jobs.property_inspector_id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('postcode', function ($query, $order) {
                $query->orderBy(
                    DB::table('properties')
                        ->select('postcode')
                        ->whereColumn('properties.job_id', 'jobs.id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('installer', function ($query, $order) {
                $query->orderBy(
                    DB::table('users')
                        ->selectRaw("concat(users.firstname, ' ', users.lastname)")
                        ->join('installers', 'installers.user_id', '=', 'users.id')
                        ->whereColumn('installers.id', 'jobs.installer_id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('invoice_status_id', function ($query, $order) {
                $query->orderBy(
                    DB::table('invoice_statuses')
                        ->select('name')
                        ->whereColumn('invoice_statuses.id', 'jobs.invoice_status_id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('reminder', function ($query, $order) {
                $query->orderBy('sent_reminder', $order);
            })
            ->orderColumn('booked_date', function ($query, $order) {
                $query->orderBy(
                    DB::table('bookings')
                        ->selectRaw('MAX(booking_date)')
                        ->where('booking_outcome', 'Booked')
                        ->whereRaw("bookings.job_number LIKE CONCAT('%', SUBSTRING(jobs.job_number, 1, LENGTH(jobs.job_number) - 3), '%')"),
                    $order
                );
            })

            ->filterColumn('job_status_id', function ($query, $keyword) {
                $query->whereHas('jobStatus', function ($q) use ($keyword) {
                    $q->where('description', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('propertyInspector', function ($query, $keyword) {
                $query->whereHas('propertyInspector.user', function ($q) use ($keyword) {
                    $q->whereRaw("concat(firstname, ' ', lastname) like ?", ["%{$keyword}%"])
                        ->orWhere('firstname', 'like', "%{$keyword}%")
                        ->orWhere('lastname', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('installer', function ($query, $keyword) {
                $query->whereHas('installer.user', function ($q) use ($keyword) {
                    $q->whereRaw("concat(firstname, ' ', lastname) like ?", ["%{$keyword}%"])
                        ->orWhere('firstname', 'like', "%{$keyword}%")
                        ->orWhere('lastname', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('postcode', function ($query, $keyword) {
                $query->whereHas('property', function ($q) use ($keyword) {
                    $q->where('postcode', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('umr', function ($query, $keyword) {
                $query->whereHas('jobMeasure', function ($q) use ($keyword) {
                    $q->where('umr', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('invoice_status_id', function ($query, $keyword) {
                $query->whereHas('invoiceStatus', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Job>
     */
    public function query(Job $model): QueryBuilder
    {
        $request = request();

        $query = $model->newQuery()
            ->firmDataOnly()
            ->with(['jobMeasure', 'jobStatus', 'propertyInspector.user', 'property', 'installer.user', 'client', 'invoiceStatus']);

        // Apply filters based on request parameters
        if ($request->filled('job_status_id')) {
            $query->where('job_status_id', $request->job_status_id);
        }

        if ($request->filled('client')) {
            $query->where('client_id', $request->client);
        }

        if ($request->filled('outward_postcode')) {
            $query->whereHas('property', function ($q) use ($request) {
                $q->where('postcode', 'LIKE', $request->outward_postcode . '%');
            });
        }

        // Date range filter
        if ($request->filled('job_date_range')) {
            $dateRange = $request->job_date_range;
            $dates = explode(' - ', $dateRange);
            $startDate = $dates[0] ?? null;
            $endDate = $dates[1] ?? null;

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Job filter radio buttons
        if ($request->filled('job_filter')) {
            switch ($request->job_filter) {
                case '1': // Open Jobs
                    $query->whereNull('close_date');
                    break;
                case '2': // Closed Jobs
                    $query->whereNotNull('close_date');
                    break;
                case '3': // NC > 28 Days
                    $query->where('completed_survey_date', '<=', now()->subDays(28));
                    break;
                case '4': // All Jobs (default)
                default:
                    // No additional filter
                    break;
            }
        }

        return $query;
    }

    /**
     * Get total count of jobs
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->query(new Job())->count();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jobs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->selectStyleSingle()
            ->dom('Blfrtip')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => true,
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                'pageLength' => 10,
            ])
            ->buttons([
                // Button::make('excel'),
                Button::make('csv')
                    ->text('CSV')
                    ->action("function (e, dt, node, config) {\n    var params = dt.ajax.params();\n    var urlParams = new URLSearchParams(window.location.search);\n\n    params.search = params.search || {};\n    params.search.value = dt.search() || '';\n    params.search.regex = false;\n\n    params.columns = params.columns || [];\n    params.columns.forEach(function (col, idx) {\n        col.search = col.search || {};\n        col.search.value = dt.column(idx).search() || '';\n        col.search.regex = false;\n    });\n\n    urlParams.forEach(function (value, key) {\n        params[key] = value;\n    });\n\n    var form = $('<form>', {\n        method: 'POST',\n        action: '".route('job.export.csv.post')."'\n    });\n\n    var token = $('meta[name=\"csrf-token\"]').attr('content');\n    if (token) {\n        form.append($('<input>', { type: 'hidden', name: '_token', value: token }));\n    }\n\n    var appendInputs = function (prefix, value) {\n        if (Array.isArray(value)) {\n            value.forEach(function (v, i) {\n                appendInputs(prefix + '[' + i + ']', v);\n            });\n            return;\n        }\n\n        if (value !== null && typeof value === 'object') {\n            Object.keys(value).forEach(function (k) {\n                appendInputs(prefix + '[' + k + ']', value[k]);\n            });\n            return;\n        }\n\n        form.append($('<input>', { type: 'hidden', name: prefix, value: value }));\n    };\n\n    Object.keys(params).forEach(function (key) {\n        appendInputs(key, params[key]);\n    });\n\n    $('body').append(form);\n    form.submit();\n}"),
                // Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('id')
                ->title('Job ID'),
            Column::make('job_number'),
            Column::make('cert_no'),
            Column::computed('umr')
                ->title('UMR')
                ->orderable(true)
                ->searchable(true),
            Column::computed('job_status_id')
                ->title('Status')
                ->searchable(true),
            Column::computed('propertyInspector')
                ->title('Property Inspector')
                ->orderable(true)
                ->searchable(true),
            Column::computed('booked_date'),
            Column::computed('postcode')
                ->searchable(true),
            Column::computed('installer')
                ->searchable(true),
            Column::make('rework_deadline'),
            Column::make('job_remediation_type'),
            Column::make('close_date'),
            Column::make('deadline'),
            Column::make('invoice_status_id')
                ->title('Invoice Status')
                ->searchable(true),
            Column::computed('reminder')
                ->title('28-Reminder'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Jobs_' . date('YmdHis');
    }
}
