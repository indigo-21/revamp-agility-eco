<?php

namespace Database\Seeders;

use App\Models\Scheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            [
                'short_name' => 'LAD',
                'long_name' => 'Green Homes Grant Local Authority Delivery Scheme',
                'survey_question_set_id' => '1',
                'description' => 'The LAD scheme aims to raise the energy efficiency of low income and low energy performance homes with a focus on energy performance certificate (EPC) ratings of E, F or G.',
            ],
            [
                'short_name' => 'ECO',
                'long_name' => 'Energy Company Obligation',
                'survey_question_set_id' => '1',
                'description' => 'The Energy Company Obligation (ECO) is a government energy efficiency scheme in Great Britain to help reduce carbon emissions and tackle fuel poverty.',
            ],
            [
                'short_name' => 'WHD',
                'long_name' => 'Warm Home Discount',
                'survey_question_set_id' => '1',
                'description' => 'The Warm Home Discount (WHD) scheme came into effect in April 2011 and requires obligated domestic energy suppliers to deliver support to persons on low-income and who are vulnerable to cold-related illness or living wholly or mainly in fuel poverty.',
            ],
            [
                'short_name' => 'CFW',
                'long_name' => 'Connected For Warmth',
                'survey_question_set_id' => '1',
                'description' => 'Connected for Warmth is an award-winning grant scheme offering FREE energy-saving measures to homes across Britain, that can help you reduce your energy use and stay warm and well.',
            ],
            [
                'short_name' => 'HUG',
                'long_name' => 'Home Upgrade Grant',
                'survey_question_set_id' => '1',
                'description' => 'The HUG scheme aims to provide energy efficiency upgrades and low-carbon heating to low- income households living in the worst quality, off-gas grid homes in England. This is to tackle fuel poverty and make progress towards Net Zero by 2050',
            ],
            [
                'short_name' => 'WHP',
                'long_name' => 'Warm Homes Prescription',
                'survey_question_set_id' => '1',
                'description' => 'Warm Home Prescription is a new service being trialled across England and Scotland, helping people who struggle to afford energy and have severe health conditions made worse by the cold. The service allows them to stay warm and well at home, and out of hospital in winter whilst reducing the energy consumption and carbon emissions of their home.',
            ],

            [
                'short_name' => 'GSENZH',
                'long_name' => 'Greater South East Net Zero Hub',
                'survey_question_set_id' => '5',
                'description' => 'The Greater South East Net Zero Hub is a regional, government-funded initiative that works with local authorities and other public sector organisations and their stakeholders.',
            ],
        );

        foreach ($values as $value) {
            Scheme::create([
                'short_name' => $value['short_name'],
                'long_name' => $value['long_name'],
                'survey_question_set_id' => $value['survey_question_set_id'],
                'description' => $value['description'],
            ]);
        }
    }
}
