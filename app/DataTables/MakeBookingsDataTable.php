<?php

namespace App\DataTables;

use App\DataTables\Concerns\ExportsAllRows;
use App\Models\Job;
use App\Models\PropertyInspector;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class MakeBookingsDataTable extends DataTable
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
                return view('components.make-bookings-actions', [
                    'job' => $job
                ])->render();
            })
            ->addColumn('job_status_id', function ($job) {
                return '<span class="right badge badge-' . ($job->jobStatus->color_scheme ?? 'secondary') . '">' .
                    ($job->jobStatus->description ?? 'N/A') .
                    '</span>';
            })
            ->addColumn('property_inspector_id', function ($job) {
                $firstname = $job->propertyInspector?->user?->firstname;
                $lastname = $job->propertyInspector?->user?->lastname;

                return trim(($firstname ?? '') . ' ' . ($lastname ?? '')) ?: 'N/A';
            })
            ->addColumn('postcode', function ($job) {
                return $job->property?->postcode ?? 'N/A';
            })
            ->addColumn('address', function ($job) {
                return ($job->property?->house_flat_prefix ?? '') . ' ' . ($job->property?->address1 ?? '');
            })
            ->addColumn('installer', function ($job) {
                return $job->installer->user->firstname ?? 'N/A';
            })
            ->addColumn('measures', function ($job) {
                if (empty($job->measures_list)) {
                    return 'N/A';
                }

                $measureData = collect(explode('||', $job->measures_list))
                    ->filter()
                    ->unique()
                    ->map(fn ($measure) => '<span class="badge badge-info">' . e($measure) . '</span>')
                    ->implode(' ');

                return $measureData ?: 'N/A';
            })
            ->addColumn('customer_name', function ($job) {
                return $job->customer?->customer_name ?? 'N/A';
            })
            ->addColumn('customer_email', function ($job) {
                return $job->customer?->customer_email ?? 'N/A';
            })
            ->addColumn('customer_contact', function ($job) {
                return $job->customer?->customer_primary_tel ?? 'N/A';
            })
            ->addColumn('latest_comment', function ($job) {
                return $job->latest_comment ?? 'No comments';
            })
            ->addColumn('last_attempt', function ($job) {
                return $job->last_attempt ?? 'No Attempts Made';
            })
            ->orderColumn('job_status_id', function ($query, $order) {
                $query->orderBy('job_status_id', $order);
            })
            ->orderColumn('property_inspector_id', function ($query, $order) {
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
            ->orderColumn('address', function ($query, $order) {
                $query->orderBy(
                    DB::table('properties')
                        ->select('address1')
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
            ->orderColumn('customer_name', function ($query, $order) {
                $query->orderBy(
                    DB::table('customers')
                        ->select('customer_name')
                        ->whereColumn('customers.job_id', 'jobs.id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('customer_email', function ($query, $order) {
                $query->orderBy(
                    DB::table('customers')
                        ->select('customer_email')
                        ->whereColumn('customers.job_id', 'jobs.id')
                        ->limit(1),
                    $order
                );
            })
            ->orderColumn('customer_contact', function ($query, $order) {
                $query->orderBy(
                    DB::table('customers')
                        ->select('customer_primary_tel')
                        ->whereColumn('customers.job_id', 'jobs.id')
                        ->limit(1),
                    $order
                );
            })
            ->filterColumn('job_group', function($query, $keyword) {
                $query->whereRaw("SUBSTRING(job_number, 1, LENGTH(job_number) - 3) LIKE ?", ["%$keyword%"]);
            })
            ->filterColumn('property_inspector_id', function ($query, $keyword) {
                $query->whereHas('propertyInspector.user', function ($q) use ($keyword) {
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
            ->rawColumns(['action', 'job_status_id', 'measures', 'latest_comment', 'last_attempt'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Job>
     */
    public function query(Job $model): QueryBuilder
    {
        $query = $model->newQuery()->firmDataOnly()->with([
            'propertyInspector.user',
            'jobStatus',
            'property',
            'installer.user',
            'customer'
        ]);

        $propertyInspector = PropertyInspector::find(auth()->user()->propertyInspector?->id);

        $query->selectRaw('jobs.*, SUBSTRING(jobs.job_number, 1, LENGTH(jobs.job_number) - 3) as job_group')
            ->selectRaw("(
                SELECT GROUP_CONCAT(DISTINCT measures.measure_cat SEPARATOR '||')
                FROM jobs related_jobs
                LEFT JOIN job_measures ON job_measures.job_id = related_jobs.id
                LEFT JOIN measures ON measures.id = job_measures.measure_id
                WHERE SUBSTRING(related_jobs.job_number, 1, LENGTH(related_jobs.job_number) - 3) = SUBSTRING(jobs.job_number, 1, LENGTH(jobs.job_number) - 3)
                  AND related_jobs.job_status_id IN (25, 23)
            ) as measures_list")
            ->selectRaw("(
                SELECT bookings.booking_notes
                FROM bookings
                WHERE bookings.job_number = SUBSTRING(jobs.job_number, 1, LENGTH(jobs.job_number) - 3)
                ORDER BY bookings.created_at DESC
                LIMIT 1
            ) as latest_comment")
            ->selectRaw("(
                SELECT bookings.booking_date
                FROM bookings
                WHERE bookings.job_number = SUBSTRING(jobs.job_number, 1, LENGTH(jobs.job_number) - 3)
                  AND bookings.booking_outcome = 'Attempt Made'
                ORDER BY bookings.created_at DESC
                LIMIT 1
            ) as last_attempt")
            ->groupBy(DB::raw('SUBSTRING(job_number, 1, LENGTH(job_number) - 3)'))
            ->whereIn('job_status_id', [25, 23])
            ->where('close_date', null)
            ->when($propertyInspector, function ($query) use ($propertyInspector) {
                return $query->where('property_inspector_id', $propertyInspector->id);
            });

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('makebookings-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->dom('Blfrtip')
            ->addTableClass('table table-bordered table-striped text-center')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => true,
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                'pageLength' => 10,
            ])
            ->buttons([
                Button::make('csv')
                    ->text('CSV')
                    ->action($this->exportAllAction('csv')),
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
            Column::make('job_group')->title('Job Number')->searchable(true),
            Column::make('job_status_id')->title('Job Status'),
            Column::make('property_inspector_id')->title('Job PI')->searchable(true)->orderable(true),
            Column::make('postcode')->title('Postcode')->searchable(true),
            Column::make('address')->title('Address'),
            Column::make('installer')->title('Installer'),
            Column::make('measures')->title('Measures')->orderable(false),
            Column::make('first_visit_by')->title('Job First Visit By'),
            Column::make('customer_name')->title('Owner Name'),
            Column::make('customer_email')->title('Owner Email'),
            Column::make('customer_contact')->title('Owner Contact Number'),
            Column::make('latest_comment')->title('Latest Comment')->orderable(false),
            Column::make('last_attempt')->title('Last Attempt Made')->orderable(false),
            Column::make('max_attempts')->title('Job Max Attempts'),
            Column::make('rework_deadline')->title('Revisit'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MakeBookings_' . date('YmdHis');
    }
}
