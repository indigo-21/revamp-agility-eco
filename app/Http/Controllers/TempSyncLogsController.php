<?php

namespace App\Http\Controllers;

use App\Models\TempSyncLogs;
use Illuminate\Http\Request;

class TempSyncLogsController extends Controller
{

    public function storeQuery(Request $request)
    {
        $validated = $request->validate([
            'query' => ['required', 'string'],
        ]);

        $query = trim($validated['query']);

        if (TempSyncLogs::query()->where('sql_query', $query)->exists()) {
            return response()->json([
                'message' => 'Query already stored',
            ]);
        }

        $log = new TempSyncLogs();
        $log->sql_query = $query;
        $log->save();

        return response()->json([
            'message' => 'Query stored successfully',
        ]);
    }

}
