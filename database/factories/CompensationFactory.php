<?php

namespace Database\Factories;

use App\Models\Compensation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compensation>
 */
class CompensationFactory extends Factory
{
    /**
     * Generate Bengali names
     */
    private function getBengaliName(): string
    {
        $firstNames = [
            'আবদুল করিম', 'মোহাম্মদ আলী', 'আবদুর রহমান', 'মোস্তাফা কামাল', 'আবুল কাসেম',
            'মোহাম্মদ হাসান', 'আবদুল জব্বার', 'মোহাম্মদ ইউসুফ', 'আবদুল মজিদ', 'মোহাম্মদ সালাম',
            'রশিদা খাতুন', 'ফাতেমা বেগম', 'সালমা খাতুন', 'আয়েশা বেগম', 'রোকেয়া খাতুন',
            'হাসিনা বেগম', 'জোহরা খাতুন', 'নাসিরা বেগম', 'আমিনা খাতুন', 'সাকিনা বেগম',
            'আব্দুল হক', 'মোহাম্মদ নূর', 'আবদুল বারী', 'মোহাম্মদ শাহ', 'আবুল হোসেন',
            'মিনারা বেগম', 'সুফিয়া খাতুন', 'নূরজাহান বেগম', 'শাহনাজ পারভীন', 'রাবেয়া খাতুন'
        ];
        
        return $this->faker->randomElement($firstNames);
    }

    /**
     * Generate Bengali addresses
     */
    private function getBengaliAddress(): string
    {
        $villages = [
            'কালিগঞ্জ', 'রামপুর', 'সোনারগাঁও', 'বাগবাড়ি', 'পূর্বপাড়া', 'দক্ষিণপাড়া', 'উত্তরপাড়া',
            'মধ্যপাড়া', 'নতুনপাড়া', 'পুরাতনপাড়া', 'বাজারপাড়া', 'স্কুলপাড়া', 'মসজিদপাড়া',
            'চরপাড়া', 'বিলপাড়া', 'হাটবাজার', 'কামারপাড়া', 'তাঁতিপাড়া', 'জেলেপাড়া'
        ];
        
        $areas = [
            'গ্রাম', 'পাড়া', 'মহল্লা', 'কলোনি', 'এলাকা'
        ];
        
        $village = $this->faker->randomElement($villages);
        $area = $this->faker->randomElement($areas);
        $houseNo = $this->getBengaliNumber(1, 999);
        
        return "বাড়ি নং- {$houseNo}, {$village} {$area}";
    }

    /**
     * Generate Bengali sentence/description
     */
    private function getBengaliDescription(): string
    {
        $descriptions = [
            'জমিটি কৃষি কাজে ব্যবহৃত হয়।',
            'উক্ত জমিতে ধান ও গম চাষ হয়।',
            'জমিটি আবাদী ও উর্বর।',
            'এই জমিতে বিভিন্ন ফসল উৎপাদন হয়।',
            'জমিটি পৈতৃক সম্পত্তি।',
            'উক্ত জমি দীর্ঘদিন যাবৎ চাষাবাদের কাজে ব্যবহৃত।',
            'জমিটি সেচ সুবিধাযুক্ত।',
            'এই জমিতে বিভিন্ন ধরনের গাছপালা রয়েছে।'
        ];
        
        return $this->faker->randomElement($descriptions);
    }
    
    /**
     * Generate Bengali numbers
     */
    private function getBengaliNumber(int $min = 1, int $max = 999): string
    {
        $number = $this->faker->numberBetween($min, $max);
        return $this->convertToBengali($number);
    }
    
    /**
     * Convert English numbers to Bengali numbers
     */
    private function convertToBengali($value): string
    {
        if (!$value) {
            return '';
        }
        
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        
        return str_replace($englishNumerals, $bengaliNumerals, (string)$value);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $awardType = $this->faker->randomElement(['জমি', 'গাছপালা/ফসল', 'অবকাঠামো']);
        $acquisitionBasis = $this->faker->randomElement(['SA', 'RS']);
        
        // Generate plot numbers based on acquisition basis
        $plotNo = $acquisitionBasis === 'SA' ? 'SA-' . $this->getBengaliNumber(100, 999) : 'RS-' . $this->getBengaliNumber(100, 999);
        
        return [
            'case_number' => 'CASE-' . $this->getBengaliNumber(1000, 9999),
            'case_date' => $this->faker->date(),
            'sa_plot_no' => $acquisitionBasis === 'SA' ? $plotNo : null,
            'rs_plot_no' => $acquisitionBasis === 'RS' ? $plotNo : null,
            'applicants' => [
                [
                    'name' => $this->getBengaliName(),
                    'father_name' => $this->getBengaliName(),
                    'address' => $this->getBengaliAddress(),
                    'nid' => $this->convertToBengali($this->faker->numerify('##########')),
                    'mobile' => $this->convertToBengali($this->faker->numerify('01########'))
                ]
            ],
            'la_case_no' => 'LA-' . $this->getBengaliNumber(1000, 9999),
            'award_type' => [$awardType],
            'land_award_serial_no' => in_array($awardType, ['জমি', 'গাছপালা/ফসল']) ? 'LAS-' . $this->getBengaliNumber(100, 999) : null,
            'tree_award_serial_no' => $awardType === 'গাছপালা/ফসল' ? 'TAS-' . $this->getBengaliNumber(100, 999) : null,
            'infrastructure_award_serial_no' => $awardType === 'অবকাঠামো' ? 'IAS-' . $this->getBengaliNumber(100, 999) : null,
            'acquisition_record_basis' => $acquisitionBasis,
            'plot_no' => $plotNo,
            'award_holder_names' => [
                [
                    'name' => $this->getBengaliName(),
                    'father_name' => $this->getBengaliName(),
                    'address' => $this->getBengaliAddress()
                ]
            ],
            'land_category' => [
                [
                    'category_name' => $this->faker->randomElement(['আবাদি জমি', 'অনাবাদি জমি', 'বাড়িঘর', 'ধানী জমি', 'বাগান জমি']),
                    'total_land' => $this->convertToBengali($this->faker->randomFloat(2, 1, 10)),
                    'total_compensation' => $this->convertToBengali($this->faker->numberBetween(100000, 1000000)),
                    'applicant_land' => $this->convertToBengali($this->faker->randomFloat(2, 0.5, 5))
                ]
            ],
            'objector_details' => null,
            'is_applicant_in_award' => $this->faker->boolean(),
            'source_tax_percentage' => $this->faker->randomFloat(2, 0.5, 15.0),
            'tree_compensation' => in_array('গাছপালা/ফসল', [$awardType]) ? $this->convertToBengali($this->faker->numberBetween(25000, 75000)) : null,
            'infrastructure_compensation' => $awardType === 'অবকাঠামো' ? $this->convertToBengali($this->faker->numberBetween(100000, 500000)) : null,
            'district' => $this->faker->randomElement(['বগুড়া', 'ঢাকা', 'চট্টগ্রাম', 'রাজশাহী', 'খুলনা', 'সিলেট', 'রংপুর', 'বরিশাল']),
            'upazila' => $this->faker->randomElement(['বগুড়া সদর', 'শিবগঞ্জ', 'শেরপুর', 'দুপচাঁচিয়া', 'আদমদীঘি', 'নন্দীগ্রাম', 'সোনাতলা', 'ধুনট', 'গাবতলী', 'কাহালু', 'সারিয়াকান্দি', 'শাজাহানপুর']),
            'mouza_name' => $this->faker->city(),
            'jl_no' => 'JL-' . $this->getBengaliNumber(100, 999),
            'land_schedule_sa_plot_no' => $acquisitionBasis === 'SA' ? $plotNo : null,
            'land_schedule_rs_plot_no' => $acquisitionBasis === 'RS' ? $plotNo : null,
            'sa_khatian_no' => $acquisitionBasis === 'SA' ? 'SA-KH-' . $this->getBengaliNumber(100, 999) : null,
            'rs_khatian_no' => $acquisitionBasis === 'RS' ? 'RS-KH-' . $this->getBengaliNumber(100, 999) : null,
            'ownership_details' => $this->generateOwnershipDetails($acquisitionBasis, $plotNo),
            'mutation_info' => null,
            'tax_info' => [
                'english_year' => '2024-25',
                'bangla_year' => '১৪৩১-৩২',
                'holding_no' => 'HOLD-' . $this->getBengaliNumber(100, 999),
                'paid_land_amount' => $this->convertToBengali($this->faker->randomFloat(2, 0.5, 5))
            ],
            'additional_documents_info' => [
                'selected_types' => [$this->faker->randomElement(['আপস- বন্টননামা', 'না-দাবি', 'সরেজমিন তদন্ত', 'এফিডেভিট'])],
                'details' => [
                    'আপস- বন্টননামা' => $this->faker->paragraph(),
                    'না-দাবি' => $this->faker->paragraph(),
                    'সরেজমিন তদন্ত' => $this->faker->paragraph(),
                    'এফিডেভিট' => $this->faker->paragraph()
                ]
            ],
            'kanungo_opinion' => null,
            'order_signature_date' => null,
            'signing_officer_name' => null,
            'status' => 'pending'
        ];
    }

    /**
     * Generate ownership details based on acquisition basis
     */
    private function generateOwnershipDetails(string $acquisitionBasis, string $plotNo): array
    {
        if ($acquisitionBasis === 'SA') {
            return $this->generateSAOwnershipDetails($plotNo);
        } else {
            return $this->generateRSOwnershipDetails($plotNo);
        }
    }

    /**
     * Generate SA ownership details with complete and consistent data
     */
    private function generateSAOwnershipDetails(string $plotNo): array
    {
        $deedCount = $this->faker->numberBetween(1, 2);
        $inheritanceCount = $this->faker->numberBetween(0, 1);
        
        // Generate deed transfers with complete data
        $deedTransfers = [];
        $storySequence = [];
        $sequenceIndex = 0;
        
        for ($i = 0; $i < $deedCount; $i++) {
            $applicationType = $this->faker->randomElement(['specific', 'multiple']);
            $sellArea = $this->faker->randomFloat(2, 1, 5);
            
            if ($applicationType === 'specific') {
                $deedTransfers[] = [
                    'donor_names' => [['name' => $this->getBengaliName()]],
                    'recipient_names' => [['name' => $this->getBengaliName()]],
                    'deed_number' => 'DEED-' . $this->getBengaliNumber(1000, 9999),
                    'deed_date' => $this->faker->date('Y-m-d'),
                    'sale_type' => $this->faker->randomElement(['বিক্রয় দলিল', 'দান দলিল', 'বায়া দলিল']),
                    'application_type' => 'specific',
                    'application_specific_area' => $plotNo,
                    'application_sell_area' => $sellArea,
                    'application_other_areas' => null,
                    'application_total_area' => null,
                    'application_sell_area_other' => null,
                    'possession_mentioned' => 'yes',
                    'possession_plot_no' => $plotNo,
                    'possession_description' => $this->getBengaliDescription(),
                    'possession_deed' => 'yes',
                    'possession_application' => 'yes',
                    'mentioned_areas' => $plotNo,
                    'special_details' => $this->faker->optional(0.3)->passthrough($this->getBengaliDescription()),
                    'tax_info' => $this->faker->optional(0.7)->passthrough($this->getBengaliDescription())
                ];
            } else {
                $otherAreas = $plotNo . ', ' . 'SA-' . $this->getBengaliNumber(100, 999);
                $totalArea = $sellArea + $this->faker->randomFloat(2, 1, 3);
                $sellAreaOther = $this->faker->randomFloat(2, 1, 3);
                
                $deedTransfers[] = [
                    'donor_names' => [['name' => $this->getBengaliName()]],
                    'recipient_names' => [['name' => $this->getBengaliName()]],
                    'deed_number' => 'DEED-' . $this->getBengaliNumber(1000, 9999),
                    'deed_date' => $this->faker->date('Y-m-d'),
                    'sale_type' => $this->faker->randomElement(['বিক্রয় দলিল', 'দান দলিল', 'বায়া দলিল']),
                    'application_type' => 'multiple',
                    'application_specific_area' => null,
                    'application_sell_area' => null,
                    'application_other_areas' => $otherAreas,
                    'application_total_area' => $totalArea,
                    'application_sell_area_other' => $sellAreaOther,
                    'possession_mentioned' => 'yes',
                    'possession_plot_no' => $plotNo,
                    'possession_description' => $this->getBengaliDescription(),
                    'possession_deed' => 'yes',
                    'possession_application' => 'yes',
                    'mentioned_areas' => $otherAreas,
                    'special_details' => $this->faker->optional(0.3)->passthrough($this->getBengaliDescription()),
                    'tax_info' => $this->faker->optional(0.7)->passthrough($this->getBengaliDescription())
                ];
            }
            
            $storySequence[] = [
                'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                'description' => 'দলিল নম্বর: DEED-' . $this->getBengaliNumber(1000, 9999) . ', তারিখ: ' . $this->faker->date('d/m/Y'),
                'itemType' => 'deed',
                'itemIndex' => $i,
                'sequenceIndex' => $sequenceIndex++
            ];
        }
        
        // Generate inheritance records if any
        $inheritanceRecords = [];
        for ($i = 0; $i < $inheritanceCount; $i++) {
            $inheritanceRecords[] = [
                'is_heir_applicant' => $this->faker->randomElement(['yes', 'no']),
                'has_death_cert' => $this->faker->randomElement(['yes', 'no']),
                'heirship_certificate_info' => $this->getBengaliDescription(),
                'previous_owner_name' => $this->getBengaliName(),
                'death_date' => $this->faker->date('Y-m-d')
            ];
            
            $storySequence[] = [
                'type' => 'ওয়ারিশমূলে হস্তান্তর',
                'description' => 'পূর্ববর্তী মালিক: ' . $this->getBengaliName(),
                'itemType' => 'inheritance',
                'itemIndex' => $i,
                'sequenceIndex' => $sequenceIndex++
            ];
        }
        
        return [
            'sa_info' => [
                'sa_plot_no' => $plotNo,
                'sa_khatian_no' => 'SA-KH-' . $this->getBengaliNumber(100, 999),
                'sa_total_land_in_plot' => $this->convertToBengali($this->faker->randomFloat(2, 5, 20)),
                'sa_land_in_khatian' => $this->convertToBengali($this->faker->randomFloat(2, 2, 10))
            ],
            'sa_owners' => [
                ['name' => $this->getBengaliName()],
                ['name' => $this->getBengaliName()]
            ],
            'deed_transfers' => $deedTransfers,
            'inheritance_records' => $inheritanceRecords,
            'rs_records' => [], // Empty for SA records
            'applicant_info' => [
                'applicant_name' => $this->getBengaliName(),
                'kharij_land_amount' => $this->convertToBengali($this->faker->randomFloat(2, 0.5, 5))
            ],
            'storySequence' => $storySequence,
            'currentStep' => 'applicant',
            'completedSteps' => ['info', 'transfers', 'applicant'],
            'rs_record_disabled' => false
        ];
    }

    /**
     * Generate RS ownership details with complete and consistent data
     */
    private function generateRSOwnershipDetails(string $plotNo): array
    {
        $deedCount = $this->faker->numberBetween(1, 2);
        $inheritanceCount = $this->faker->numberBetween(0, 1);
        
        // Generate deed transfers with complete data
        $deedTransfers = [];
        $storySequence = [];
        $sequenceIndex = 0;
        
        for ($i = 0; $i < $deedCount; $i++) {
            $applicationType = $this->faker->randomElement(['specific', 'multiple']);
            $sellArea = $this->faker->randomFloat(2, 1, 5);
            
            if ($applicationType === 'specific') {
                $deedTransfers[] = [
                    'donor_names' => [['name' => $this->getBengaliName()]],
                    'recipient_names' => [['name' => $this->getBengaliName()]],
                    'deed_number' => 'DEED-' . $this->faker->numberBetween(1000, 9999),
                    'deed_date' => $this->faker->date('Y-m-d'),
                    'sale_type' => $this->faker->randomElement(['বিক্রয় দলিল', 'দান দলিল', 'বায়া দলিল']),
                    'application_type' => 'specific',
                    'application_specific_area' => $plotNo,
                    'application_sell_area' => $sellArea,
                    'application_other_areas' => null,
                    'application_total_area' => null,
                    'application_sell_area_other' => null,
                    'possession_mentioned' => 'yes',
                    'possession_plot_no' => $plotNo,
                    'possession_description' => $this->getBengaliDescription(),
                    'possession_deed' => 'yes',
                    'possession_application' => 'yes',
                    'mentioned_areas' => $plotNo,
                    'special_details' => $this->faker->optional(0.3)->passthrough($this->getBengaliDescription()),
                    'tax_info' => $this->faker->optional(0.7)->passthrough($this->getBengaliDescription())
                ];
            } else {
                $otherAreas = $plotNo . ', ' . 'RS-' . $this->getBengaliNumber(100, 999);
                $totalArea = $sellArea + $this->faker->randomFloat(2, 1, 3);
                $sellAreaOther = $this->faker->randomFloat(2, 1, 3);
                
                $deedTransfers[] = [
                    'donor_names' => [['name' => $this->getBengaliName()]],
                    'recipient_names' => [['name' => $this->getBengaliName()]],
                    'deed_number' => 'DEED-' . $this->getBengaliNumber(1000, 9999),
                    'deed_date' => $this->faker->date('Y-m-d'),
                    'sale_type' => $this->faker->randomElement(['বিক্রয় দলিল', 'দান দলিল', 'বায়া দলিল']),
                    'application_type' => 'multiple',
                    'application_specific_area' => null,
                    'application_sell_area' => null,
                    'application_other_areas' => $otherAreas,
                    'application_total_area' => $totalArea,
                    'application_sell_area_other' => $sellAreaOther,
                    'possession_mentioned' => 'yes',
                    'possession_plot_no' => $plotNo,
                    'possession_description' => $this->getBengaliDescription(),
                    'possession_deed' => 'yes',
                    'possession_application' => 'yes',
                    'mentioned_areas' => $otherAreas,
                    'special_details' => $this->faker->optional(0.3)->passthrough($this->getBengaliDescription()),
                    'tax_info' => $this->faker->optional(0.7)->passthrough($this->getBengaliDescription())
                ];
            }
            
            $storySequence[] = [
                'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                'description' => 'দলিল নম্বর: DEED-' . $this->getBengaliNumber(1000, 9999) . ', তারিখ: ' . $this->faker->date('d/m/Y'),
                'itemType' => 'deed',
                'itemIndex' => $i,
                'sequenceIndex' => $sequenceIndex++
            ];
        }
        
        // Generate inheritance records if any
        $inheritanceRecords = [];
        for ($i = 0; $i < $inheritanceCount; $i++) {
            $inheritanceRecords[] = [
                'is_heir_applicant' => $this->faker->randomElement(['yes', 'no']),
                'has_death_cert' => $this->faker->randomElement(['yes', 'no']),
                'heirship_certificate_info' => $this->getBengaliDescription(),
                'previous_owner_name' => $this->getBengaliName(),
                'death_date' => $this->faker->date('Y-m-d')
            ];
            
            $storySequence[] = [
                'type' => 'ওয়ারিশমূলে হস্তান্তর',
                'description' => 'পূর্ববর্তী মালিক: ' . $this->getBengaliName(),
                'itemType' => 'inheritance',
                'itemIndex' => $i,
                'sequenceIndex' => $sequenceIndex++
            ];
        }
        
        // Generate RS records (only for first step, not second step as per requirement)
        $rsRecords = [
            [
                'plot_no' => $plotNo,
                'khatian_no' => 'RS-KH-' . $this->getBengaliNumber(100, 999),
                'land_amount' => $this->convertToBengali($this->faker->randomFloat(2, 1, 10)),
                'owner_names' => [
                    ['name' => $this->getBengaliName()],
                    ['name' => $this->getBengaliName()]
                ]
            ]
        ];
        
        $storySequence[] = [
            'type' => 'আরএস রেকর্ড যোগ',
            'description' => 'দাগ নম্বর: ' . $plotNo,
            'itemType' => 'rs',
            'itemIndex' => 0,
            'sequenceIndex' => $sequenceIndex++
        ];
        
        return [
            'rs_info' => [
                'rs_plot_no' => $plotNo,
                'rs_khatian_no' => 'RS-KH-' . $this->getBengaliNumber(100, 999),
                'rs_total_land_in_plot' => $this->convertToBengali($this->faker->randomFloat(2, 5, 20)),
                'rs_land_in_khatian' => $this->convertToBengali($this->faker->randomFloat(2, 2, 10)),
                'dp_khatian' => $this->faker->boolean()
            ],
            'rs_owners' => [
                ['name' => $this->getBengaliName()],
                ['name' => $this->getBengaliName()]
            ],
            'deed_transfers' => $deedTransfers,
            'inheritance_records' => $inheritanceRecords,
            'rs_records' => $rsRecords,
            'applicant_info' => [
                'applicant_name' => $this->getBengaliName(),
                'kharij_land_amount' => $this->convertToBengali($this->faker->randomFloat(2, 0.5, 5))
            ],
            'storySequence' => $storySequence,
            'currentStep' => 'applicant',
            'completedSteps' => ['info', 'transfers', 'applicant'],
            'rs_record_disabled' => true  // RS records disabled in second step as per requirement
        ];
    }

    /**
     * Indicate that the compensation is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'done',
            'order_signature_date' => $this->faker->date('Y-m-d'),
            'signing_officer_name' => $this->faker->name(),
            'kanungo_opinion' => [
                'has_ownership_continuity' => $this->faker->randomElement(['yes', 'no']),
                'opinion_details' => $this->faker->paragraph()
            ]
        ]);
    }

    /**
     * Indicate that the compensation has kanungo opinion.
     */
    public function withKanungoOpinion(): static
    {
        return $this->state(fn (array $attributes) => [
            'kanungo_opinion' => [
                'has_ownership_continuity' => $this->faker->randomElement(['yes', 'no']),
                'opinion_details' => $this->faker->paragraph()
            ]
        ]);
    }

    /**
     * Indicate that the compensation is for RS record basis.
     */
    public function rsRecord(): static
    {
        return $this->state(fn (array $attributes) => [
            'acquisition_record_basis' => 'RS',
            'rs_plot_no' => 'RS-' . $this->getBengaliNumber(100, 999),
            'land_schedule_rs_plot_no' => 'RS-PLOT-' . $this->getBengaliNumber(100, 999),
            'rs_khatian_no' => 'RS-KH-' . $this->getBengaliNumber(100, 999),
            'sa_plot_no' => null,
            'land_schedule_sa_plot_no' => null,
            'sa_khatian_no' => null,
            'ownership_details' => $this->generateOwnershipDetails('RS', 'RS-' . $this->getBengaliNumber(100, 999))
        ]);
    }

    /**
     * Indicate that the compensation is for SA record basis.
     */
    public function saRecord(): static
    {
        return $this->state(fn (array $attributes) => [
            'acquisition_record_basis' => 'SA',
            'sa_plot_no' => 'SA-' . $this->getBengaliNumber(100, 999),
            'land_schedule_sa_plot_no' => 'SA-PLOT-' . $this->getBengaliNumber(100, 999),
            'sa_khatian_no' => 'SA-KH-' . $this->getBengaliNumber(100, 999),
            'rs_plot_no' => null,
            'land_schedule_rs_plot_no' => null,
            'rs_khatian_no' => null,
            'ownership_details' => $this->generateOwnershipDetails('SA', 'SA-' . $this->getBengaliNumber(100, 999))
        ]);
    }
} 