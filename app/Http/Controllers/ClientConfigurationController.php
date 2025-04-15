<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\ClientConfiguration;
use App\Models\Client;
use App\Models\ClientKeyDetail;
use App\Models\ClientSlaMetric;
use App\Models\ClientInstaller;
use App\Models\ClientType;
use App\Models\ChargingScheme;
use App\Models\Measure;
use App\Models\Installer;
use App\Models\JobStatus;
use App\Models\JobType;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\ClientJobTypes;
use DateTime;


class ClientConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            "clients"   => Client::getClientData(),
            "jobTypes"  => JobType::all()
        ];
        return view('pages.client-configuration.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {  
        $data = [
            "clientTypes"       => ClientType::all(),
            "chargingSchemes"   => ChargingScheme::all(),
            "measureCategories"=> Measure::all(),
            "installers"        => Installer::all(),
            "jobStatuses"       => JobStatus::all(),
            "userProfiles"      => User::all(),
        ];
        return view('pages.client-configuration.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $testData = [
        //         "clientInstallerForm"   => ["1", "13"],
        //         "clientKeyDetailsForm"  => [
        //                                         "active"                        =>  true,
        //                                         "address1"                      => "Test Branch",
        //                                         "address2"                      =>  "Test Branch",
        //                                         "address3"                      => "Test Branch",
        //                                         "assesor"                       => true,
        //                                         "assessor_visit_duration"       => "2",
        //                                         "can_job_outcome_be_appealed"   => true,
        //                                         "charge_by_property_rate"       => "123.22",
        //                                         "charging_scheme"               => "2",
        //                                         "city"                          => "UP Town",
        //                                         "client_abbrevation"            => "test",
        //                                         "client_name"                   => "Tesst",
        //                                         "client_type_id"                => "3",
        //                                         "country"                       => "Philippines",
        //                                         "currency"                      => "GBP",
        //                                         "date_last_activated"           => new DateTime(),
        //                                         "date_last_deactivated"         => new DateTime(),
        //                                         "exceptions_email"              => "charles.verdadero@indigo21.com",
        //                                         "organisation"                  => "test",
        //                                         "payment_terms"                 => "1",
        //                                         "phone_number"                  =>"123456",
        //                                         "postcode"                      => "85412",
        //                                         "qai"                           => true,
        //                                         "qai_visit_duration"            => "1",
        //                                         "surveyor"                      => true,
        //                                         "surveyor_visit_duration"       => "3",
        //                                     ],
        //         "clientMeasureTable"    => [
        //                                         ["measure"=> "ASHP", "chargeValue" => "Test", "currency" => "GBP"],
        //                                         ["measure"=> "BB", "chargeValue" => "Testing", "currency" => "GBP"]
        //                                     ],
        //         "clientSlaMetricsForm"  => [
        //                                         "cat1_challenge"                                => "4",
        //                                         "cat1_challenge_duration_unit"                  => "1",
        //                                         "cat1_reinspect_remediation"                    => "3",
        //                                         "cat1_reinspect_remediation_duration_unit"      => "1",
        //                                         "cat1_remediate_complete"                       => "1",
        //                                         "cat1_remediate_no_access"                      => "5",
        //                                         "cat1_remediate_no_access_duration_unit"        => "1",
        //                                         "cat1_remediate_notify"                         => "1",
        //                                         "cat1_remediate_notify_duration_unit"           => "1",
        //                                         "cat1_unremediated"                             => "6",
        //                                         "cat1_unremediated_duration_unit"               => "1",
        //                                         "client_maximum_retries"                        => "123",
        //                                         "job_deadline"                                  => "test",
        //                                         "maximum_booking_attemps"                       => "Test",
        //                                         "maximum_no_show"                               => "Test",
        //                                         "maximum_number_appeals"                        => "Test",
        //                                         "maximum_remediation_attemps"                   => "Test",
        //                                         "nc_challenge"                                  => "10",
        //                                         "nc_challenge_duration_unit"                    => "1",
        //                                         "nc_reinspect_remediation"                      => "9",
        //                                         "nc_reinspect_remediation_duration_unit"        => "1",
        //                                         "nc_remediate_complete"                         => "8",
        //                                         "nc_remediate_complete_duration_unit"           => "1",
        //                                         "nc_remediate_no_access"                        => "11",
        //                                         "nc_remediate_no_access_duration_unit"          => "1",
        //                                         "nc_remediate_notify"                           => "7",
        //                                         "nc_remediate_notify_duration_unit"             => "1",
        //                                         "nc_unremediated"                               => "12",
        //                                         "nc_unremediated_duration_unit"                 => "1",
        //                                     ]



        // ];

        $clientKeyDetailsRequest = $request["clientKeyDetailsForm"];
        $clientSlaMetricsRequest = $request["clientSlaMetricsForm"];
        $clientInstallerRequest  = $request["clientInstallerForm"];
        // STORING USERs TABLE
        $userData = (object)[
            "firstname"         => $clientKeyDetailsRequest["client_name"],
            "lastname"          => "",
            "organisation"      => $clientKeyDetailsRequest["organisation"],
            "email"             => $clientKeyDetailsRequest["exceptions_email"],
            "mobile"            => $clientKeyDetailsRequest["phone_number"],
            "landline"          => "",
            "account_level_id"  => 4,
            "user_type_id"      => 5
        ];
        $user     = (new UserService)->store($userData);

        if($user){
            $clientData = (object)[
                "user_id"                   => $user->id,
                "client_abbrevation"        => $clientKeyDetailsRequest["client_abbrevation"], 
                "client_type_id"            => $clientKeyDetailsRequest["client_type_id"], 
                "address1"                  => $clientKeyDetailsRequest["address1"], 
                "address2"                  => $clientKeyDetailsRequest["address2"], 
                "address3"                  => $clientKeyDetailsRequest["address3"], 
                "city"                      => $clientKeyDetailsRequest["city"], 
                "country"                   => $clientKeyDetailsRequest["country"], 
                "postcode"                  => $clientKeyDetailsRequest["postcode"], 
                "date_last_activated"       => $clientKeyDetailsRequest["date_last_activated"], 
                "date_last_deactivated"     => $clientKeyDetailsRequest["date_last_deactivated"],  
            ];

            $client = self::storeClient($clientData);

            if($client){
                $client_id             = $client->id;
                $clientKeyDetailsData  = (object)[
                                            "client_id"                 => $client_id,
                                            "is_active"                 => $clientKeyDetailsRequest["active"] ? 1 : 0,
                                            "can_job_outcome_appealed"  => $clientKeyDetailsRequest["can_job_outcome_be_appealed"] ? 1 : 0,
                                            "is_qai"                    => $clientKeyDetailsRequest["qai"] ? 1 : 0,
                                            "is_assessor"               => $clientKeyDetailsRequest["assesor"] ? 1 : 0,
                                            "is_surveyor"               => $clientKeyDetailsRequest["surveyor"] ? 1 : 0,
                                            "assessor_visit_duration"   => $clientKeyDetailsRequest["surveyor"] ? 1 : 0,
                                            "qai_visit_duration"        => $clientKeyDetailsRequest["surveyor"] ? 1 : 0,
                                            "surveyor_visit_duration"   => $clientKeyDetailsRequest["surveyor"] ? 1 : 0,
                                            "charging_scheme_id"        => $clientKeyDetailsRequest["charging_scheme"],
                                            "payment_terms"             => $clientKeyDetailsRequest["payment_terms"],
                                            "charge_by_property_rate"   => $clientKeyDetailsRequest["charge_by_property_rate"],
                ];

                $client_key_details = self::storeClientKeyDetais($clientKeyDetailsData);

                
                $clientSlaMetricsData = (object)[
                                            "client_id"                                     => $client_id,
                                            "cat1_challenge"                                => $clientSlaMetricsRequest["cat1_challenge"],
                                            "cat1_challenge_duration_unit"                  => $clientSlaMetricsRequest["cat1_challenge_duration_unit"],
                                            "cat1_reinspect_remediation"                    => $clientSlaMetricsRequest["cat1_reinspect_remediation"],
                                            "cat1_reinspect_remediation_duration_unit"      => $clientSlaMetricsRequest["cat1_reinspect_remediation_duration_unit"],
                                            "cat1_remediate_complete"                       => $clientSlaMetricsRequest["cat1_remediate_complete"],
                                            "cat1_remediate_no_access"                      => $clientSlaMetricsRequest["cat1_remediate_no_access"],
                                            "cat1_remediate_no_access_duration_unit"        => $clientSlaMetricsRequest["cat1_remediate_no_access_duration_unit"],
                                            "cat1_remediate_notify"                         => $clientSlaMetricsRequest["cat1_remediate_notify"],
                                            "cat1_remediate_notify_duration_unit"           => $clientSlaMetricsRequest["cat1_remediate_notify_duration_unit"],
                                            "cat1_unremediated"                             => $clientSlaMetricsRequest["cat1_unremediated"],
                                            "cat1_unremediated_duration_unit"               => $clientSlaMetricsRequest["cat1_unremediated_duration_unit"],
                                            "client_maximum_retries"                        => $clientSlaMetricsRequest["client_maximum_retries"],
                                            "job_deadline"                                  => $clientSlaMetricsRequest["job_deadline"],
                                            "maximum_booking_attemps"                       => $clientSlaMetricsRequest["maximum_booking_attemps"],
                                            "maximum_no_show"                               => $clientSlaMetricsRequest["maximum_no_show"],
                                            "maximum_number_appeals"                        => $clientSlaMetricsRequest["maximum_number_appeals"],
                                            "maximum_remediation_attemps"                   => $clientSlaMetricsRequest["maximum_remediation_attemps"],
                                            "nc_challenge"                                  => $clientSlaMetricsRequest["nc_challenge"],
                                            "nc_challenge_duration_unit"                    => $clientSlaMetricsRequest["nc_challenge_duration_unit"],
                                            "nc_reinspect_remediation"                      => $clientSlaMetricsRequest["nc_reinspect_remediation"],
                                            "nc_reinspect_remediation_duration_unit"        => $clientSlaMetricsRequest["nc_reinspect_remediation_duration_unit"],
                                            "nc_remediate_complete"                         => $clientSlaMetricsRequest["nc_remediate_complete"],
                                            "nc_remediate_complete_duration_unit"           => $clientSlaMetricsRequest["nc_remediate_complete_duration_unit"],
                                            "nc_remediate_no_access"                        => $clientSlaMetricsRequest["nc_remediate_no_access"],
                                            "nc_remediate_no_access_duration_unit"          => $clientSlaMetricsRequest["nc_remediate_no_access_duration_unit"],
                                            "nc_remediate_notify"                           => $clientSlaMetricsRequest["nc_remediate_notify"],
                                            "nc_remediate_notify_duration_unit"             => $clientSlaMetricsRequest["nc_remediate_notify_duration_unit"],
                                            "nc_unremediated"                               => $clientSlaMetricsRequest["nc_unremediated"],
                                            "nc_unremediated_duration_unit"                 => $clientSlaMetricsRequest["nc_unremediated_duration_unit"],
                ];

                $client_sla_metrics   = self::storeClientSlaMetrics($clientSlaMetricsData);

                $client_installers    = self::storeClientInstallers($clientInstallerRequest, $client_id);
            }
        }
        
        // Return a success message
        return response()->json([
            'status' => 'success',
            'message' => 'Property Inspector created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientConfiguration $clientConfiguration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientConfiguration $clientConfiguration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientConfiguration $clientConfiguration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientConfiguration $clientConfiguration)
    {
        //
    }



    public function storeClient($array_data, $client_id = false){
       
        $client = new Client();

        $client->user_id                   = $array_data->user_id;
        $client->client_abbrevation        = $array_data->client_abbrevation; 
        $client->client_type_id            = $array_data->client_type_id; 
        $client->address1                  = $array_data->address1; 
        $client->address2                  = $array_data->address2; 
        $client->address3                  = $array_data->address3; 
        $client->city                      = $array_data->city; 
        $client->country                   = $array_data->country; 
        $client->postcode                  = $array_data->postcode; 
        $client->date_last_activated       = $array_data->date_last_activated; 
        $client->date_last_deactivated     = $array_data->date_last_deactivated; 

        $client->save();
        return $client;
    }

    public function storeClientKeyDetais($array_data, $client_id = false){
        $result            = false;
        $client_key_detail = new ClientKeyDetail();

        $client_key_detail->client_id                 = $array_data->client_id;
        $client_key_detail->is_active                 = $array_data->is_active;
        $client_key_detail->can_job_outcome_appealed  = $array_data->can_job_outcome_appealed;
        $client_key_detail->charging_scheme_id        = $array_data->charging_scheme_id;
        $client_key_detail->payment_terms             = $array_data->payment_terms;
        $client_key_detail->charge_by_property_rate   = $array_data->charge_by_property_rate;

        if($client_key_detail->save()){
            $client_key_detail_id   = $client_key_detail->id;
            $clientJobTypesData     = [];

            if($array_data->is_qai != 0){
                $clientJobTypesData[] = [
                    "client_id"        => $array_data->client_id,
                    "job_type_id"       => 1,
                    "visit_duration"    => $array_data->qai_visit_duration
                ];
            }
            if($array_data->is_surveyor != 0){
                $clientJobTypesData[] = [
                    "client_id"        => $array_data->client_id,
                    "job_type_id"       => 2,
                    "visit_duration"    => $array_data->surveyor_visit_duration
                ];
            }
            if($array_data->is_assessor != 0){
                $clientJobTypesData[] = [
                    "client_id"         => $array_data->client_id,
                    "job_type_id"       => 3,
                    "visit_duration"    => $array_data->assessor_visit_duration
                ];
            }
            $result = DB::table('client_job_types')->insert($clientJobTypesData);
        };




        return $result;
    }

    public function storeClientSlaMetrics($array_data, $client_id = false){
        $client_sla_metric = new ClientSlaMetric();

        $client_sla_metric->client_id                                     = $array_data->client_id;
        $client_sla_metric->cat1_challenge                                = $array_data->cat1_challenge;
        $client_sla_metric->cat1_challenge_duration_unit                  = $array_data->cat1_challenge_duration_unit;
        $client_sla_metric->cat1_reinspect_remediation                    = $array_data->cat1_reinspect_remediation;
        $client_sla_metric->cat1_reinspect_remediation_duration_unit      = $array_data->cat1_reinspect_remediation_duration_unit;
        $client_sla_metric->cat1_remediate_complete                       = $array_data->cat1_remediate_complete;
        $client_sla_metric->cat1_remediate_no_access                      = $array_data->cat1_remediate_no_access;
        $client_sla_metric->cat1_remediate_no_access_duration_unit        = $array_data->cat1_remediate_no_access_duration_unit;
        $client_sla_metric->cat1_remediate_notify                         = $array_data->cat1_remediate_notify;
        $client_sla_metric->cat1_remediate_notify_duration_unit           = $array_data->cat1_remediate_notify_duration_unit;
        $client_sla_metric->cat1_unremediated                             = $array_data->cat1_unremediated;
        $client_sla_metric->cat1_unremediated_duration_unit               = $array_data->cat1_unremediated_duration_unit;
        $client_sla_metric->client_maximum_retries                        = $array_data->client_maximum_retries;
        $client_sla_metric->job_deadline                                  = $array_data->job_deadline;
        $client_sla_metric->maximum_booking_attemps                       = $array_data->maximum_booking_attemps;
        $client_sla_metric->maximum_no_show                               = $array_data->maximum_no_show;
        $client_sla_metric->maximum_number_appeals                        = $array_data->maximum_number_appeals;
        $client_sla_metric->maximum_remediation_attemps                   = $array_data->maximum_remediation_attemps;
        $client_sla_metric->nc_challenge                                  = $array_data->nc_challenge;
        $client_sla_metric->nc_challenge_duration_unit                    = $array_data->nc_challenge_duration_unit;
        $client_sla_metric->nc_reinspect_remediation                      = $array_data->nc_reinspect_remediation;
        $client_sla_metric->nc_reinspect_remediation_duration_unit        = $array_data->nc_reinspect_remediation_duration_unit;
        $client_sla_metric->nc_remediate_complete                         = $array_data->nc_remediate_complete;
        $client_sla_metric->nc_remediate_complete_duration_unit           = $array_data->nc_remediate_complete_duration_unit;
        $client_sla_metric->nc_remediate_no_access                        = $array_data->nc_remediate_no_access;
        $client_sla_metric->nc_remediate_no_access_duration_unit          = $array_data->nc_remediate_no_access_duration_unit;
        $client_sla_metric->nc_remediate_notify                           = $array_data->nc_remediate_notify;
        $client_sla_metric->nc_remediate_notify_duration_unit             = $array_data->nc_remediate_notify_duration_unit;
        $client_sla_metric->nc_unremediated                               = $array_data->nc_unremediated;
        $client_sla_metric->nc_unremediated_duration_unit                 = $array_data->nc_unremediated_duration_unit;

        $client_sla_metric->save();
        return $client_sla_metric;
    }

    public function storeClientInstallers($array_data, $client_id = false){
        $client_installer_data  = [];
        $result                 = false;
        if(count($array_data) > 0){

            ClientInstaller::where('client_id', $client_id)->delete();

            for ($i=0; $i < count($array_data); $i++) { 
                $client_installer_data[] = [
                    "client_id"   => $client_id,
                    "installer_id"=> $array_data[$i]
                ];
            }
            $result = DB::table('client_installers')->insert($client_installer_data);
        }

        return $result;
    }
    
    public function validateEmail(Request $request){
        return count(User::where("email", $request->email)->get());
    }
    
}
