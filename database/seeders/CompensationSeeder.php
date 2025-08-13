<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compensation;

class CompensationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Compensation::truncate();

        // Generate comprehensive test cases for form validation
        $this->createTestCases();

        // Generate 3 compensations with all optional fields filled (maximal data)
        Compensation::factory()->count(3)->state(function (array $attributes) {
            $awardType = fake()->randomElement(['জমি', 'গাছপালা/ফসল', 'অবকাঠামো']);
            
            return [
                'case_number' => 'CASE-' . fake()->unique()->numberBetween(1000, 9999),
                'case_date' => fake()->date(),
                'sa_plot_no' => fake()->optional()->numberBetween(1, 999),
                'rs_plot_no' => fake()->optional()->numberBetween(1, 999),
                'applicants' => [
                    [
                        'name' => fake()->name(),
                        'father_name' => fake()->name(),
                        'address' => fake()->address(),
                        'nid' => fake()->numerify('##########'),
                        'mobile' => fake()->numerify('01########')
                    ]
                ],
                'la_case_no' => 'LA-' . fake()->unique()->numberBetween(1000, 9999),
                'award_type' => ['জমি', 'গাছপালা/ফসল'],
                'land_award_serial_no' => in_array($awardType, ['জমি', 'গাছপালা/ফসল']) ? 'LAS-' . fake()->numberBetween(100, 999) : null,
                'tree_award_serial_no' => $awardType === 'গাছপালা/ফসল' ? 'TAS-' . fake()->numberBetween(100, 999) : null,
                'infrastructure_award_serial_no' => $awardType === 'অবকাঠামো' ? 'IAS-' . fake()->numberBetween(100, 999) : null,
                'acquisition_record_basis' => fake()->randomElement(['SA', 'RS']),
                'plot_no' => fake()->numberBetween(1, 999),
                'award_holder_names' => [
                    [
                        'name' => fake()->name(),
                        'father_name' => fake()->name(),
                        'address' => fake()->address()
                    ]
                ],
                'objector_details' => null,
                'is_applicant_in_award' => fake()->boolean(),
                'source_tax_percentage' => fake()->randomFloat(2, 0.5, 15.0),
                'tree_compensation' => $awardType === 'গাছপালা/ফসল' ? fake()->numberBetween(25000, 75000) : null,
                'infrastructure_compensation' => $awardType === 'অবকাঠামো' ? fake()->numberBetween(100000, 500000) : null,
                'tax_info' => [
                    'english_year' => '2024-25',
                    'bangla_year' => '১৪৩১-৩২',
                    'holding_no' => 'HOLD-' . fake()->numberBetween(100, 999),
                    'paid_land_amount' => '১.৫০'
                ],
                'additional_documents_info' => [
                    'selected_types' => ['আপস- বন্টননামা', 'না-দাবি', 'সরেজমিন তদন্ত', 'এফিডেভিট'],
                    'details' => [
                        'আপস- বন্টননামা' => fake()->paragraph(),
                        'না-দাবি' => fake()->paragraph(),
                        'সরেজমিন তদন্ত' => fake()->paragraph(),
                        'এফিডেভিট' => fake()->paragraph()
                    ]
                ],
                'land_category' => [
                    [
                        'category_name' => 'ধানী জমি',
                        'total_land' => '১.০০',
                        'total_compensation' => '১০০০০০',
                        'applicant_land' => '১.০০'
                    ]
                ],
            ];
        })->create();

        // Generate 2 compensations with only minimal required fields (edge case)
        Compensation::factory()->count(2)->state(function (array $attributes) {
            return [
                'tree_compensation' => null,
                'infrastructure_compensation' => null,
                'objector_details' => null,
                'tax_info' => null,
                'additional_documents_info' => null,
                'land_category' => [
                    [
                        'category_name' => 'ধানী জমি',
                        'total_land' => '১.০০',
                        'total_compensation' => '১০০০০০',
                        'applicant_land' => '১.০০'
                    ]
                ],
            ];
        })->create();

        // Generate 2 compensations with multiple applicants and award holders (comprehensive test)
        Compensation::factory()->count(2)->state(function (array $attributes) {
            return [
                'applicants' => [
                    [
                        'name' => fake()->randomElement(['আবদুল করিম', 'মোহাম্মদ আলী', 'রশিদা খাতুন', 'ফাতেমা বেগম']),
                        'father_name' => fake()->randomElement(['আবদুর রহমান', 'মোস্তাফা কামাল', 'আবুল কাসেম', 'মোহাম্মদ হাসান']),
                        'address' => 'বাড়ি নং- ' . fake()->numberBetween(1, 999) . ', ' . fake()->randomElement(['কালিগঞ্জ', 'রামপুর', 'সোনারগাঁও']) . ' ' . fake()->randomElement(['গ্রাম', 'পাড়া']),
                        'nid' => fake()->numerify('#############'),
                        'mobile' => '01' . fake()->numerify('#########')
                    ],
                    [
                        'name' => fake()->randomElement(['সালমা খাতুন', 'আয়েশা বেগম', 'আবদুল জব্বার', 'মোহাম্মদ ইউসুফ']),
                        'father_name' => fake()->randomElement(['আবদুল মজিদ', 'মোহাম্মদ সালাম', 'আব্দুল হক', 'মোহাম্মদ নূর']),
                        'address' => 'বাড়ি নং- ' . fake()->numberBetween(1, 999) . ', ' . fake()->randomElement(['বাগবাড়ি', 'পূর্বপাড়া', 'দক্ষিণপাড়া']) . ' ' . fake()->randomElement(['মহল্লা', 'কলোনি']),
                        'nid' => fake()->numerify('#############'),
                        'mobile' => '01' . fake()->numerify('#########')
                    ]
                ],
                'award_holder_names' => [
                    [
                        'name' => fake()->randomElement(['রোকেয়া খাতুন', 'হাসিনা বেগম', 'আবদুল বারী', 'মোহাম্মদ শাহ']),
                        'father_name' => fake()->randomElement(['আবুল হোসেন', 'মিনারা বেগম', 'সুফিয়া খাতুন', 'নূরজাহান বেগম']),
                        'address' => 'বাড়ি নং- ' . fake()->numberBetween(1, 999) . ', ' . fake()->randomElement(['উত্তরপাড়া', 'মধ্যপাড়া', 'নতুনপাড়া']) . ' ' . fake()->randomElement(['গ্রাম', 'এলাকা'])
                    ],
                    [
                        'name' => fake()->randomElement(['শাহনাজ পারভীন', 'রাবেয়া খাতুন', 'আবদুল করিম', 'মোহাম্মদ আলী']),
                        'father_name' => fake()->randomElement(['আবদুর রহমান', 'মোস্তাফা কামাল', 'আবুল কাসেম', 'মোহাম্মদ হাসান']),
                        'address' => 'বাড়ি নং- ' . fake()->numberBetween(1, 999) . ', ' . fake()->randomElement(['পুরাতনপাড়া', 'বাজারপাড়া', 'স্কুলপাড়া']) . ' ' . fake()->randomElement(['পাড়া', 'মহল্লা'])
                    ]
                ],
                'district' => fake()->randomElement(['বগুড়া', 'ঢাকা', 'চট্টগ্রাম', 'রাজশাহী']),
                'upazila' => fake()->randomElement(['বগুড়া সদর', 'শিবগঞ্জ', 'শেরপুর', 'দুপচাঁচিয়া']),
            ];
        })->create();

        // Generate 3 compensations with complex ownership sequences (SA records)
        Compensation::factory()->count(3)->saRecord()->create();

        // Generate 3 compensations with complex RS ownership sequences (RS records with disabled second step)
        Compensation::factory()->count(3)->rsRecord()->create();

        // Generate 2 compensations with inheritance-heavy ownership sequences
        Compensation::factory()->count(2)->state(function (array $attributes) {
            return [
                'award_type' => ['জমি', 'গাছপালা/ফসল'],
                'tree_compensation' => fake()->numberBetween(25000, 75000),
            ];
        })->create();

        $this->command->info('Compensation records with comprehensive test cases seeded successfully!');
        $this->command->info('Total records created: ' . Compensation::count());
    }

    private function createTestCases()
    {
        $this->command->info('Creating comprehensive test data for form validation...');

        // Test Case 1: Basic Land Award (জমি) - Simple case with proper number formats
        $this->createBasicLandCase();

        // Test Case 2: Land and Trees Award (গাছপালা/ফসল) with decimal numbers
        Compensation::create([
            'case_number' => 'CASE-1002',
            'case_date' => '2024-01-15',
            'sa_plot_no' => 'SA-150',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'আব্দুল মালেক',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: মালেকপুর, পোস্ট: মালেকপুর, উপজেলা: শিবগঞ্জ, জেলা: বগুড়া',
                    'nid' => '1234567890',
                    'mobile' => '01712345678'
                ]
            ],
            'la_case_no' => 'LA-1002',
            'award_type' => ['গাছপালা/ফসল'],
            'land_award_serial_no' => '601',
            'tree_award_serial_no' => 'TAS-601',
            'tree_compensation' => '75000.50',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'SA-150',
            'award_holder_names' => [
                [
                    'name' => 'মোছাঃ ফাতেমা খাতুন',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: কুমারপুর, ডাকঘর: শিবগঞ্জ, জেলা: বগুড়া'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '1.75',
                    'total_compensation' => '175000.75',
                    'applicant_land' => '1.75'
                ],
                [
                    'category_name' => 'বাগান জমি',
                    'total_land' => '০.৫০',
                    'total_compensation' => '৮০০০০.২৫',
                    'applicant_land' => '০.৫০'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '7.25',
            'district' => 'বগুড়া',
            'upazila' => 'শিবগঞ্জ',
            'mouza_name' => 'কুমারপুর',
            'jl_no' => '25',
            'sa_khatian_no' => '302',
            'land_schedule_sa_plot_no' => 'SA-150',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-150',
                    'sa_khatian_no' => '302',
                    'sa_total_land_in_plot' => '৩.২৫',
                    'sa_land_in_khatian' => '২.২৫'
                ],
                'sa_owners' => [['name' => 'মোছাঃ ফাতেমা খাতুন']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ আব্দুল হামিদ']],
                        'recipient_names' => [['name' => 'মোছাঃ ফাতেমা খাতুন']],
                        'deed_number' => 'DEED-1002',
                        'deed_date' => '2020-02-10',
                        'sale_type' => 'দান দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'SA-150',
                        'application_sell_area' => '২.২৫',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'SA-150',
                        'possession_description' => 'জমিটি পৈতৃক সম্পত্তি হিসেবে দান করা হয়েছে',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'SA-150'
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
                        'description' => 'দলিল নম্বর: DEED-1002',
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
                'holding_no' => '1002',
                'paid_land_amount' => '২.২৫',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ]
        ]);

        // Test Case 3: Infrastructure Award (অবকাঠামো)
        $this->createInfrastructureCase();

        // Test Case 4: Mixed Award Types (জমি + গাছপালা/ফসল)
        Compensation::create([
            'case_number' => 'CASE-1004',
            'case_date' => '2024-01-20',
            'sa_plot_no' => 'SA-200',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'মোঃ রফিকুল ইসলাম',
                    'father_name' => 'মোঃ আব্দুল মতিন',
                    'address' => 'গ্রাম: রফিকপুর, পোস্ট: রফিকপুর, উপজেলা: দুপচাঁচিয়া, জেলা: বগুড়া',
                    'nid' => '1234567894',
                    'mobile' => '01712345682'
                ]
            ],
            'la_case_no' => 'LA-1004',
            'award_type' => ['জমি', 'গাছপালা/ফসল'],
            'land_award_serial_no' => '504',
            'tree_award_serial_no' => 'TAS-504',
            'tree_compensation' => '75000.50',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'SA-200',
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
                    'total_land' => '4.00',
                    'total_compensation' => '400000.00',
                    'applicant_land' => '2.00'
                ]
            ],
            'is_applicant_in_award' => false,
            'source_tax_percentage' => '6.75',
            'district' => 'বগুড়া',
            'upazila' => 'দুপচাঁচিয়া',
            'mouza_name' => 'নয়াপাড়া',
            'jl_no' => '45',
            'sa_khatian_no' => '504',
            'land_schedule_sa_plot_no' => 'SA-200',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-200',
                    'sa_khatian_no' => '504',
                    'sa_total_land_in_plot' => '4.00',
                    'sa_land_in_khatian' => '2.00'
                ],
                'sa_owners' => [['name' => 'মোঃ আব্দুর রহমান']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ আব্দুল কাদের']],
                        'recipient_names' => [['name' => 'মোঃ আব্দুর রহমান']],
                        'deed_number' => 'DEED-1004',
                        'deed_date' => '2020-04-20',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'SA-200',
                        'application_sell_area' => '2.00',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'SA-200',
                        'possession_description' => 'জমিটি যৌথ মালিকানায় রয়েছে',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'SA-200'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ আব্দুর রহমান',
                    'kharij_land_amount' => '2.00'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-1004',
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

        // Test Case 5: Complex decimal numbers test
        $this->createDecimalTestCase();
    }

    private function createBasicLandCase()
    {
        $plotNo = '101';
        Compensation::create([
            'case_number' => '1001',
            'case_date' => '2024-01-15',
            'applicants' => [
                [
                    'name' => 'মোঃ রহিম উদ্দিন',
                    'father_name' => 'মোঃ করিম উদ্দিন',
                    'address' => 'গ্রাম: পাড়াতলী, ডাকঘর: বগুড়া সদর, জেলা: বগুড়া',
                    'nid' => '1234567890123',
                    'mobile' => '01712345678'
                ]
            ],
            'la_case_no' => '2001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'award_type' => ['জমি'],
            'land_award_serial_no' => '501',
            'award_holder_names' => [
                [
                    'name' => 'মোঃ রহিম উদ্দিন',
                    'father_name' => 'মোঃ করিম উদ্দিন',
                    'address' => 'গ্রাম: পাড়াতলী, ডাকঘর: বগুড়া সদর, জেলা: বগুড়া'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '2.50',
                    'total_compensation' => '250000.00',
                    'applicant_land' => '2.50'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5.50',
            'district' => 'বগুড়া',
            'upazila' => 'বগুড়া সদর',
            'mouza_name' => 'পাড়াতলী',
            'jl_no' => '15',
            'sa_khatian_no' => '201',
            'land_schedule_sa_plot_no' => $plotNo,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '201',
                    'sa_total_land_in_plot' => '5.00',
                    'sa_land_in_khatian' => '2.50'
                ],
                'sa_owners' => [['name' => 'মোঃ রহিম উদ্দিন']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ করিম উদ্দিন']],
                        'recipient_names' => [['name' => 'মোঃ রহিম উদ্দিন']],
                        'deed_number' => 'DEED-1001',
                        'deed_date' => '2020-01-15',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '2.50',
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
                    'kharij_land_amount' => '2.50'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-1001',
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
                'holding_no' => '1001',
                'paid_land_amount' => '2.50',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'status' => 'pending'
        ]);
    }

    private function createLandAndTreesCase()
    {
        $plotNo = '102';
        Compensation::create([
            'case_number' => '1002',
            'case_date' => '2024-02-10',
            'applicants' => [
                [
                    'name' => 'মোছাঃ ফাতেমা খাতুন',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: কুমারপুর, ডাকঘর: শিবগঞ্জ, জেলা: বগুড়া',
                    'nid' => '9876543210987',
                    'mobile' => '01987654321'
                ]
            ],
            'la_case_no' => '2002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'award_type' => ['জমি', 'গাছপালা/ফসল'],
            'tree_award_serial_no' => '601',
            'tree_compensation' => '75000.50',
            'award_holder_names' => [
                [
                    'name' => 'মোছাঃ ফাতেমা খাতুন',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: কুমারপুর, ডাকঘর: শিবগঞ্জ, জেলা: বগুড়া'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '1.75',
                    'total_compensation' => '175000.75',
                    'applicant_land' => '1.75'
                ],
                [
                    'category_name' => 'বাগান জমি',
                    'total_land' => '0.50',
                    'total_compensation' => '80000.25',
                    'applicant_land' => '0.50'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '7.25',
            'district' => 'বগুড়া',
            'upazila' => 'শিবগঞ্জ',
            'mouza_name' => 'কুমারপুর',
            'jl_no' => '25',
            'sa_khatian_no' => '302',
            'land_schedule_sa_plot_no' => $plotNo,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '302',
                    'sa_total_land_in_plot' => '3.25',
                    'sa_land_in_khatian' => '2.25'
                ],
                'sa_owners' => [['name' => 'মোছাঃ ফাতেমা খাতুন']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ আব্দুল হামিদ']],
                        'recipient_names' => [['name' => 'মোছাঃ ফাতেমা খাতুন']],
                        'deed_number' => 'DEED-1002',
                        'deed_date' => '2020-02-10',
                        'sale_type' => 'দান দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '2.25',
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
                    'kharij_land_amount' => '2.25'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-1002',
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
                'holding_no' => '1002',
                'paid_land_amount' => '2.25',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ]
        ]);
    }

    private function createInfrastructureCase()
    {
        $plotNo = '203';
        Compensation::create([
            'case_number' => '1003',
            'case_date' => '2024-03-05',
            'applicants' => [
                [
                    'name' => 'মোঃ আলমগীর হোসেন',
                    'father_name' => 'মোঃ নূরুল ইসলাম',
                    'address' => 'গ্রাম: রামপুর, ডাকঘর: শেরপুর, জেলা: বগুড়া',
                    'nid' => '5555666677778',
                    'mobile' => '01555666777'
                ]
            ],
            'la_case_no' => '2003',
            'acquisition_record_basis' => 'RS',
            'plot_no' => $plotNo,
            'rs_plot_no' => $plotNo,
            'award_type' => ['অবকাঠামো'],
            'infrastructure_award_serial_no' => '701',
            'infrastructure_compensation' => '500000.00',
            'award_holder_names' => [
                [
                    'name' => 'মোঃ আলমগীর হোসেন',
                    'father_name' => 'মোঃ নূরুল ইসলাম',
                    'address' => 'গ্রাম: রামপুর, ডাকঘর: শেরপুর, জেলা: বগুড়া'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '10.00',
            'district' => 'বগুড়া',
            'upazila' => 'শেরপুর',
            'mouza_name' => 'রামপুর',
            'jl_no' => '35',
            'rs_khatian_no' => '403',
            'land_schedule_rs_plot_no' => $plotNo,
            'ownership_details' => [
                'rs_info' => [
                    'rs_plot_no' => $plotNo,
                    'rs_khatian_no' => '403',
                    'rs_total_land_in_plot' => '1.00',
                    'rs_land_in_khatian' => '1.00',
                    'dp_khatian' => false
                ],
                'rs_owners' => [['name' => 'মোঃ আলমগীর হোসেন']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ নূরুল ইসলাম']],
                        'recipient_names' => [['name' => 'মোঃ আলমগীর হোসেন']],
                        'deed_number' => 'DEED-1003',
                        'deed_date' => '2020-03-05',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '1.00',
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
                        'khatian_no' => '403',
                        'land_amount' => '1.00',
                        'owner_names' => [['name' => 'মোঃ আলমগীর হোসেন']]
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ আলমগীর হোসেন',
                    'kharij_land_amount' => '1.00'
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
            'tax_info' => [
                'holding_no' => '1003',
                'paid_land_amount' => '1.00',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ]
        ]);
    }

    private function createMultipleApplicantsCase()
    {
        $plotNo = '104';
        Compensation::create([
            'case_number' => '1004',
            'case_date' => '2024-04-20',
            'applicants' => [
                [
                    'name' => 'মোঃ সাইফুল ইসলাম',
                    'father_name' => 'মোঃ আব্দুর রহমান',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া',
                    'nid' => '1111222233334',
                    'mobile' => '01711223344'
                ],
                [
                    'name' => 'মোছাঃ সালমা খাতুন',
                    'father_name' => 'মোঃ আব্দুর রহমান',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া',
                    'nid' => '2222333344445',
                    'mobile' => '01822334455'
                ]
            ],
            'la_case_no' => '2004',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'award_type' => ['জমি'],
            'land_award_serial_no' => '504',
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
                    'total_land' => '4.00',
                    'total_compensation' => '400000.00',
                    'applicant_land' => '2.00'
                ]
            ],
            'is_applicant_in_award' => false,
            'source_tax_percentage' => '6.75',
            'district' => 'বগুড়া',
            'upazila' => 'দুপচাঁচিয়া',
            'mouza_name' => 'নয়াপাড়া',
            'jl_no' => '45',
            'sa_khatian_no' => '504',
            'land_schedule_sa_plot_no' => $plotNo,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '504',
                    'sa_total_land_in_plot' => '4.00',
                    'sa_land_in_khatian' => '2.00'
                ],
                'sa_owners' => [['name' => 'মোঃ আব্দুর রহমান']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ আব্দুল কাদের']],
                        'recipient_names' => [['name' => 'মোঃ আব্দুর রহমান']],
                        'deed_number' => 'DEED-1004',
                        'deed_date' => '2020-04-20',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => $plotNo,
                        'application_sell_area' => '2.00',
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
                    'kharij_land_amount' => '2.00'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-1004',
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

    private function createDecimalTestCase()
    {
        $plotNo = '105';
        Compensation::create([
            'case_number' => '1005',
            'case_date' => '2024-05-15',
            'applicants' => [
                [
                    'name' => 'দশমিক সংখ্যা টেস্ট',
                    'father_name' => 'নিউমেরিক ভ্যালিডেশন',
                    'address' => 'দশমিক পরীক্ষার ঠিকানা',
                    'nid' => '1234567890124',
                    'mobile' => '01712345679'
                ]
            ],
            'la_case_no' => '2005',
            'acquisition_record_basis' => 'SA',
            'plot_no' => $plotNo,
            'sa_plot_no' => $plotNo,
            'award_type' => ['জমি', 'গাছপালা/ফসল'],
            'tree_award_serial_no' => '605',
            'tree_compensation' => '12345.67',
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
                    'total_land' => '0.01',
                    'total_compensation' => '1000.01',
                    'applicant_land' => '0.01'
                ],
                [
                    'category_name' => 'ভগ্নাংশ জমি',
                    'total_land' => '123.45',
                    'total_compensation' => '123456.78',
                    'applicant_land' => '67.89'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '12.34',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => $plotNo,
                    'sa_khatian_no' => '505',
                    'sa_total_land_in_plot' => '999.99',
                    'sa_land_in_khatian' => '123.45'
                ],
                'sa_owners' => [['name' => 'দশমিক সংখ্যা টেস্ট']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'নিউমেরিক ভ্যালিডেশন']],
                        'recipient_names' => [['name' => 'দশমিক সংখ্যা টেস্ট']],
                        'deed_number' => 'DEED-1005',
                        'deed_date' => '2020-05-15',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'multiple',
                        'application_specific_area' => null,
                        'application_sell_area' => null,
                        'application_other_areas' => $plotNo . ', 106',
                        'application_total_area' => '123.45',
                        'application_sell_area_other' => '67.89',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => $plotNo,
                        'possession_description' => 'দশমিক সংখ্যা পরীক্ষার জন্য ব্যবহৃত',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => $plotNo . ', 106'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'দশমিক সংখ্যা টেস্ট',
                    'kharij_land_amount' => '67.89'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-1005',
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
                'holding_no' => '1005',
                'paid_land_amount' => '67.89',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'district' => 'দশমিক জেলা',
            'upazila' => 'দশমিক উপজেলা',
            'mouza_name' => 'দশমিক মৌজা',
            'jl_no' => '105'
        ]);
    }
} 