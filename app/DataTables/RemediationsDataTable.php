<?php

namespace App\DataTables;

use App\Enums\FailedQuestion;
use App\Models\Job;
use App\Models\Remediation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
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
            ->filterColumn('umr', function ($query, $keyword) {
                $query->whereHas('jobMeasure', function ($q) use ($keyword) {
                    $q->where('umr', 'like', "%{$keyword}%");
                });
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
            ->addColumn('measure', function ($job) {
                return $job->jobMeasure?->measure?->measure_cat ?? 'N/A';
            })
            ->addColumn('address', function ($job) {
                return ($job->property?->house_flat_prefix ?? '') . ' ' . ($job->property?->address1 ?? '');
            })
            ->addColumn('postcode', function ($job) {
                return $job->property?->postcode ?? 'N/A';
            })
            ->filterColumn('postcode', function ($query, $keyword) {
                $query->whereHas('property', function ($q) use ($keyword) {
                    $q->where('postcode', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('inspection_date', function ($job) {
                return $job->completedJobs->first()->created_at ?? 'N/A';
            })
            ->addColumn('remediation_date', function ($job) {
                return $job->remediation->last()?->created_at;
            })
            ->addColumn('reinspect_deadline', function ($job) {
                return Carbon::parse($job->remediation->last()?->created_at)->addDays(21)->format('Y-m-d H:i:s');
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
            ->orderColumn('measure', function ($query, $order) {
                $query->orderBy(
                    DB::table('measures')
                        ->select('measure_cat')
                        ->join('job_measures', 'job_measures.measure_id', '=', 'measures.id')
                        ->whereColumn('job_measures.job_id', 'jobs.id')
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
            ->orderColumn('postcode', function ($query, $order) {
                $query->orderBy(
                    DB::table('properties')
                        ->select('postcode')
                        ->whereColumn('properties.job_id', 'jobs.id')
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
            ->orderColumn('remediation_date', function ($query, $order) {
                $query->orderBy(
                    DB::table('remediations')
                        ->selectRaw('MAX(created_at)')
                        ->whereColumn('remediations.job_id', 'jobs.id'),
                    $order
                );
            })
            ->orderColumn('reinspect_deadline', function ($query, $order) {
                $query->orderBy(
                    DB::table('remediations')
                        ->selectRaw('DATE_ADD(MAX(created_at), INTERVAL 21 DAY)')
                        ->whereColumn('remediations.job_id', 'jobs.id'),
                    $order
                );
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
        $query = $model->newQuery()->firmDataOnly()->with([
            'completedJobs',
            'remediation',
            'jobStatus',
            'jobMeasure.measure',
            'installer.user',
            'property'
        ]);

        $query->whereIn('job_status_id', [16, 26])
            ->whereHas('completedJobs', function ($q) {
                $q->whereIn('pass_fail', FailedQuestion::values())
                    ->where(function ($subQ) {
                        // Case 1: No remediations at all
                        $subQ->whereHas('remediations', function ($q2) {
                            $q2->where(function ($query) {
                                    $query->whereIn('role', ['Installer', 'INSTALLER'])
                                        ->orWhereNull('role')
                                        ->orWhere(function ($q3) {
                                            $q3->where('role', 'Agent')
                                               ->where('comment', 'not like', '%Agent updated the survey%');
                                        });
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
            ->dom('Blfrtip')
            ->parameters([
                'scrollX' => true, // Enable horizontal scrolling if needed
                // 'responsive' => true,
                'autoWidth' => true,
                 'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                'pageLength' => 10,
            ])
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                Button::make('csv')
                    ->text('CSV')
                    ->action("function (e, dt, node, config) {\n    var params = dt.ajax.params();\n\n    params.search = params.search || {};\n    params.search.value = dt.search() || '';\n    params.search.regex = false;\n\n    params.columns = params.columns || [];\n    params.columns.forEach(function (col, idx) {\n        col.search = col.search || {};\n        col.search.value = dt.column(idx).search() || '';\n        col.search.regex = false;\n    });\n\n    var form = $('<form>', {\n        method: 'POST',\n        action: '".route('remediation-review.export.csv')."'\n    });\n\n    var token = $('meta[name=\"csrf-token\"]').attr('content');\n    if (token) {\n        form.append($('<input>', { type: 'hidden', name: '_token', value: token }));\n    }\n\n    var appendInputs = function (prefix, value) {\n        if (Array.isArray(value)) {\n            value.forEach(function (v, i) {\n                appendInputs(prefix + '[' + i + ']', v);\n            });\n            return;\n        }\n\n        if (value !== null && typeof value === 'object') {\n            Object.keys(value).forEach(function (k) {\n                appendInputs(prefix + '[' + k + ']', value[k]);\n            });\n            return;\n        }\n\n        form.append($('<input>', { type: 'hidden', name: prefix, value: value }));\n    };\n\n    Object.keys(params).forEach(function (key) {\n        appendInputs(key, params[key]);\n    });\n\n    $('body').append(form);\n    form.submit();\n}"),
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
            Column::make('inspection_date')
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
