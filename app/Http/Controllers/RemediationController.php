<?php

namespace App\Http\Controllers;

use App\Models\Remediation;
use App\Models\RemediationFile;
use App\Services\RemediationService;
use Illuminate\Http\Request;

class RemediationController extends Controller
{
    public function storeRemediation(Request $request)
    {

        $remediation = (new RemediationService)->store($request);
        
        return response()->json([
            'message' => 'Remediation created successfully',
            'remediation' => $remediation,
        ], 201);
    }
}
