<?php

namespace App\Http\Controllers;

use App\Models\AccountLevel;
use App\Models\ChargingScheme;
use App\Models\JobType;
use App\Models\Measure;
use App\Models\OutwardPostcode;
use App\Models\PropertyInspector;
use App\Services\PropertyInspectorService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyInspectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $property_inspectors = PropertyInspector::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.platform-configuration.property-inspector.index')
            ->with('property_inspectors', $property_inspectors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employment_basis = AccountLevel::where('name', 'LIKE', '%Property Inspector')
            ->get();
        $measures = Measure::all();
        $outward_postcodes = OutwardPostcode::all();
        $charging_schemes = ChargingScheme::all();
        $job_types = JobType::all();

        return view('pages.platform-configuration.property-inspector.form')
            ->with('employment_basis', $employment_basis)
            ->with('measures', $measures)
            ->with('outward_postcodes', $outward_postcodes)
            ->with('charging_schemes', $charging_schemes)
            ->with('job_types', $job_types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
        ]);

        $request->user_type_id = 4; // Property Inspector

        $user = (new UserService)->store($request);

        (new PropertyInspectorService)->store($request, $user->id);

        // Return a success message
        return response()->json([
            'status' => 'success',
            'message' => 'Property Inspector created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $propertyInspector = PropertyInspector::with('user')
            ->where('id', $id)
            ->firstOrFail();

        return view('pages.platform-configuration.property-inspector.show')
            ->with('property_inspector', $propertyInspector);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $propertyInspector = PropertyInspector::with('user')
            ->where('id', $id)
            ->firstOrFail();
        $employment_basis = AccountLevel::where('name', 'LIKE', '%Property Inspector')
            ->get();
        $measures = Measure::all();
        $outward_postcodes = OutwardPostcode::all();
        $charging_schemes = ChargingScheme::all();
        $job_types = JobType::all();


        return view('pages.platform-configuration.property-inspector.form')
            ->with('employment_basis', $employment_basis)
            ->with('measures', $measures)
            ->with('outward_postcodes', $outward_postcodes)
            ->with('charging_schemes', $charging_schemes)
            ->with('property_inspector', $propertyInspector)
            ->with('job_types', $job_types);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $propertyInspector = PropertyInspector::with('user')
            ->where('id', $id)
            ->firstOrFail();

        $user = (new UserService)->store($request, $propertyInspector->user_id);

        (new PropertyInspectorService)->store($request, $user->id, $propertyInspector->id);

        // Return a success message
        return response()->json([
            'status' => 'success',
            'message' => 'Property Inspector created successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $propertyInspector = PropertyInspector::with('user')
            ->where('id', $id)
            ->firstOrFail();

        $propertyInspector->delete();
        $propertyInspector->user->delete();

        return redirect()
            ->route('property-inspector.index')
            ->with('success', 'Property Inspector deleted successfully');
    }

    public function searchPropertyInspector(Request $request)
    {

        $propertyInspectors = PropertyInspector::with(['user', 'user.userType', 'user.accountLevel', 'propertyInspectorPostcodes', 'propertyInspectorPostcodes.outwardPostcode'])
            ->where('id', $request->property_inspector_id)
            ->first();

        return response()->json($propertyInspectors);
    }

    public function getPiDetails(Request $request)
    {
        $propertyInspector = PropertyInspector::with(['job', 'user', 'user.userType', 'user.accountLevel'])->find($request->piId);

        return response()->json($propertyInspector);
    }
}
