<?php

namespace App\Http\Controllers;

use App\Models\TempSyncLogs;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TempSyncLogsController extends Controller
{

    public function storeQuery(Request $request)
    {
        $log = new TempSyncLogs();

        $log->sql_query = $request->input('query');

        $log->save();

        if (!$request->query) {
            throw ValidationException::withMessages([
                'query' => ['The query field is required.'],
            ]);
        }

        return response()->json([
            'message' => 'Query stored successfully',
        ]);
    }

}
