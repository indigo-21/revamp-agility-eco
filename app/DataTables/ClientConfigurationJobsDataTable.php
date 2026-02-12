<?php

namespace App\DataTables;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientConfigurationJobsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Job> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('status', function (Job $job) {
                return '<span class="right badge badge-' . ($job->jobStatus?->color_scheme ?? 'secondary') . '">' .
                    ($job->jobStatus?->description ?? 'N/A') .
                    '</span>';
            })
            ->addColumn('umr', function (Job $job) {
                return $job->jobMeasure?->umr ?? 'N/A';
            })
            ->addColumn('postcode', function (Job $job) {
                return $job->property?->postcode ?? 'N/A';
            })
            ->addColumn('installer', function (Job $job) {
                $firstname = $job->installer?->user?->firstname;
                $lastname = $job->installer?->user?->lastname;

                return trim(($firstname ?? '') . ' ' . ($lastname ?? '')) ?: ($job->installer?->user?->firstname ?? 'N/A');
            })
            ->editColumn('deadline', function (Job $job) {
                return $job->deadline ?? 'N/A';
            })
            ->rawColumns(['status'])
            ->filterColumn('status', function ($query, $keyword) {
                $query->whereHas('jobStatus', function ($q) use ($keyword) {
                    $q->where('description', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('umr', function ($query, $keyword) {
                $query->whereHas('jobMeasure', function ($q) use ($keyword) {
                    $q->where('umr', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('postcode', function ($query, $keyword) {
                $query->whereHas('property', function ($q) use ($keyword) {
                    $q->where('postcode', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('installer', function ($query, $keyword) {
                $query->whereHas('installer.user', function ($q) use ($keyword) {
                    $q->whereRaw("concat(firstname, ' ', lastname) like ?", ["%{$keyword}%"])
                        ->orWhere('firstname', 'like', "%{$keyword}%")
                        ->orWhere('lastname', 'like', "%{$keyword}%");
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
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy(
                    DB::table('job_statuses')
                        ->select('description')
                        ->whereColumn('job_statuses.id', 'jobs.job_status_id')
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
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Job $model)
    {
        $clientId = (int) request()->route('client_configuration');

        $query = Job::query()
            ->firmDataOnly()
            ->with([
                'property',
                'jobStatus',
                'jobMeasure',
                'installer.user',
            ])
            ->select('jobs.*')
            ->where('client_id', $clientId);

        return $query->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('client-configuration-jobs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'desc')
            ->addTableClass('table table-bordered table-striped')
            ->parameters([
                'processing' => true,
                'serverSide' => true,
                'scrollX' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
                'pageLength' => 10,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('job_number')->title('Job Number'),
            Column::computed('status')->title('Status'),
            Column::make('cert_no')->title('Cert#'),
            Column::computed('umr')->title('UMR'),
            Column::computed('postcode')->title('Postcode'),
            Column::computed('installer')->title('Installer'),
            Column::make('deadline')->title('Deadline'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'ClientJobs_' . date('YmdHis');
    }
}
