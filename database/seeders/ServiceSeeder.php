<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
           'General' => [
               'General Consultation',
           ],
           'Vaccinations' => [
               'Flu Vaccine',
               'Anti Rabies',
           ],
           'Lab Tests' => [
               'Blood Test',
               'Urine Test',
           ],
           'Diagnostics' => [
               'X-ray',
               'Ultrasound',
               'MRI',
               'CT Scan',
               'Electrocardiogram (ECG)',
               'Echocardiogram (Echo)',
           ],
           'Therapy' => [
               'Physical Therapy',
               'Occupational Therapy',
               'Speech Therapy',
           ],
      ];

        foreach ($categories as $categoryName => $services) {
            $category = ServiceCategory::firstOrCreate(['name' => $categoryName]);

            foreach ($services as $serviceName) {
                Service::firstOrCreate([
                    'service_category_id' => $category->id,
                    'name' => $serviceName,
                ]);
            }
        }
 
    }
}
