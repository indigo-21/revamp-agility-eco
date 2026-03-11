<?php

namespace App\DataTables;

use App\DataTables\Concerns\ExportsAllRows;
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


class MakeBookingsDataTable extends DataTable
{
    use ExportsAllRows;

    protected array $measuresByGroup = [];
    protected array $latestCommentByGroup = [];
    protected array $lastAttemptByGroup = [];


    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Job> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($job) {
                if (empty($job->job_group)) {
                    return '';
                }

                return view('components.make-bookings-actions', [
                    'job' => $job
                ])->render();
            })
            ->addColumn('job_status_id', function ($job) {
                return '<span class="right badge badge-' . ($job->job_status_color ?? 'secondary') . '">' .
                    ($job->job_status_description ?? 'N/A') .
                    '</span>';
            })
            ->addColumn('property_inspector_id', function ($job) {
                return trim($job->property_inspector_name ?? '') ?: 'N/A';
            })
            ->addColumn('postcode', function ($job) {
                return $job->property_postcode ?? 'N/A';
            })
            ->addColumn('address', function ($job) {
                return trim(($job->property_house_flat_prefix ?? '') . ' ' . ($job->property_address1 ?? '')) ?: 'N/A';
            })
            ->addColumn('installer', function ($job) {
                return trim($job->installer_name ?? '') ?: 'N/A';
            })
            ->addColumn('measures', function ($job) {
                if (empty($job->job_group)) {
                    return 'N/A';
                }

                return $this->getMeasuresBadges($job->job_group);
            })
            ->addColumn('customer_name', function ($job) {
                return $job->customer_name_text ?? 'N/A';
            })
            ->addColumn('customer_email', function ($job) {
                return $job->customer_email_text ?? 'N/A';
            })
            ->addColumn('customer_contact', function ($job) {
                return $job->customer_contact_text ?? 'N/A';
            })
            ->addColumn('latest_comment', function ($job) {
                if (empty($job->job_group)) {
                    return 'No comments';
                }

                return $this->getLatestComment($job->job_group);
            })
            ->addColumn('last_attempt', function ($job) {
                if (empty($job->job_group)) {
                    return 'No Attempts Made';
                }

                return $this->getLastAttempt($job->job_group);
            })
            ->orderColumn('job_status_id', function ($query, $order) {
                $query->orderBy('js.description', $order);
            })
            ->orderColumn('property_inspector_id', function ($query, $order) {
                $query->orderBy('pi_user.firstname', $order)
                    ->orderBy('pi_user.lastname', $order);
            })
            ->orderColumn('postcode', function ($query, $order) {
                $query->orderBy('p.postcode', $order);
            })
            ->orderColumn('address', function ($query, $order) {
                $query->orderBy('p.address1', $order);
            })
            ->orderColumn('installer', function ($query, $order) {
                $query->orderBy('ins_user.firstname', $order)
                    ->orderBy('ins_user.lastname', $order);
            })
            ->orderColumn('customer_name', function ($query, $order) {
                $query->orderBy('c.customer_name', $order);
            })
            ->orderColumn('customer_email', function ($query, $order) {
                $query->orderBy('c.customer_email', $order);
            })
            ->orderColumn('customer_contact', function ($query, $order) {
                $query->orderBy('c.customer_primary_tel', $order);
            })
            ->filterColumn('job_group', function ($query, $keyword) {
                $query->where('grouped_jobs.job_group', 'like', "%{$keyword}%");
            })
            ->filterColumn('job_status_id', function ($query, $keyword) {
                $query->where('js.description', 'like', "%{$keyword}%");
            })
            ->filterColumn('property_inspector_id', function ($query, $keyword) {
                $query->whereRaw("concat(pi_user.firstname, ' ', pi_user.lastname) like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('postcode', function ($query, $keyword) {
                $query->where('p.postcode', 'like', "%{$keyword}%");
            })
            ->filterColumn('address', function ($query, $keyword) {
                $query->where('p.address1', 'like', "%{$keyword}%");
            })
            ->filterColumn('installer', function ($query, $keyword) {
                $query->whereRaw("concat(ins_user.firstname, ' ', ins_user.lastname) like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('customer_name', function ($query, $keyword) {
                $query->where('c.customer_name', 'like', "%{$keyword}%");
            })
            ->filterColumn('customer_email', function ($query, $keyword) {
                $query->where('c.customer_email', 'like', "%{$keyword}%");
            })
            ->filterColumn('customer_contact', function ($query, $keyword) {
                $query->where('c.customer_primary_tel', 'like', "%{$keyword}%");
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
        $propertyInspectorId = auth()->user()->propertyInspector?->id;

        $groupedJobsSubquery = Job::query()
            ->firmDataOnly()
            ->selectRaw('MAX(jobs.id) as representative_id')
            ->selectRaw('SUBSTRING(jobs.job_number, 1, LENGTH(jobs.job_number) - 3) as job_group')
            ->whereIn('jobs.job_status_id', [25, 23])
            ->whereNull('jobs.close_date')
            ->whereRaw('LENGTH(jobs.job_number) > 3')
            ->when($propertyInspectorId, function ($innerQuery) use ($propertyInspectorId) {
                return $innerQuery->where('jobs.property_inspector_id', $propertyInspectorId);
            })
            ->groupBy('job_group');

        $query = $model->newQuery();

        $query->joinSub($groupedJobsSubquery, 'grouped_jobs', function ($join) {
            $join->on('jobs.id', '=', 'grouped_jobs.representative_id');
        })
            ->leftJoin('job_statuses as js', 'js.id', '=', 'jobs.job_status_id')
            ->leftJoin('property_inspectors as pi', 'pi.id', '=', 'jobs.property_inspector_id')
            ->leftJoin('users as pi_user', 'pi_user.id', '=', 'pi.user_id')
            ->leftJoin('properties as p', 'p.job_id', '=', 'jobs.id')
            ->leftJoin('installers as ins', 'ins.id', '=', 'jobs.installer_id')
            ->leftJoin('users as ins_user', 'ins_user.id', '=', 'ins.user_id')
            ->leftJoin('customers as c', 'c.job_id', '=', 'jobs.id')
            ->select('jobs.*')
            ->addSelect([
                'grouped_jobs.job_group',
                'js.description as job_status_description',
                'js.color_scheme as job_status_color',
                DB::raw("concat(pi_user.firstname, ' ', pi_user.lastname) as property_inspector_name"),
                'p.postcode as property_postcode',
                'p.address1 as property_address1',
                'p.house_flat_prefix as property_house_flat_prefix',
                DB::raw("concat(ins_user.firstname, ' ', ins_user.lastname) as installer_name"),
                'c.customer_name as customer_name_text',
                'c.customer_email as customer_email_text',
                'c.customer_primary_tel as customer_contact_text',
            ]);

        return $query;
    }

    protected function getMeasuresBadges(string $jobGroup): string
    {
        if (!array_key_exists($jobGroup, $this->measuresByGroup)) {
            $measures = DB::table('jobs as related_jobs')
                ->leftJoin('job_measures', 'job_measures.job_id', '=', 'related_jobs.id')
                ->leftJoin('measures', 'measures.id', '=', 'job_measures.measure_id')
                ->whereIn('related_jobs.job_status_id', [25, 23])
                ->whereRaw('SUBSTRING(related_jobs.job_number, 1, LENGTH(related_jobs.job_number) - 3) = ?', [$jobGroup])
                ->whereNotNull('measures.measure_cat')
                ->distinct()
                ->pluck('measures.measure_cat')
                ->filter()
                ->values();

            $this->measuresByGroup[$jobGroup] = $measures
                ->map(fn ($measure) => '<span class="badge badge-info">' . e($measure) . '</span>')
                ->implode(' ');
        }

        return $this->measuresByGroup[$jobGroup] ?: 'N/A';
    }

    protected function getLatestComment(string $jobGroup): string
    {
        if (!array_key_exists($jobGroup, $this->latestCommentByGroup)) {
            $this->latestCommentByGroup[$jobGroup] = DB::table('bookings')
                ->where('job_number', $jobGroup)
                ->orderByDesc('created_at')
                ->value('booking_notes') ?? 'No comments';
        }

        return $this->latestCommentByGroup[$jobGroup];
    }

    protected function getLastAttempt(string $jobGroup): string
    {
        if (!array_key_exists($jobGroup, $this->lastAttemptByGroup)) {
            $this->lastAttemptByGroup[$jobGroup] = DB::table('bookings')
                ->where('job_number', $jobGroup)
                ->where('booking_outcome', 'Attempt Made')
                ->max('booking_date') ?? 'No Attempts Made';
        }

        return $this->lastAttemptByGroup[$jobGroup] ?: 'No Attempts Made';
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
            Column::make('measures')->title('Measures')->orderable(false)->searchable(false),
            Column::make('first_visit_by')->title('Job First Visit By'),
            Column::make('customer_name')->title('Owner Name'),
            Column::make('customer_email')->title('Owner Email'),
            Column::make('customer_contact')->title('Owner Contact Number'),
            Column::make('latest_comment')->title('Latest Comment')->orderable(false)->searchable(false),
            Column::make('last_attempt')->title('Last Attempt Made')->orderable(false)->searchable(false),
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
