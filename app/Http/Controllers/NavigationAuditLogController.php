<?php

namespace App\Http\Controllers;

use App\DataTables\NavigationAuditLogsDataTable;
use Illuminate\Http\Request;

class NavigationAuditLogController extends Controller
{
    public function index(NavigationAuditLogsDataTable $dataTable, Request $request)
    {
        if ((int) (auth()->user()?->account_level_id ?? 0) !== 1) {
            abort(403, 'Unauthorized');
        }

        return $dataTable->render('pages.platform-configuration.navigation-audit-log.index');
    }
}
