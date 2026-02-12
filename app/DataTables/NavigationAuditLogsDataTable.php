<?php

namespace App\DataTables;

use App\Models\NavigationAuditLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NavigationAuditLogsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<NavigationAuditLog> $query
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user', function (NavigationAuditLog $log) {
                $name = trim(($log->user?->firstname ?? '') . ' ' . ($log->user?->lastname ?? ''));
                $email = $log->user?->email;

                return trim(($name ?: 'N/A') . ($email ? " ({$email})" : ''));
            })
            ->addColumn('profile', function (NavigationAuditLog $log) {
                return $log->accountLevel?->name
                    ?? $log->user?->accountLevel?->name
                    ?? 'N/A';
            })
            ->editColumn('allowed', function (NavigationAuditLog $log) {
                return $log->allowed ? 'Yes' : 'No';
            })
            ->editColumn('created_at', function (NavigationAuditLog $log) {
                return $log->created_at?->format('Y-m-d H:i:s');
            })
            ->rawColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(NavigationAuditLog $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['user.accountLevel', 'accountLevel', 'navigation'])
            ->select('navigation_audit_logs.*')
            ->latest('created_at');

        $allowed = request()->query('allowed');
        if (in_array($allowed, ['0', '1'], true)) {
            $query->where('allowed', $allowed === '1');
        }

        if ($user = request()->query('user')) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('email', 'like', "%{$user}%")
                    ->orWhere('firstname', 'like', "%{$user}%")
                    ->orWhere('lastname', 'like', "%{$user}%");
            });
        }

        if ($link = request()->query('link')) {
            $query->where('navigation_link', 'like', "%{$link}%");
        }

        if ($from = request()->query('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = request()->query('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('navigation-audit-logs-table')
            ->columns($this->getColumns())
            ->minifiedAjax(request()->fullUrl())
            ->orderBy(0, 'desc')
            ->addTableClass('table table-bordered table-striped')
            ->parameters([
                'scrollX' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
                'pageLength' => 25,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('created_at')->title('Date/Time'),
            Column::computed('user')->title('User')->orderable(false),
            Column::computed('profile')->title('Profile')->orderable(false),
            Column::make('navigation_link')->title('Page (link)'),
            Column::make('method')->title('Method'),
            Column::make('uri')->title('URI'),
            Column::make('allowed')->title('Allowed'),
            Column::make('status_code')->title('Status'),
            Column::make('ip')->title('IP'),
            Column::make('user_agent')->title('User Agent')->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'NavigationAuditLogs_' . date('YmdHis');
    }
}
