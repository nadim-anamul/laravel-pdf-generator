<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compensation;

class ModularCompensationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting modular compensation seeding...');
        
        // Option 1: Clear existing data and create fresh (default)
        if (env('FRESH_SEED', true)) {
            $this->command->info('Clearing existing data and creating fresh records...');
            Compensation::truncate();
            $this->seedFreshData();
        } else {
            // Option 2: Convert existing records to Bengali
            $this->command->info('Converting existing records to Bengali numbers...');
            $this->convertExistingRecords();
        }

        $this->command->info('Modular compensation seeding completed!');
        $this->command->info('Total records created: ' . Compensation::count());
    }
    
    /**
     * Seed fresh data (original functionality)
     */
    private function seedFreshData()
    {
        // Seed basic test cases
        $this->seedBasicTestCases();
        
        // Seed comprehensive test cases
        $this->seedComprehensiveTestCases();
        
        // Seed edge cases
        $this->seedEdgeCases();
        
        // Seed complex ownership cases
        $this->seedComplexOwnershipCases();
    }
    
    /**
     * Convert existing records to Bengali numbers
     */
    private function convertExistingRecords()
    {
        $compensations = Compensation::all();
        $convertedCount = 0;
        
        foreach ($compensations as $compensation) {
            $this->convertCompensationToBengali($compensation);
            $convertedCount++;
        }
        
        $this->command->info("Successfully converted {$convertedCount} compensation records to Bengali numbers!");
    }
    
    /**
     * Convert a single compensation record to Bengali numbers
     */
    private function convertCompensationToBengali(Compensation $compensation)
    {
        $data = $compensation->toArray();
        
        // Convert basic fields (only if they exist and are not null)
        if (isset($data['case_number']) && $data['case_number']) {
            $data['case_number'] = $this->convertToBengali($data['case_number']);
        }
        if (isset($data['case_date']) && $data['case_date']) {
            $data['case_date'] = $this->convertToBengali($data['case_date']);
        }
        if (isset($data['la_case_no']) && $data['la_case_no']) {
            $data['la_case_no'] = $this->convertToBengali($data['la_case_no']);
        }
        if (isset($data['plot_no']) && $data['plot_no']) {
            $data['plot_no'] = $this->convertToBengali($data['plot_no']);
        }
        if (isset($data['sa_plot_no']) && $data['sa_plot_no']) {
            $data['sa_plot_no'] = $this->convertToBengali($data['sa_plot_no']);
        }
        if (isset($data['rs_plot_no']) && $data['rs_plot_no']) {
            $data['rs_plot_no'] = $this->convertToBengali($data['rs_plot_no']);
        }
        if (isset($data['land_award_serial_no']) && $data['land_award_serial_no']) {
            $data['land_award_serial_no'] = $this->convertToBengali($data['land_award_serial_no']);
        }
        if (isset($data['tree_award_serial_no']) && $data['tree_award_serial_no']) {
            $data['tree_award_serial_no'] = $this->convertToBengali($data['tree_award_serial_no']);
        }
        if (isset($data['infrastructure_award_serial_no']) && $data['infrastructure_award_serial_no']) {
            $data['infrastructure_award_serial_no'] = $this->convertToBengali($data['infrastructure_award_serial_no']);
        }
        if (isset($data['jl_no']) && $data['jl_no']) {
            $data['jl_no'] = $this->convertToBengali($data['jl_no']);
        }
        if (isset($data['sa_khatian_no']) && $data['sa_khatian_no']) {
            $data['sa_khatian_no'] = $this->convertToBengali($data['sa_khatian_no']);
        }
        if (isset($data['rs_khatian_no']) && $data['rs_khatian_no']) {
            $data['rs_khatian_no'] = $this->convertToBengali($data['rs_khatian_no']);
        }
        if (isset($data['land_schedule_sa_plot_no']) && $data['land_schedule_sa_plot_no']) {
            $data['land_schedule_sa_plot_no'] = $this->convertToBengali($data['land_schedule_sa_plot_no']);
        }
        if (isset($data['land_schedule_rs_plot_no']) && $data['land_schedule_rs_plot_no']) {
            $data['land_schedule_rs_plot_no'] = $this->convertToBengali($data['land_schedule_sa_plot_no']);
        }
        
        // Convert applicants (only if they exist)
        if (isset($data['applicants']) && is_array($data['applicants'])) {
            foreach ($data['applicants'] as &$applicant) {
                if (isset($applicant['nid']) && $applicant['nid']) {
                    $applicant['nid'] = $this->convertToBengali($applicant['nid']);
                }
                if (isset($applicant['mobile']) && $applicant['mobile']) {
                    $applicant['mobile'] = $this->convertToBengali($applicant['mobile']);
                }
            }
        }
        
        // Convert land category (only if they exist)
        if (isset($data['land_category']) && is_array($data['land_category'])) {
            foreach ($data['land_category'] as &$category) {
                if (isset($category['total_land']) && $category['total_land']) {
                    $category['total_land'] = $this->convertToBengali($category['total_land']);
                }
                if (isset($category['total_compensation']) && $category['total_compensation']) {
                    $category['total_compensation'] = $this->convertToBengali($category['total_compensation']);
                }
                if (isset($category['applicant_land']) && $category['applicant_land']) {
                    $category['applicant_land'] = $this->convertToBengali($category['applicant_land']);
                }
            }
        }
        
        // Convert ownership details (only if they exist)
        if (isset($data['ownership_details']) && is_array($data['ownership_details'])) {
            // SA info
            if (isset($data['ownership_details']['sa_info']) && is_array($data['ownership_details']['sa_info'])) {
                if (isset($data['ownership_details']['sa_info']['sa_plot_no']) && $data['ownership_details']['sa_info']['sa_plot_no']) {
                    $data['ownership_details']['sa_info']['sa_plot_no'] = $this->convertToBengali($data['ownership_details']['sa_info']['sa_plot_no']);
                }
                if (isset($data['ownership_details']['sa_info']['sa_khatian_no']) && $data['ownership_details']['sa_info']['sa_khatian_no']) {
                    $data['ownership_details']['sa_info']['sa_khatian_no'] = $this->convertToBengali($data['ownership_details']['sa_info']['sa_khatian_no']);
                }
                if (isset($data['ownership_details']['sa_info']['sa_total_land_in_plot']) && $data['ownership_details']['sa_info']['sa_total_land_in_plot']) {
                    $data['ownership_details']['sa_info']['sa_total_land_in_plot'] = $this->convertToBengali($data['ownership_details']['sa_info']['sa_total_land_in_plot']);
                }
                if (isset($data['ownership_details']['sa_info']['sa_land_in_khatian']) && $data['ownership_details']['sa_info']['sa_land_in_khatian']) {
                    $data['ownership_details']['sa_info']['sa_land_in_khatian'] = $this->convertToBengali($data['ownership_details']['sa_info']['sa_land_in_khatian']);
                }
            }
            
            // RS info
            if (isset($data['ownership_details']['rs_info']) && is_array($data['ownership_details']['rs_info'])) {
                if (isset($data['ownership_details']['rs_info']['rs_plot_no']) && $data['ownership_details']['rs_info']['rs_plot_no']) {
                    $data['ownership_details']['rs_info']['rs_plot_no'] = $this->convertToBengali($data['ownership_details']['rs_info']['rs_plot_no']);
                }
                if (isset($data['ownership_details']['rs_info']['rs_khatian_no']) && $data['ownership_details']['rs_info']['rs_khatian_no']) {
                    $data['ownership_details']['rs_info']['rs_khatian_no'] = $this->convertToBengali($data['ownership_details']['rs_info']['rs_khatian_no']);
                }
                if (isset($data['ownership_details']['rs_info']['rs_total_land_in_plot']) && $data['ownership_details']['rs_info']['rs_total_land_in_plot']) {
                    $data['ownership_details']['rs_info']['rs_total_land_in_plot'] = $this->convertToBengali($data['ownership_details']['rs_info']['rs_total_land_in_plot']);
                }
                if (isset($data['ownership_details']['rs_info']['rs_land_in_khatian']) && $data['ownership_details']['rs_info']['rs_land_in_khatian']) {
                    $data['ownership_details']['rs_info']['rs_land_in_khatian'] = $this->convertToBengali($data['ownership_details']['rs_info']['rs_land_in_khatian']);
                }
            }
            
            // Deed transfers
            if (isset($data['ownership_details']['deed_transfers']) && is_array($data['ownership_details']['deed_transfers'])) {
                foreach ($data['ownership_details']['deed_transfers'] as &$deed) {
                    if (isset($deed['deed_number']) && $deed['deed_number']) {
                        $deed['deed_number'] = $this->convertToBengali($deed['deed_number']);
                    }
                    if (isset($deed['deed_date']) && $deed['deed_date']) {
                        $deed['deed_date'] = $this->convertToBengali($deed['deed_date']);
                    }
                    if (isset($deed['application_sell_area']) && $deed['application_sell_area']) {
                        $deed['application_sell_area'] = $this->convertToBengali($deed['application_sell_area']);
                    }
                    if (isset($deed['application_total_area']) && $deed['application_total_area']) {
                        $deed['application_total_area'] = $this->convertToBengali($deed['application_total_area']);
                    }
                    if (isset($deed['application_sell_area_other']) && $deed['application_sell_area_other']) {
                        $deed['application_sell_area_other'] = $this->convertToBengali($deed['application_sell_area_other']);
                    }
                }
            }
            
            // RS records
            if (isset($data['ownership_details']['rs_records']) && is_array($data['ownership_details']['rs_records'])) {
                foreach ($data['ownership_details']['rs_records'] as &$rs) {
                    if (isset($rs['plot_no']) && $rs['plot_no']) {
                        $rs['plot_no'] = $this->convertToBengali($rs['plot_no']);
                    }
                    if (isset($rs['khatian_no']) && $rs['khatian_no']) {
                        $rs['khatian_no'] = $this->convertToBengali($rs['khatian_no']);
                    }
                    if (isset($rs['land_amount']) && $rs['land_amount']) {
                        $rs['land_amount'] = $this->convertToBengali($rs['land_amount']);
                    }
                }
            }
            
            // Applicant info
            if (isset($data['ownership_details']['applicant_info']['kharij_land_amount']) && $data['ownership_details']['applicant_info']['kharij_land_amount']) {
                $data['ownership_details']['applicant_info']['kharij_land_amount'] = 
                    $this->convertToBengali($data['ownership_details']['applicant_info']['kharij_land_amount']);
            }
        }
        
        // Convert tax info (only if they exist)
        if (isset($data['tax_info']) && is_array($data['tax_info'])) {
            if (isset($data['tax_info']['holding_no']) && $data['tax_info']['holding_no']) {
                $data['tax_info']['holding_no'] = $this->convertToBengali($data['tax_info']['holding_no']);
            }
            if (isset($data['tax_info']['paid_land_amount']) && $data['tax_info']['paid_land_amount']) {
                $data['tax_info']['paid_land_amount'] = $this->convertToBengali($data['tax_info']['paid_land_amount']);
            }
        }
        
        // Convert final order (only if they exist)
        if (isset($data['final_order']) && is_array($data['final_order'])) {
            if (isset($data['final_order']['trees_crops']['amount']) && $data['final_order']['trees_crops']['amount']) {
                $data['final_order']['trees_crops']['amount'] = $this->convertToBengali($data['final_order']['trees_crops']['amount']);
            }
            if (isset($data['final_order']['infrastructure']['amount']) && $data['final_order']['infrastructure']['amount']) {
                $data['final_order']['infrastructure']['amount'] = $this->convertToBengali($data['final_order']['infrastructure']['amount']);
            }
        }
        
        // Update the compensation record
        $compensation->update($data);
    }
    
    /**
     * Convert English numbers to Bengali numbers
     */
    private function convertToBengali($value)
    {
        if (!$value || !is_string($value)) {
            return $value;
        }
        
        // Convert English numerals to Bengali numerals
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        
        return str_replace($englishNumerals, $bengaliNumerals, $value);
    }

    /**
     * Seed basic test cases for form validation
     */
    private function seedBasicTestCases()
    {
        $this->command->info('Seeding basic test cases...');
        
        // Basic Land Award Case
        $this->createBasicLandCase();
        
        // Land and Trees Case
        $this->createLandAndTreesCase();
        
        // Infrastructure Case
        $this->createInfrastructureCase();
        
        // Multiple Applicants Case
        $this->createMultipleApplicantsCase();
        
        // Decimal Numbers Test Case
        $this->createDecimalTestCase();
    }

    /**
     * Seed comprehensive test cases with all fields
     */
    private function seedComprehensiveTestCases()
    {
        $this->command->info('Seeding comprehensive test cases...');
        
        // Generate 3 compensations with all optional fields filled
        Compensation::factory()->count(3)->create();
    }

    /**
     * Seed edge cases with minimal data
     */
    private function seedEdgeCases()
    {
        $this->command->info('Seeding edge cases...');
        
        // Generate 2 compensations with only minimal required fields
        Compensation::factory()->count(2)->create();
    }

    /**
     * Seed complex ownership cases
     */
    private function seedComplexOwnershipCases()
    {
        $this->command->info('Seeding complex ownership cases...');
        
        // Generate 2 compensations with multiple applicants and award holders
        Compensation::factory()->count(2)->state(function (array $attributes) {
            return [
                'applicants' => [
                    [
                        'name' => fake()->randomElement(['আবদুল করিম', 'মোহাম্মদ আলী', 'রশিদা খাতুন', 'ফাতেমা বেগম']),
                        'father_name' => fake()->randomElement(['আবদুর রহমান', 'মোস্তাফা কামাল', 'আবুল কাসেম', 'মোহাম্মদ হাসান']),
                        'address' => 'বাড়ি নং- ' . fake()->randomElement(['১০১', '২০২', '৩০৩']) . ', ' . fake()->randomElement(['কালিগঞ্জ', 'রামপুর', 'সোনারগাঁও']) . ' ' . fake()->randomElement(['গ্রাম', 'পাড়া']),
                        'nid' => fake()->numerify('#############'),
                        'mobile' => '01' . fake()->numerify('#########')
                    ],
                    [
                        'name' => fake()->randomElement(['সালমা খাতুন', 'আয়েশা বেগম', 'আবদুল জব্বার', 'মোহাম্মদ ইউসুফ']),
                        'father_name' => fake()->randomElement(['আবদুল মজিদ', 'মোহাম্মদ সালাম', 'আব্দুল হক', 'মোহাম্মদ নূর']),
                        'address' => 'বাড়ি নং- ' . fake()->randomElement(['৪০৪', '৫০৫', '৬০৬']) . ', ' . fake()->randomElement(['বাগবাড়ি', 'পূর্বপাড়া', 'দক্ষিণপাড়া']) . ' ' . fake()->randomElement(['মহল্লা', 'কলোনি']),
                        'nid' => fake()->numerify('#############'),
                        'mobile' => '01' . fake()->numerify('#########')
                    ]
                ],
                'award_holder_names' => [
                    [
                        'name' => fake()->randomElement(['রোকেয়া খাতুন', 'হাসিনা বেগম', 'আবদুল বারী', 'মোহাম্মদ শাহ']),
                        'father_name' => fake()->randomElement(['আবুল হোসেন', 'মিনারা বেগম', 'সুফিয়া খাতুন', 'নূরজাহান বেগম']),
                        'address' => 'বাড়ি নং- ' . fake()->randomElement(['৭০৭', '৮০৮', '৯০৯']) . ', ' . fake()->randomElement(['উত্তরপাড়া', 'মধ্যপাড়া', 'নতুনপাড়া']) . ' ' . fake()->randomElement(['গ্রাম', 'এলাকা'])
                    ],
                    [
                        'name' => fake()->randomElement(['শাহনাজ পারভীন', 'রাবেয়া খাতুন', 'আবদুল করিম', 'মোহাম্মদ আলী']),
                        'father_name' => fake()->randomElement(['আবদুর রহমান', 'মোস্তাফা কামাল', 'আবুল কাসেম', 'মোহাম্মদ হাসান']),
                        'address' => 'বাড়ি নং- ' . fake()->randomElement(['১১০', '২২০', '৩৩০']) . ', ' . fake()->randomElement(['পুরাতনপাড়া', 'বাজারপাড়া', 'স্কুলপাড়া']) . ' ' . fake()->randomElement(['পাড়া', 'মহল্লা'])
                    ]
                ],
                'district' => fake()->randomElement(['বগুড়া', 'ঢাকা', 'চট্টগ্রাম', 'রাজশাহী']),
                'upazila' => fake()->randomElement(['বগুড়া সদর', 'শিবগঞ্জ', 'শেরপুর', 'দুপচাঁচিয়া']),
            ];
        })->create();

        // Generate 3 compensations with complex ownership sequences (SA records)
        Compensation::factory()->count(3)->saRecord()->create();

        // Generate 3 compensations with complex RS ownership sequences
        Compensation::factory()->count(3)->rsRecord()->create();

        // Generate 2 compensations with inheritance-heavy ownership sequences
        Compensation::factory()->count(2)->create();
    }

    // Individual test case methods will be added in the next batch...
    
    /**
     * Create basic land award case
     */
    private function createBasicLandCase()
    {
        $plotNo = '১০১';
        Compensation::create([
            'case_number' => '১০০১',
            'case_date' => '২০২৪-০১-১৫',
            'applicants' => [
                [
                    'name' => 'মোঃ রহিম উদ্দিন',
                    'father_name' => 'মোঃ করিম উদ্দিন',
                    'address' => 'গ্রাম: পাড়াতলী, ডাকঘর: বগুড়া সদর, জেলা: বগুড়া',
                    'nid' => '১২৩৪৫৬৭৮৯০১২৩',
                    'mobile' => '০১৭১২৩৪৫৬৭৮'
                ]
            ],
            'la_case_no' => '২০০১',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'rs_plot_no' => null, // Added missing field
            'award_type' => ['জমি'],
            'land_award_serial_no' => '৫০১',
            'tree_award_serial_no' => null, // Added missing field
            'infrastructure_award_serial_no' => null, // Added missing field
            'award_holder_names' => [
                [
                    'name' => 'মোঃ রহিম উদ্দিন',
                    'father_name' => 'মোঃ করিম উদ্দিন',
                    'address' => 'গ্রাম: পাড়াতলী, ডাকঘর: বগুড়া সদর, জেলা: বগুড়া'
                ]
            ],
            'objector_details' => null, // Added missing field
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '৫.৫০',
            'tree_compensation' => null, // Added missing field
            'infrastructure_compensation' => null, // Added missing field
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '২.৫০',
                    'total_compensation' => '২৫০০০০.০০',
                    'applicant_land' => '২.৫০'
                ]
            ],
            'district' => 'বগুড়া',
            'upazila' => 'বগুড়া সদর',
            'mouza_name' => 'পাড়াতলী',
            'jl_no' => '১৫',
            'sa_khatian_no' => '২০১',
            'rs_khatian_no' => null, // Added missing field
            'land_schedule_sa_plot_no' => $plotNo,
            'land_schedule_rs_plot_no' => null, // Added missing field
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '২০১',
                    'sa_total_land_in_plot' => '৫.০০',
                    'sa_land_in_khatian' => '২.৫০'
                ],
                'sa_owners' => [['name' => 'মোঃ রহিম উদ্দিন']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ করিম উদ্দিন']],
                        'recipient_names' => [['name' => 'মোঃ রহিম উদ্দিন']],
                        'deed_number' => 'DEED-১০০১',
                        'deed_date' => '২০২০-০১-১৫',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '২.৫০',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => $plotNo,
                        'possession_description' => 'জমিটি দীর্ঘদিন যাবৎ চাষাবাদের কাজে ব্যবহৃত',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => $plotNo
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ রহিম উদ্দিন',
                    'kharij_land_amount' => '২.৫০'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-১০০১',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [], // Added missing field
            'tax_info' => [
                'holding_no' => '১০০১',
                'paid_land_amount' => '২.৫০',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [], // Added missing field
            'kanungo_opinion' => [], // Added missing field
            'status' => 'pending'
        ]);
    }

    /**
     * Create land and trees case
     */
    private function createLandAndTreesCase()
    {
        $plotNo = '১০২';
        Compensation::create([
            'case_number' => '১০০২',
            'case_date' => '২০২৪-০২-১০',
            'applicants' => [
                [
                    'name' => 'মোছাঃ ফাতেমা খাতুন',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: কুমারপুর, ডাকঘর: শিবগঞ্জ, জেলা: বগুড়া',
                    'nid' => '৯৮৭৬৫৪৩২১০৯৮৭',
                    'mobile' => '০১৯৮৭৬৫৪৩২১'
                ]
            ],
            'la_case_no' => '২০০২',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'rs_plot_no' => null, // Added missing field
            'award_type' => ['জমি', 'গাছপালা/ফসল'],
            'land_award_serial_no' => 'LAS-৬০২', // Added missing field
            'tree_award_serial_no' => '৬০১',
            'infrastructure_award_serial_no' => null, // Added missing field
            'award_holder_names' => [
                [
                    'name' => 'মোছাঃ ফাতেমা খাতুন',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: কুমারপুর, ডাকঘর: শিবগঞ্জ, জেলা: বগুড়া'
                ]
            ],
            'objector_details' => null, // Added missing field
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '৭.২৫',
            'tree_compensation' => '৭৫০০০.৫০',
            'infrastructure_compensation' => null, // Added missing field
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '১.৭৫',
                    'total_compensation' => '১৭৫০০০.৭৫',
                    'applicant_land' => '১.৭৫'
                ],
                [
                    'category_name' => 'বাগান জমি',
                    'total_land' => '০.৫০',
                    'total_compensation' => '৮০০০০.২৫',
                    'applicant_land' => '০.৫০'
                ]
            ],
            'district' => 'বগুড়া',
            'upazila' => 'শিবগঞ্জ',
            'mouza_name' => 'কুমারপুর',
            'jl_no' => '২৫',
            'sa_khatian_no' => '৩০২',
            'rs_khatian_no' => null, // Added missing field
            'land_schedule_sa_plot_no' => $plotNo,
            'land_schedule_rs_plot_no' => null, // Added missing field
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '৩০২',
                    'sa_total_land_in_plot' => '৩.২৫',
                    'sa_land_in_khatian' => '২.২৫'
                ],
                'sa_owners' => [['name' => 'মোছাঃ ফাতেমা খাতুন']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ আব্দুল হামিদ']],
                        'recipient_names' => [['name' => 'মোছাঃ ফাতেমা খাতুন']],
                        'deed_number' => 'DEED-১০০২',
                        'deed_date' => '২০২০-০২-১০',
                        'sale_type' => 'দান দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '২.২৫',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => $plotNo,
                        'possession_description' => 'জমিটি পৈতৃক সম্পত্তি হিসেবে দান করা হয়েছে',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => $plotNo
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'মোছাঃ ফাতেমা খাতুন',
                    'kharij_land_amount' => '২.২৫'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-১০০২',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [], // Added missing field
            'tax_info' => [
                'holding_no' => '১০০২',
                'paid_land_amount' => '২.২৫',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [], // Added missing field
            'kanungo_opinion' => [], // Added missing field
            'status' => 'pending' // Added missing field
        ]);
    }

    /**
     * Create infrastructure case
     */
    private function createInfrastructureCase()
    {
        $plotNo = '২০৩';
        Compensation::create([
            'case_number' => '১০০৩',
            'case_date' => '২০২৪-০৩-০৫',
            'applicants' => [
                [
                    'name' => 'মোঃ আলমগীর হোসেন',
                    'father_name' => 'মোঃ নূরুল ইসলাম',
                    'address' => 'গ্রাম: রামপুর, ডাকঘর: শেরপুর, জেলা: বগুড়া',
                    'nid' => '৫৫৫৫৬৬৬৬৭৭৭৭৮',
                    'mobile' => '০১৫৫৫৬৬৬৭৭৭'
                ]
            ],
            'la_case_no' => '২০০৩',
            'acquisition_record_basis' => 'RS',
            'plot_no' => $plotNo,
            'sa_plot_no' => null, // Added missing field
            'rs_plot_no' => $plotNo,
            'award_type' => ['অবকাঠামো'],
            'land_award_serial_no' => null, // Added missing field
            'tree_award_serial_no' => null, // Added missing field
            'infrastructure_award_serial_no' => '৭০১',
            'award_holder_names' => [
                [
                    'name' => 'মোঃ আলমগীর হোসেন',
                    'father_name' => 'মোঃ নূরুল ইসলাম',
                    'address' => 'গ্রাম: রামপুর, ডাকঘর: শেরপুর, জেলা: বগুড়া'
                ]
            ],
            'objector_details' => null, // Added missing field
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '10.00',
            'tree_compensation' => null, // Added missing field
            'infrastructure_compensation' => '500000.00',
            'land_category' => [], // Added missing field
            'district' => 'বগুড়া',
            'upazila' => 'শেরপুর',
            'mouza_name' => 'রামপুর',
            'jl_no' => '৩৫',
            'sa_khatian_no' => null, // Added missing field
            'rs_khatian_no' => '৪০৩',
            'land_schedule_sa_plot_no' => null, // Added missing field
            'land_schedule_rs_plot_no' => $plotNo,
            'ownership_details' => [
                'rs_info' => [
                    'rs_plot_no' => $plotNo,
                    'rs_khatian_no' => '৪০৩',
                    'rs_total_land_in_plot' => '১.০০',
                    'rs_land_in_khatian' => '১.০০',
                    'dp_khatian' => false
                ],
                'sa_info' => null, // Added missing field
                'sa_owners' => [], // Added missing field
                'rs_owners' => [['name' => 'মোঃ আলমগীর হোসেন']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ নূরুল ইসলাম']],
                        'recipient_names' => [['name' => 'মোঃ আলমগীর হোসেন']],
                        'deed_number' => 'DEED-১০০৩',
                        'deed_date' => '২০২০-০৩-০৫',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '১.০০',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => $plotNo,
                        'possession_description' => 'জমিটি অবকাঠামো নির্মাণের জন্য ব্যবহৃত',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => $plotNo
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [
                    [
                        'plot_no' => $plotNo,
                        'khatian_no' => '৪০৩',
                        'land_amount' => '১.০০',
                        'owner_names' => [['name' => 'মোঃ আলমগীর হোসেন']]
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ আলমগীর হোসেন',
                    'kharij_land_amount' => '১.০০'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-1003',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ],
                    [
                        'type' => 'আরএস রেকর্ড যোগ',
                        'description' => 'দাগ নম্বর: ' . $plotNo,
                        'itemType' => 'rs',
                        'itemIndex' => 0,
                        'sequenceIndex' => 1
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => true
            ],
            'mutation_info' => [], // Added missing field
            'tax_info' => [
                'holding_no' => '1003',
                'paid_land_amount' => '1.00',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [], // Added missing field
            'kanungo_opinion' => [], // Added missing field
            'status' => 'pending' // Added missing field
        ]);
    }

    /**
     * Create multiple applicants case
     */
    private function createMultipleApplicantsCase()
    {
        $plotNo = '১০৪';
        Compensation::create([
            'case_number' => '১০০৪',
            'case_date' => '২০২৪-০৪-২০',
            'applicants' => [
                [
                    'name' => 'মোঃ সাইফুল ইসলাম',
                    'father_name' => 'মোঃ আব্দুর রহমান',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া',
                    'nid' => '১১১১২২২২৩৩৩৩৪',
                    'mobile' => '০১৭১১২২৩৩৪৪'
                ],
                [
                    'name' => 'মোছাঃ সালমা খাতুন',
                    'father_name' => 'মোঃ আব্দুর রহমান',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া',
                    'nid' => '২২২২৩৩৩৩৪৪৪৪৫',
                    'mobile' => '০১৮২২৩৩৪৪৫৫'
                ]
            ],
            'la_case_no' => '২০০৪',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'award_type' => ['জমি'],
            'land_award_serial_no' => '৫০৪',
            'award_holder_names' => [
                [
                    'name' => 'মোঃ আব্দুর রহমান',
                    'father_name' => 'মোঃ আব্দুল কাদের',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '৪.০০',
                    'total_compensation' => '৪০০০০০.০০',
                    'applicant_land' => '২.০০'
                ]
            ],
            'is_applicant_in_award' => false,
            'source_tax_percentage' => '৬.৭৫',
            'district' => 'বগুড়া',
            'upazila' => 'দুপচাঁচিয়া',
            'mouza_name' => 'নয়াপাড়া',
            'jl_no' => '৪৫',
            'sa_khatian_no' => '৫০৪',
            'land_schedule_sa_plot_no' => $plotNo,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '৫০৪',
                    'sa_total_land_in_plot' => '৪.০০',
                    'sa_land_in_khatian' => '২.০০'
                ],
                'sa_owners' => [['name' => 'মোঃ আব্দুর রহমান']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ আব্দুল কাদের']],
                        'recipient_names' => [['name' => 'মোঃ আব্দুর রহমান']],
                        'deed_number' => 'DEED-১০০৪',
                        'deed_date' => '২০২০-০৪-২০',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '২.০০',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => $plotNo,
                        'possession_description' => 'জমিটি যৌথ মালিকানায় রয়েছে',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => $plotNo
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ আব্দুর রহমান',
                    'kharij_land_amount' => '২.০০'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-১০০৪',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ]
        ]);
    }

    /**
     * Create decimal numbers test case
     */
    private function createDecimalTestCase()
    {
        $plotNo = '১০৫';
        Compensation::create([
            'case_number' => '১০০৫',
            'case_date' => '২০২৪-০৫-১৫',
            'applicants' => [
                [
                    'name' => 'দশমিক সংখ্যা টেস্ট',
                    'father_name' => 'নিউমেরিক ভ্যালিডেশন',
                    'address' => 'দশমিক পরীক্ষার ঠিকানা',
                    'nid' => '১২৩৪৫৬৭৮৯০১২৪',
                    'mobile' => '০১৭১২৩৪৫৬৭৯'
                ]
            ],
            'la_case_no' => '২০০৫',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'award_type' => ['জমি', 'গাছপালা/ফসল'],
            'tree_award_serial_no' => '৬০৫',
            'tree_compensation' => '১২৩৪৫.৬৭',
            'award_holder_names' => [
                [
                    'name' => 'দশমিক সংখ্যা টেস্ট',
                    'father_name' => 'নিউমেরিক ভ্যালিডেশন',
                    'address' => 'দশমিক পরীক্ষার ঠিকানা'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'দশমিক জমি',
                    'total_land' => '০.০১',
                    'total_compensation' => '১০০০.০১',
                    'applicant_land' => '০.০১'
                ],
                [
                    'category_name' => 'ভগ্নাংশ জমি',
                    'total_land' => '১২৩.৪৫',
                    'total_compensation' => '১২৩৪৫৬.৭৮',
                    'applicant_land' => '৬৭.৮৯'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '১২.৩৪',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '৫০৫',
                    'sa_total_land_in_plot' => '৯৯৯.৯৯',
                    'sa_land_in_khatian' => '১২৩.৪৫'
                ],
                'sa_owners' => [['name' => 'দশমিক সংখ্যা টেস্ট']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'নিউমেরিক ভ্যালিডেশন']],
                        'recipient_names' => [['name' => 'দশমিক সংখ্যা টেস্ট']],
                        'deed_number' => 'DEED-১০০৫',
                        'deed_date' => '২০২০-০৫-১৫',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'multiple',
                        'application_specific_area' => null,
                        'application_sell_area' => null,
                        'application_other_areas' => $plotNo . ', ১০৬',
                        'application_total_area' => '১২৩.৪৫',
                        'application_sell_area_other' => '৬৭.৮৯',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => $plotNo,
                        'possession_description' => 'দশমিক সংখ্যা পরীক্ষার জন্য ব্যবহৃত',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => $plotNo . ', ১০৬'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'দশমিক সংখ্যা টেস্ট',
                    'kharij_land_amount' => '৬৭.৮৯'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-১০০৫',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'tax_info' => [
                'holding_no' => '১০০৫',
                'paid_land_amount' => '৬৭.৮৯',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'district' => 'দশমিক জেলা',
            'upazila' => 'দশমিক উপজেলা',
            'mouza_name' => 'দশমিক মৌজা',
            'jl_no' => '১০৫'
        ]);
    }
}

