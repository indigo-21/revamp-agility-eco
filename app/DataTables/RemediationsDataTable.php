<?php

namespace App\DataTables;

use App\Enums\FailedQuestion;
use App\Models\Job;
use App\Models\Remediation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RemediationsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Remediation> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($job) {
                return view('components.reminder-exceptions-actions', [
                    'job' => $job
                ])->render();
            })
            ->addColumn('job_status_id', function ($job) {
                return '<span class="right badge badge-' . ($job->jobStatus->color_scheme ?? 'secondary') . '">' .
                    ($job->jobStatus->description ?? 'N/A') .
                    '</span>';
            })
            ->addColumn('umr', function ($job) {
                return $job->jobMeasure?->umr ?? 'N/A';
            })
            ->addColumn('installer', function ($job) {
                return $job->installer?->user?->firstname ?? 'N/A';
            })
            ->addColumn('measure', function ($job) {
                return $job->jobMeasure?->measure?->measure_cat ?? 'N/A';
            })
            ->addColumn('address', function ($job) {
                return $job->property?->address1 ?? 'N/A';
            })
            ->addColumn('postcode', function ($job) {
                return $job->property?->postcode ?? 'N/A';
            })
            ->addColumn('remediation_date', function ($job) {
                return $job->remediation->last()?->created_at;
            })
            ->addColumn('reinspect_deadline', function ($job) {
                return Carbon::parse($job->remediation->last()?->created_at)->addDays(21)->format('Y-m-d H:i:s');
            })
            ->rawColumns(['job_status_id', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Remediation>
     */
    public function query(Job $model): QueryBuilder
    {
        $query = $model->newQuery()->with([
            'completedJobs',
            'remediation'
        ]);

        $query->whereIn('job_status_id', [16, 26])
            ->whereHas('completedJobs', function ($q) {
                $q->whereIn('pass_fail', FailedQuestion::values())
                    ->where(function ($subQ) {
                        // Case 1: No remediations at all
                        $subQ->whereHas('remediations', function ($q2) {
                            $q2->where(function ($query) {
                                $query->where('role', 'Installer')
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
            ->setTableId('remediations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->addTableClass('table table-bordered table-striped text-center')
            ->dom('Bfrtip')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => true,
            ])
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                Button::make('csv'),
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
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
            Column::make('job_number'),
            Column::make('job_status_id')
                ->title('Status'),
            Column::make('cert_no'),
            Column::make('umr')
                ->title('UMR')
                ->orderable(true),
            Column::make('installer'),
            Column::make('measure'),
            Column::make('address'),
            Column::make('postcode'),
            Column::make('job_remediation_type')
                ->title('Non-Compliance Type'),
            Column::make('schedule_date')
                ->title('Inspection Date'),
            Column::make('remediation_date')
                ->title('Evidence Submission Date'),
            Column::make('rework_deadline'),
            Column::make('reinspect_deadline')
                ->title('Reinspect Deadline'),
            Column::make('action')
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
        return 'Remediations_' . date('YmdHis');
    }
}
