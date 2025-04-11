<?php

namespace App\Http\Controllers;

use App\Models\AccountLevel;
use App\Models\ChargingScheme;
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

        return view('pages.property-inspector.index')
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

        return view('pages.property-inspector.form')
            ->with('employment_basis', $employment_basis)
            ->with('measures', $measures)
            ->with('outward_postcodes', $outward_postcodes)
            ->with('charging_schemes', $charging_schemes);
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
    public function show(PropertyInspector $propertyInspector)
    {
        return view('pages.property-inspector.show')
            ->with('property_inspector', $propertyInspector);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyInspector $propertyInspector)
    {

        $employment_basis = AccountLevel::where('name', 'LIKE', '%Property Inspector')
            ->get();
        $measures = Measure::all();
        $outward_postcodes = OutwardPostcode::all();
        $charging_schemes = ChargingScheme::all();

        return view('pages.property-inspector.form')
            ->with('employment_basis', $employment_basis)
            ->with('measures', $measures)
            ->with('outward_postcodes', $outward_postcodes)
            ->with('charging_schemes', $charging_schemes)
            ->with('property_inspector', $propertyInspector);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyInspector $propertyInspector)
    {

        $user = (new UserService)->store($request, $propertyInspector->user_id);

        (new PropertyInspectorService)->store($request, $user->id, $propertyInspector->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyInspector $propertyInspector)
    {
        $propertyInspector->delete();
        $propertyInspector->user->delete();

        return redirect()
            ->route('property-inspector.index')
            ->with('success', 'Property Inspector deleted successfully')
            ->with('success', 'success');
    }
}
