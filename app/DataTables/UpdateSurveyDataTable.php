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

class UpdateSurveyDataTable extends DataTable
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
                return view('components.update-survey-actions', [
                    'job' => $job
                ])->render();
            })
            ->addColumn('measure', function ($job) {
                return $job->jobMeasure?->measure?->measure_cat ?? 'N/A';
            })
            ->addColumn('umr', function ($job) {
                return $job->jobMeasure?->umr ?? 'N/A';
            })
            ->addColumn('job_status_id', function ($job) {
                return '<span class="right badge badge-' . ($job->jobStatus->color_scheme ?? 'secondary') . '">' .
                    ($job->jobStatus->description ?? 'N/A') .
                    '</span>';
            })
            ->addColumn('propertyInspector', function ($job) {
                return $job->propertyInspector?->user->firstname . ' ' .
                    $job->propertyInspector?->user->lastname;
            })
            ->addColumn('installer', function ($job) {
                return $job->installer?->user?->firstname ?? 'N/A';
            })
            ->addColumn('address', function ($job) {
                return $job->property?->address1 ?? 'N/A';
            })
            ->addColumn('postcode', function ($job) {
                return $job->property?->postcode ?? 'N/A';
            })
            ->rawColumns(['job_status_id', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Job>
     */
    public function query(Job $model): QueryBuilder
    {
        $query = $model->newQuery();

        $query = $query->whereIn('job_status_id', [3, 16, 26]);

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('updatesurvey-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->addTableClass('table table-bordered table-striped text-center')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => false,
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
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
            Column::make('job_number'),
            Column::make('job_status_id')
                ->title('Status'),
            Column::make('measure'),
            Column::make('cert_no'),
            Column::make('umr')
                ->title('UMR'),
            Column::make('propertyInspector')
                ->title('Property Inspector'),
            Column::make('schedule_date')
                ->title('Inspection Date'),
            Column::make('installer'),
            Column::make('address'),
            Column::make('postcode'),
            Column::make('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

            // Column::make('add your columns'),
            // Column::make('created_at'),
               // Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UpdateSurvey_' . date('YmdHis');
    }
}
