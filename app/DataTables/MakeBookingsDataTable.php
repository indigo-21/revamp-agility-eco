<?php

namespace App\DataTables;

use App\Models\Booking;
use App\Models\Job;
use App\Models\PropertyInspector;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MakeBookingsDataTable extends DataTable
{
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
                return $job->propertyInspector->user->firstname . ' ' . $job->propertyInspector->user->lastname;
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
                $measureData = "";

                $relatedJobs = Job::where(
                    'job_number',
                    'LIKE',
                    "%{$job->job_group}%",
                )
                    ->whereIn('job_status_id', [25, 23])
                    ->get();

                foreach ($relatedJobs as $relatedJob) {
                    $measureData .= '<span class="badge badge-info">' . $relatedJob->jobMeasure?->measure?->measure_cat . '</span>';
                }

                return $measureData ?? 'N/A';
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
                $lastBooking = Booking::where(
                    'job_number',
                    $job->job_group,
                )->orderBy('created_at', 'desc');

                return $lastBooking->first()->booking_notes ?? 'No comments';
            })
            ->addColumn('last_attempt', function ($job) {
                $lastBooking = Booking::where(
                    'job_number',
                    $job->job_group,
                )->orderBy('created_at', 'desc');

                return $lastBooking->where('booking_outcome', 'Attempt Made')->first()->booking_date ?? 'No Attempts Made';
            })
            ->rawColumns(['action', 'job_status_id', 'measures'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Job>
     */
    public function query(Job $model): QueryBuilder
    {
        $query = $model->newQuery()->with([
            'propertyInspector.user',
            'jobStatus',
            'jobMeasure.measure',
            'property',
            'installer.user',
            'customer'
        ]);

        $propertyInspector = PropertyInspector::find(auth()->user()->propertyInspector?->id);

        $query->selectRaw('*, SUBSTRING(job_number, 1, LENGTH(job_number) - 3) as job_group')
            ->groupBy('job_group')
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
              ->minifiedAjax(
                app()->environment('production')
                ? secure_url(request()->path())
                : url(request()->path())
            )
            ->orderBy(1)
            ->selectStyleSingle()
            ->addTableClass('table table-bordered table-striped text-center')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                'responsive' => true,
                'autoWidth' => false,
            ])
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
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
            Column::make('job_group')->title('Job Number'),
            Column::make('job_status_id')->title('Job Status'),
            Column::make('property_inspector_id')->title('Job PI'),
            Column::make('postcode')->title('Postcode'),
            Column::make('address')->title('Address'),
            Column::make('installer')->title('Installer'),
            Column::make('measures')->title('Measures'),
            Column::make('first_visit_by')->title('Job First Visit By'),
            Column::make('customer_name')->title('Owner Name'),
            Column::make('customer_email')->title('Owner Email'),
            Column::make('customer_contact')->title('Owner Contact Number'),
            Column::make('latest_comment')->title('Latest Comment'),
            Column::make('last_attempt')->title('Last Attempt Made'),
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
