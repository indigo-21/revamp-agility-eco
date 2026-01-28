<?php

namespace App\DataTables;

use App\Enums\FailedQuestion;
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

class ReminderExceptionsDataTable extends DataTable
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
            ->addColumn('sent_reminder', function ($job) {
                return $job->sent_reminder ? 'Yes' : 'No';
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
            ->orderColumn('sent_reminder', function ($query, $order) {
                $query->orderBy('sent_reminder', $order);
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
            'completedJobs',
            'remediation',
            'jobStatus',
            'propertyInspector.user',
            'property',
            'installer.user',
            'customer',
            'jobMeasure.measure',
        ]);

        // Add a computed job_group column (first part of job_number) so actions/components
        // that expect `job_group` can build routes correctly.
        $query->selectRaw('*, SUBSTRING(job_number, 1, LENGTH(job_number) - 3) as job_group');

        $query->whereIn('job_status_id', [16, 26])
            ->whereHas('completedJobs', function ($q) {
                $q->whereIn('pass_fail', FailedQuestion::values())
                    ->where(function ($subQ) {
                        // Case 1: No remediations at all
                        $subQ->whereHas('remediations', function ($q2) {
                            $q2->where(function ($query) {
                                $query->whereIn('role', ['Installer', 'INSTALLER'])
                                    ->orWhereNull('role');
                            })
                                ->whereRaw('id = (SELECT id FROM remediations WHERE completed_job_id = completed_jobs.id ORDER BY created_at DESC LIMIT 1)');
                        });
                    });
            });

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('reminderexceptions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->addTableClass('table table-bordered table-striped text-center')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => true,
            ])
            ->selectStyleSingle()
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
            Column::make('measures')->title('Measures')->orderable(false),
            Column::make('first_visit_by')->title('Job First Visit By'),
            Column::make('customer_name')->title('Owner Name'),
            Column::make('customer_email')->title('Owner Email'),
            Column::make('customer_contact')->title('Owner Contact Number'),
            Column::make('latest_comment')->title('Latest Comment')->orderable(false),
            Column::make('last_attempt')->title('Last Attempt Made')->orderable(false),
            Column::make('max_attempts')->title('Job Max Attempts'),
            Column::make('rework_deadline')->title('Revisit'),
            Column::make('sent_reminder')->title('Reminder Sent'),
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
        return 'ReminderExceptions_' . date('YmdHis');
    }
}
