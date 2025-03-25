<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            [
                'tla' => 'AES',
                'name' => 'Agility Eco',
                'client_type_id' => '3',
                'active' => '0',
                'job_duration_qai' => '0.5',
                'job_duration_assessor' => '0.5',
                'job_duration_survey' => '0.5',
                'deactivate_date' => null,
                'address1' => 'address1',
                'address2' => 'address2',
                'address3' => 'address3',
                'city' => 'city',
                'county' => 'county',
                'postcode' => 'postcode',
                'payment_terms' => '30',
                'charging_scheme_id' => '1',
                'property_charge_value' => '15',
                'property_charge_currency' => 'GBP',
                'appeal_process' => '0',
                'max_attempts' => '3',
                'max_noshow' => '1',
                'max_remediation' => '2',
                'max_appeal' => '2',
                'sla_job_deadline' => '60',
            ],
            [
                'tla' => 'BRC',
                'name' => 'Bierce',
                'client_type_id' => '2',
                'active' => '0',
                'job_duration_qai' => '0.5',
                'job_duration_assessor' => '0.5',
                'job_duration_survey' => '0.5',
                'deactivate_date' => null,
                'address1' => 'address1',
                'address2' => 'address2',
                'address3' => 'address3',
                'city' => 'city',
                'county' => 'county',
                'postcode' => 'postcode',
                'payment_terms' => '30',
                'charging_scheme_id' => '1',
                'property_charge_value' => '15',
                'property_charge_currency' => 'GBP',
                'appeal_process' => '0',
                'max_attempts' => '3',
                'max_noshow' => '1',
                'max_remediation' => '2',
                'max_appeal' => '2',
                'sla_job_deadline' => '60',
            ],
        );

        foreach ($values as $value) {
            Client::create([
                'tla' => $value['tla'],
                'name' => $value['name'],
                'client_type_id' => $value['client_type_id'],
                'active' => $value['active'],
                'job_duration_qai' => $value['job_duration_qai'],
                'job_duration_assessor' => $value['job_duration_assessor'],
                'job_duration_survey' => $value['job_duration_survey'],
                'deactivate_date' => $value['deactivate_date'],
                'address1' => $value['address1'],
                'address2' => $value['address2'],
                'address3' => $value['address3'],
                'city' => $value['city'],
                'county' => $value['county'],
                'postcode' => $value['postcode'],
                'payment_terms' => $value['payment_terms'],
                'charging_scheme_id' => $value['charging_scheme_id'],
                'property_charge_value' => $value['property_charge_value'],
                'property_charge_currency' => $value['property_charge_currency'],
                'appeal_process' => $value['appeal_process'],
                'max_attempts' => $value['max_attempts'],
                'max_noshow' => $value['max_noshow'],
                'max_remediation' => $value['max_remediation'],
                'max_appeal' => $value['max_appeal'],
                'sla_job_deadline' => $value['sla_job_deadline'],
            ]);
        }
    }
}
