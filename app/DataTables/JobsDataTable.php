<?php

namespace App\DataTables;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JobsDataTable extends DataTable
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
                return view('components.job-actions', [
                    'job' => $job
                ])->render();
            })
            ->addColumn('umr', function ($job) {
                return $job->jobMeasure?->umr ?? 'N/A';
            })
            ->addColumn('job_status_id', function ($job) {
                return '<span class="right badge badge-' . ($job->jobStatus->color_scheme ?? 'secondary') . '">' .
                    ($job->jobStatus->description ?? 'N/A') .
                    '</span>';
            })
            ->rawColumns(['job_status_id', 'action'])
            ->addColumn('propertyInspector', function ($job) {
                return $job->propertyInspector?->user->firstname . ' ' .
                    $job->propertyInspector?->user->lastname;
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
            ->with(['jobMeasure', 'jobStatus', 'propertyInspector.user', 'property', 'installer.user', 'client']);

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
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => true,
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
                ->orderable(true),
            Column::computed('job_status_id')
                ->title('Status'),
            Column::computed('propertyInspector')
                ->title('Property Inspector')
                ->orderable(true)
                ->searchable(true),
            Column::computed('booked_date'),
            Column::computed('postcode'),
            Column::computed('installer'),
            Column::make('rework_deadline'),
            Column::make('job_remediation_type'),
            Column::make('close_date'),
            Column::make('deadline'),
            Column::make('invoice_status'),
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
