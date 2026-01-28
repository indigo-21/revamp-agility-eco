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
            ->filterColumn('installer', function ($query, $keyword) {
                $query->whereHas('installer', function ($installerQ) use ($keyword) {
                    $installerQ->whereHas('user', function ($userQ) use ($keyword) {
                        $userQ->where(function ($subQ) use ($keyword) {
                            $subQ->where('firstname', 'like', "%{$keyword}%")
                                ->orWhere('lastname', 'like', "%{$keyword}%")
                                ->orWhere('email', 'like', "%{$keyword}%");
                        });
                    });
                });
            })
            ->addColumn('address', function ($job) {
                return ($job->property?->house_flat_prefix ?? '') . ' ' . ($job->property?->address1 ?? '') . ' ' . ($job->property?->address2 ?? '') . ' ' . ($job->property?->address3 ?? '');
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
        $query = $model->newQuery()->with([
            'jobMeasure.measure',
            'jobStatus',
            'propertyInspector.user',
            'installer.user',
            'property',
        ]);

        $query = $query->where('invoice_status_id', 2);

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
            ->dom('Blfrtip')
            ->addTableClass('table table-bordered table-striped text-center')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                'pageLength' => 10,
            ])
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                Button::make('csv')
                    ->text('CSV')
                    ->action("function (e, dt, node, config) {\n    var params = dt.ajax.params();\n\n    params.search = params.search || {};\n    params.search.value = dt.search() || '';\n    params.search.regex = false;\n\n    params.columns = params.columns || [];\n    params.columns.forEach(function (col, idx) {\n        col.search = col.search || {};\n        col.search.value = dt.column(idx).search() || '';\n        col.search.regex = false;\n    });\n\n    var form = $('<form>', {\n        method: 'POST',\n        action: '".route('update-survey.export.csv')."'\n    });\n\n    var token = $('meta[name=\"csrf-token\"]').attr('content');\n    if (token) {\n        form.append($('<input>', { type: 'hidden', name: '_token', value: token }));\n    }\n\n    var appendInputs = function (prefix, value) {\n        if (Array.isArray(value)) {\n            value.forEach(function (v, i) {\n                appendInputs(prefix + '[' + i + ']', v);\n            });\n            return;\n        }\n\n        if (value !== null && typeof value === 'object') {\n            Object.keys(value).forEach(function (k) {\n                appendInputs(prefix + '[' + k + ']', value[k]);\n            });\n            return;\n        }\n\n        form.append($('<input>', { type: 'hidden', name: prefix, value: value }));\n    };\n\n    Object.keys(params).forEach(function (key) {\n        appendInputs(key, params[key]);\n    });\n\n    $('body').append(form);\n    form.submit();\n}"),
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
            Column::make('measure'),
            Column::make('cert_no'),
            Column::make('umr')
                ->title('UMR'),
            Column::make('propertyInspector')
                ->title('Property Inspector'),
            Column::make('first_visit_by')
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
