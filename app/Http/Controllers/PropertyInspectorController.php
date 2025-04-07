<?php

namespace App\Http\Controllers;

use App\Models\AccountLevel;
use App\Models\ChargingScheme;
use App\Models\Measure;
use App\Models\OutwardPostcode;
use App\Models\PropertyInspector;
use App\Models\PropertyInspectorMeasure;
use App\Models\PropertyInspectorPostcode;
use App\Models\PropertyInspectorQualification;
use App\Services\PropertyInspectorService;
use App\Services\UserService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyInspectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.property-inspector.index');
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
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
        ]);

        $request->user_type_id = 4; // Property Inspector

        $user = (new UserService)->store($request);

        $property_inspector_service = (new PropertyInspectorService)->store($request, $user->id);

        // $measures_array = json_decode($request->measures, true);
        // $qualifications_array = json_decode($request->qualifications, true);

        // foreach ($measures_array as $key => $measure) {
        //     $measure = Measure::find($measure['id']);

        //     $qualification_file = $request->file('measure_certificate');

        //     $property_inspector_measure = new PropertyInspectorMeasure;
        //     $property_inspector_measure->property_inspector_id = $property_inspector->id;
        //     $property_inspector_measure->measure_id = $measure->id;
        //     $property_inspector_measure->fee_value = $measure['fee_value'];
        //     $property_inspector_measure->fee_currency = $measure['fee_currency'];
        //     $property_inspector_measure->expiry = $measure['expiry'];
        //     // $property_inspector_measure->cert = $measures['cert'];
        //     $property_inspector_measure->save();
        // }

        // foreach ($qualifications_array as $key => $qualification) {

        //     $property_inspector_qualification = new PropertyInspectorQualification;

        //     $qualification_file = $request->file('qualification_certificate');

        //     $property_inspector_qualification->property_inspector_id = $property_inspector->id;
        //     $property_inspector_qualification->name = $qualification['name'];
        //     $property_inspector_qualification->issue_date = $qualification['issue_date'];
        //     $property_inspector_qualification->expiry_date = $qualification['expiry_date'];
        //     // $property_inspector_qualification->certificate = $qualification['certificate'];
        //     $qualification_file->store('uploads', 'public');
        //     $property_inspector_qualification->qualification_issue = $qualification['qualification_issue'];

        //     $property_inspector_qualification->save();
        // }



        // Return a success message
        // return redirect()->route('property-inspectors.index')
        //     ->with('success', 'Property Inspector created successfully');

        // Return the data to the browser
        return response()->json('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
