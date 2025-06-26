<?php

namespace App\Http\Controllers;

use App\Models\ChargingScheme;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\Installer;
use App\Models\JobType;
use App\Models\Measure;
use App\Services\ClientService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return view('pages.platform-configuration.client-configuration.index')
            ->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientTypes = ClientType::all();
        $chargingSchemes = ChargingScheme::all();
        $measures = Measure::all();
        $installers = Installer::all();
        $jobTypes = JobType::all();

        return view('pages/platform-configuration.client-configuration.form')
            ->with('clientTypes', $clientTypes)
            ->with('chargingSchemes', $chargingSchemes)
            ->with('measures', $measures)
            ->with('installers', $installers)
            ->with('jobTypes', $jobTypes);
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

        $request->user_type_id = 5; // Client
        $request->account_level_id = 4; // Client

        // dd($request->all());

        $user = (new UserService)->store($request);

        (new ClientService)->store($request, $user->id);

        return response()->json([
            'message' => 'Client created successfully.',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);

        return view('pages.platform-configuration.client-configuration.show')
            ->with('client', $client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $clientTypes = ClientType::all();
        $chargingSchemes = ChargingScheme::all();
        $measures = Measure::all();
        $installers = Installer::all();
        $jobTypes = JobType::all();

        $client = Client::find($id);

        return view('pages.platform-configuration.client-configuration.form')
            ->with('client', $client)
            ->with('clientTypes', $clientTypes)
            ->with('chargingSchemes', $chargingSchemes)
            ->with('measures', $measures)
            ->with('installers', $installers)
            ->with('jobTypes', $jobTypes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::with('user')
            ->where('id', $id)
            ->firstOrFail();

        $user = (new UserService)->store($request, $client->user_id);

        (new ClientService)->store($request, $user->id, $client->id);

        return response()->json([
            'message' => 'Client updated successfully.',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);

        $client->delete();

        return redirect()->back()
            ->with('success', 'Client deleted successfully.');
    }
}
