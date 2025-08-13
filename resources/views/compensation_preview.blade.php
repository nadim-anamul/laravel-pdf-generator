@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ তথ্য প্রিভিউ')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">ক্ষতিপূরণ তথ্য প্রিভিউ</h1>
        <div class="space-x-3">
            <a href="{{ route('compensation.edit', $compensation->id) }}" class="btn-primary">
                সম্পাদনা করুন
            </a>
            <a href="{{ route('compensation.index') }}" class="btn-secondary">
                তালিকায় ফিরে যান
            </a>
        </div>
    </div>

    <!-- Case Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            মামলার তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <div>
                <label class="font-semibold text-gray-700">মামলা নম্বর:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('case_number') }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মামলার তারিখ:</label>
                <p class="text-gray-900">{{ $compensation->case_date_bengali }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">এলএ কেস নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('la_case_no') }}</p>
            </div>
            @if($compensation->award_type && is_array($compensation->award_type) && in_array('জমি', $compensation->award_type))
                @if($compensation->land_award_serial_no)
                <div>
                    <label class="font-semibold text-gray-700">জমির রোয়েদাদ নং:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliValue('land_award_serial_no') }}</p>
                </div>
                @endif
            @endif
            @if($compensation->award_type && is_array($compensation->award_type) && in_array('গাছপালা/ফসল', $compensation->award_type))
                @if($compensation->tree_award_serial_no)
                <div>
                    <label class="font-semibold text-gray-700">গাছপালা/ফসলের রোয়েদাদ নং:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliValue('tree_award_serial_no') }}</p>
                </div>
                @endif
            @endif
            @if($compensation->award_type && is_array($compensation->award_type) && in_array('অবকাঠামো', $compensation->award_type))
                @if($compensation->infrastructure_award_serial_no)
                <div>
                    <label class="font-semibold text-gray-700">অবকাঠামোর রোয়েদাদ নং:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliValue('infrastructure_award_serial_no') }}</p>
                </div>
                @endif
            @endif
            <div>
                <label class="font-semibold text-gray-700">যে রেকর্ড মূলে অধিগ্রহণ:</label>
                <p class="text-gray-900">{{ $compensation->acquisition_record_basis }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('plot_no') }}</p>
            </div>
        </div>
    </div>

    <!-- Applicant Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            আবেদনকারীর তথ্য
        </h2>
        @foreach($compensation->applicants as $index => $applicant)
        <div class="mb-3 p-3 border border-gray-200 rounded-md bg-gray-50">
            <h3 class="font-semibold text-base mb-2 text-gray-700">আবেদনকারী #{{ $index + 1 }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="font-semibold text-gray-700">নাম:</label>
                    <p class="text-gray-900">{{ $applicant['name'] }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">পিতার নাম:</label>
                    <p class="text-gray-900">{{ $applicant['father_name'] }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700">ঠিকানা:</label>
                    <p class="text-gray-900">{{ $applicant['address'] }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">এন আই ডি:</label>
                    <p class="text-gray-900">{{ $compensation->bnDigits($applicant['nid']) }}</p>
                </div>
                @if(isset($applicant['mobile']) && $applicant['mobile'])
                <div>
                    <label class="font-semibold text-gray-700">মোবাইল নং:</label>
                    <p class="text-gray-900">{{ $compensation->bnDigits($applicant['mobile']) }}</p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Award Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            রোয়েদাদের তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <div class="md:col-span-2 lg:col-span-3">
                <label class="font-semibold text-gray-700">রোয়েদাদভুক্ত মালিকের তথ্য:</label>
                <div class="text-gray-900">
                    @foreach($compensation->award_holder_names as $index => $holder)
                        <div class="mb-3 p-3 border border-gray-200 rounded-md bg-gray-50">
                            <h4 class="font-semibold text-base mb-2 text-gray-700">মালিক #{{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="font-semibold text-gray-700">নাম:</label>
                                    <p class="text-gray-900">{{ $holder['name'] }}</p>
                                </div>
                                @if(isset($holder['father_name']) && $holder['father_name'])
                                <div>
                                    <label class="font-semibold text-gray-700">পিতার নাম:</label>
                                    <p class="text-gray-900">{{ $holder['father_name'] }}</p>
                                </div>
                                @endif
                                @if(isset($holder['address']) && $holder['address'])
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">ঠিকানা:</label>
                                    <p class="text-gray-900">{{ $holder['address'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="font-semibold text-gray-700">আবেদনকারীর নাম রোয়েদাদে আছে কিনা:</label>
                <p class="text-gray-900">{{ $compensation->is_applicant_in_award ? 'হ্যাঁ' : 'না' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">অধিগ্রহণকৃত মোট জমির পরিমাণ:</label>
                <p class="text-gray-900">
                    @php
                        $totalLand = 0;
                        if($compensation->land_category && is_array($compensation->land_category)) {
                            foreach($compensation->land_category as $category) {
                                $totalLand += floatval($category['total_land'] ?? 0);
                            }
                        }
                        echo $compensation->bnDigits(number_format($totalLand, 6)) . ' একর';
                    @endphp
                </p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">অধিগ্রহণকৃত জমির মোট ক্ষতিপূরণ:</label>
                <p class="text-gray-900">
                    @php
                        $totalCompensation = 0;
                        if($compensation->land_category && is_array($compensation->land_category)) {
                            foreach($compensation->land_category as $category) {
                                $totalCompensation += floatval($category['total_compensation'] ?? 0);
                            }
                        }
                        echo $compensation->bnDigits(number_format($totalCompensation, 2)) . ' টাকা';
                    @endphp
                </p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">উৎস কর %:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('source_tax_percentage') }}</p>
            </div>
            @if($compensation->tree_compensation)
            <div>
                <label class="font-semibold text-gray-700">গাছপালার মোট ক্ষতিপূরণ:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('tree_compensation') }}</p>
            </div>
            @endif
            @if($compensation->infrastructure_compensation)
            <div>
                <label class="font-semibold text-gray-700">অবকাঠামোর মোট ক্ষতিপূরণ:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('infrastructure_compensation') }}</p>
            </div>
            @endif
            @if($compensation->applicant_acquired_land)
            <div>
                <label class="font-semibold text-gray-700">আবেদনকারীর অধিগ্রহণকৃত জমির পরিমাণ:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('applicant_acquired_land') }}</p>
            </div>
            @endif
            @if($compensation->land_category && count($compensation->land_category) > 0)
            <div class="md:col-span-2 lg:col-span-3">
                <label class="font-semibold text-gray-700">অধিগ্রহণকৃত জমির শ্রেণী:</label>
                <div class="mt-2 space-y-2">
                    @foreach($compensation->land_category as $index => $category)
                    <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <div>
                                <span class="font-medium text-gray-600">জমির শ্রেণী:</span>
                                <span class="text-gray-900">{{ $category['category_name'] ?? '' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">মোট জমির পরিমাণ:</span>
                                <span class="text-gray-900">{{ $compensation->bnDigits($category['total_land'] ?? '') }} একর</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">মোট ক্ষতিপূরণ:</span>
                                <span class="text-gray-900">{{ $compensation->bnDigits($category['total_compensation'] ?? '') }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">আবেদনকারীর অধিগ্রহণকৃত জমি:</span>
                                <span class="text-gray-900">{{ $category['applicant_land'] ? $compensation->bnDigits($category['applicant_land']) . ' একর' : 'তথ্য নেই' }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @if($compensation->award_type)
            <div>
                <label class="font-semibold text-gray-700">রোয়েদাদের ধরন:</label>
                <p class="text-gray-900">{{ is_array($compensation->award_type) ? implode(', ', $compensation->award_type) : $compensation->award_type }}</p>
            </div>
            @endif
            @if($compensation->acquisition_record_basis === 'SA')
            <div>
                <label class="font-semibold text-gray-700">SA দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('sa_plot_no') }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">SA খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('sa_khatian_no') }}</p>
            </div>
            @endif
            @if($compensation->acquisition_record_basis === 'RS')
            <div>
                <label class="font-semibold text-gray-700">RS দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('rs_plot_no') }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">RS খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('rs_khatian_no') }}</p>
            </div>
            @endif
            @if($compensation->objector_details)
            <div class="md:col-span-2 lg:col-span-3">
                <label class="font-semibold text-gray-700">রোয়েদাদে কোন আপত্তি অন্তর্ভুক্ত থাকলে আপত্তিকারীর নাম ও ঠিকানা:</label>
                <p class="text-gray-900">{{ $compensation->objector_details }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Land Schedule -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            আবেদনকৃত জমির তফসিল
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <div>
                <label class="font-semibold text-gray-700">জেলা:</label>
                <p class="text-gray-900">{{ $compensation->district ?? 'তথ্য নেই' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">উপজেলা:</label>
                <p class="text-gray-900">{{ $compensation->upazila ?? 'তথ্য নেই' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মৌজার নাম:</label>
                <p class="text-gray-900">{{ $compensation->mouza_name }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">জেএল নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('jl_no') }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">এসএ খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('sa_khatian_no') }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">SA দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('land_schedule_sa_plot_no') }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">আর এস খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('rs_khatian_no') }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">RS দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->getBengaliValue('land_schedule_rs_plot_no') }}</p>
            </div>
        </div>
    </div>

    <!-- Ownership Continuity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            মালিকানার ধারাবাহিকতার বর্ণনা
        </h2>
        
        @if($compensation->ownership_details)
        
        <!-- Story Sequence Display - Show First -->
        @if(isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
        <div class="mb-4">
            <h3 class="font-semibold text-base mb-2 text-green-600">মালিকানার ধারাবাহিকতার ক্রম</h3>
            <div class="space-y-2">
                @foreach($compensation->ownership_details['storySequence'] as $index => $item)
                <div class="bg-blue-50 p-3 rounded-md border-l-4 border-blue-500">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">{{ $item['type'] }}</div>
                            <div class="text-xs text-gray-600">{{ $item['description'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($compensation->acquisition_record_basis === 'SA' && isset($compensation->ownership_details['sa_info']))
        <div class="mb-4">
            <h3 class="font-semibold text-base mb-2 text-green-600">SA রেকর্ড তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="font-semibold text-gray-700">SA দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.sa_info.sa_plot_no') ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA খতিয়ান নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.sa_info.sa_khatian_no') ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA দাগে মোট জমি:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.sa_info.sa_total_land_in_plot') ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA উক্ত খতিয়ানে জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.sa_info.sa_land_in_khatian') ?? '' }}</p>
                </div>
            </div>
            
            @if(isset($compensation->ownership_details['sa_owners']))
            <div class="mt-4">
                <h4 class="font-semibold mb-2">SA মালিকগণ:</h4>
                @foreach($compensation->ownership_details['sa_owners'] as $owner)
                <p class="text-gray-900">• {{ $owner['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        @if($compensation->acquisition_record_basis === 'RS' && isset($compensation->ownership_details['rs_info']))
        <div class="mb-4">
            <h3 class="font-semibold text-base mb-2 text-green-600">RS রেকর্ড তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="font-semibold text-gray-700">RS দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.rs_info.rs_plot_no') ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS খতিয়ান নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.rs_info.rs_khatian_no') ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS দাগে মোট জমি:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.rs_info.rs_total_land_in_plot') ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS খতিয়ানে মোট জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('ownership_details.rs_info.rs_land_in_khatian') ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">ডিপি খতিয়ান:</label>
                    <p class="text-gray-900">{{ isset($compensation->ownership_details['rs_info']['dp_khatian']) && $compensation->ownership_details['rs_info']['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</p>
                </div>
            </div>
            
            @if(isset($compensation->ownership_details['rs_owners']))
            <div class="mt-4">
                <h4 class="font-semibold mb-2">RS মালিকগণ:</h4>
                @foreach($compensation->ownership_details['rs_owners'] as $owner)
                <p class="text-gray-900">• {{ $owner['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        <!-- Detailed Transfer Information - Ordered by Story Sequence -->
        @if(isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
            @php
                // Create arrays to store the detailed information
                $deedTransfers = $compensation->ownership_details['deed_transfers'] ?? [];
                $inheritanceRecords = $compensation->ownership_details['inheritance_records'] ?? [];
                $rsRecords = $compensation->ownership_details['rs_records'] ?? [];
                
                // Track which items have been displayed
                $displayedDeeds = [];
                $displayedInheritances = [];
                $displayedRsRecords = [];
            @endphp
            
            @foreach($compensation->ownership_details['storySequence'] as $index => $item)
                @if($item['itemType'] === 'deed')
                    @php 
                        $deedIndex = $item['itemIndex'];
                        $deed = $deedTransfers[$deedIndex] ?? null;
                        
                        if ($deed) {
                            $displayedDeeds[] = $deedIndex;
                        }
                    @endphp
                    
                    @if($deed)
                        <div class="mb-4">
                            <h3 class="font-semibold text-base mb-2 text-green-600">দলিল মূলে হস্তান্তর তথ্য</h3>
                            <div class="mb-3 p-3 border border-gray-200 rounded-md bg-gray-50">
                                <h4 class="font-semibold mb-2 text-sm">দলিল #{{ $deedIndex + 1 }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="font-semibold text-gray-700">দাতার নাম:</label>
                                        @if(isset($deed['donor_names']) && is_array($deed['donor_names']))
                                            @foreach($deed['donor_names'] as $donor)
                                                <p class="text-gray-900">• {{ $donor['name'] ?? '' }}</p>
                                            @endforeach
                                        @else
                                            <p class="text-gray-500 italic">তথ্য নেই</p>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="font-semibold text-gray-700">গ্রহীতার নাম:</label>
                                        @if(isset($deed['recipient_names']) && is_array($deed['recipient_names']))
                                            @foreach($deed['recipient_names'] as $recipient)
                                                <p class="text-gray-900">• {{ $recipient['name'] ?? '' }}</p>
                                            @endforeach
                                        @else
                                            <p class="text-gray-500 italic">তথ্য নেই</p>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="font-semibold text-gray-700">দলিল নম্বর:</label>
                                        <p class="text-gray-900">{{ $compensation->bnDigits($deed['deed_number'] ?? 'তথ্য নেই') }}</p>
                                    </div>
                                    <div>
                                        <label class="font-semibold text-gray-700">দলিলের তারিখ:</label>
                                        <p class="text-gray-900">{{ $deed['deed_date'] ?? 'তথ্য নেই' }}</p>
                                    </div>
                                    <div>
                                        <label class="font-semibold text-gray-700">দলিলের ধরন:</label>
                                        <p class="text-gray-900">{{ $deed['sale_type'] ?? 'তথ্য নেই' }}</p>
                                    </div>

                                    <!-- Application Area Fields -->
                                    @if(isset($deed['application_type']) && $deed['application_type'])
                                    <div>
                                        <label class="font-semibold text-gray-700">আবেদনকৃত দাগের সুনির্দিষ্টভাবে বিক্রয়:</label>
                                        <p class="text-gray-900">{{ $compensation->formatApplicationAreaString($deed) }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <label class="font-semibold text-gray-700">দখল উল্লেখ করা আছে কিনা:</label>
                                        <p class="text-gray-900">{{ isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                    </div>
                                    @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
                                                                    <div>
                                    <label class="font-semibold text-gray-700">দখলের দাগ নম্বর:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($deed['possession_plot_no'] ?? '') }}</p>
                                </div>
                                    <div class="md:col-span-2">
                                        <label class="font-semibold text-gray-700">দখল এর বর্ণনা:</label>
                                        <p class="text-gray-900">{{ $deed['possession_description'] ?? '' }}</p>
                                    </div>
                                    @endif
                                    
                                    <!-- New Possession Fields -->
                                    <div>
                                        <label class="font-semibold text-gray-700">দলিলের বিবরণ ও হস্তান্তরের সময় দখল উল্লেখ রয়েছে কিনা:</label>
                                        <p class="text-gray-900">{{ isset($deed['possession_deed']) && $deed['possession_deed'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                    </div>
                                    <div>
                                        <label class="font-semibold text-gray-700">আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা:</label>
                                        <p class="text-gray-900">{{ isset($deed['possession_application']) && $deed['possession_application'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                    </div>
                                                                    @if(isset($deed['mentioned_areas']) && $deed['mentioned_areas'])
                                <div>
                                    <label class="font-semibold text-gray-700">যে সকল দাগে দখল উল্লেখ করা:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($deed['mentioned_areas']) }}</p>
                                </div>
                                @endif
                                    @if(isset($deed['special_details']) && $deed['special_details'])
                                    <div class="md:col-span-2">
                                        <label class="font-semibold text-gray-700">প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                                        <p class="text-gray-900">{{ $deed['special_details'] }}</p>
                                    </div>
                                    @endif
                                    @if(isset($deed['tax_info']) && $deed['tax_info'])
                                    <div class="md:col-span-2">
                                        <label class="font-semibold text-gray-700">খারিজের তথ্য:</label>
                                        <p class="text-gray-900">{{ $deed['tax_info'] }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @elseif($item['itemType'] === 'inheritance' && isset($inheritanceRecords[$item['itemIndex']]))
                    @php $inheritance = $inheritanceRecords[$item['itemIndex']]; $displayedInheritances[] = $item['itemIndex']; @endphp
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-green-600">ওয়ারিশ মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="font-semibold mb-2">ওয়ারিশ #{{ $item['itemIndex'] + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="font-semibold text-gray-700">পূর্ববর্তী মালিকের নাম:</label>
                                    <p class="text-gray-900">{{ $inheritance['previous_owner_name'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">মৃত্যুর তারিখ:</label>
                                    <p class="text-gray-900">{{ $inheritance['death_date'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">মৃত্যু সনদ আছে কিনা:</label>
                                    <p class="text-gray-900">{{ isset($inheritance['has_death_cert']) && $inheritance['has_death_cert'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">ওয়ারিশ সনদের তথ্য:</label>
                                    <p class="text-gray-900">{{ $inheritance['heirship_certificate_info'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($item['itemType'] === 'rs' && isset($rsRecords[$item['itemIndex']]))
                    @php $rs = $rsRecords[$item['itemIndex']]; $displayedRsRecords[] = $item['itemIndex']; @endphp
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-green-600">আরএস রেকর্ড তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="font-semibold mb-2">আরএস রেকর্ড #{{ $item['itemIndex'] + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস দাগ নম্বর:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($rs['plot_no'] ?? '') }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস খতিয়ান নম্বর:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($rs['khatian_no'] ?? '') }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস জমির পরিমাণ:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($rs['land_amount'] ?? '') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">আরএস মালিকের নাম:</label>
                                    @if(isset($rs['owner_names']))
                                        @foreach($rs['owner_names'] as $owner)
                                            <p class="text-gray-900">• {{ $owner['name'] ?? '' }}</p>
                                        @endforeach
                                    @elseif(isset($rs['owner_name']))
                                        <p class="text-gray-900">• {{ $rs['owner_name'] }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">ডিপি খতিয়ান:</label>
                                    <p class="text-gray-900">{{ isset($rs['dp_khatian']) && $rs['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($item['itemType'] === 'deed')
                    <!-- Debug: Show why deed is not being displayed -->
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <h4 class="font-semibold text-red-800 mb-2">Debug: Deed not displayed</h4>
                        <div class="text-sm text-red-700">
                            <p>Item Type: {{ $item['itemType'] }}</p>
                            <p>Item Index: {{ $item['itemIndex'] }} (Type: {{ gettype($item['itemIndex']) }})</p>
                            <p>Deed Transfers Count: {{ count($deedTransfers) }}</p>
                            <p>Deed Transfers Keys: {{ implode(', ', array_keys($deedTransfers)) }}</p>
                            <p>Deed Transfers Keys Types: 
                                @foreach(array_keys($deedTransfers) as $key)
                                    {{ $key }}({{ gettype($key) }}){{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                            <p>isset($deedTransfers[{{ $item['itemIndex'] }}]): {{ isset($deedTransfers[$item['itemIndex']]) ? 'true' : 'false' }}</p>
                            <p>array_key_exists({{ $item['itemIndex'] }}, $deedTransfers): {{ array_key_exists($item['itemIndex'], $deedTransfers) ? 'true' : 'false' }}</p>
                            <p>Direct access test: {{ isset($deedTransfers[0]) ? 'Index 0 exists' : 'Index 0 missing' }}, {{ isset($deedTransfers[1]) ? 'Index 1 exists' : 'Index 1 missing' }}, {{ isset($deedTransfers[2]) ? 'Index 2 exists' : 'Index 2 missing' }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
            
            <!-- Show any remaining items that weren't in the story sequence -->
            @foreach($deedTransfers as $index => $deed)
                @if(!in_array($index, $displayedDeeds))
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-green-600">দলিল মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="font-semibold mb-2">দলিল #{{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="font-semibold text-gray-700">দাতার নাম:</label>
                                    @if(isset($deed['donor_names']))
                                        @foreach($deed['donor_names'] as $donor)
                                            <p class="text-gray-900">• {{ $donor['name'] ?? '' }}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">গ্রহীতার নাম:</label>
                                    @if(isset($deed['recipient_names']))
                                        @foreach($deed['recipient_names'] as $recipient)
                                            <p class="text-gray-900">• {{ $recipient['name'] ?? '' }}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">দলিল নম্বর:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($deed['deed_number'] ?? '') }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">দলিলের তারিখ:</label>
                                    <p class="text-gray-900">{{ $deed['deed_date'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">দলিলের ধরন:</label>
                                    <p class="text-gray-900">{{ $deed['sale_type'] ?? '' }}</p>
                                </div>

                                <!-- Application Area Fields -->
                                @if(isset($deed['application_type']) && $deed['application_type'])
                                <div>
                                    <label class="font-semibold text-gray-700">আবেদনকৃত দাগের সুনির্দিষ্টভাবে বিক্রয়:</label>
                                    <p class="text-gray-900">{{ $compensation->formatApplicationAreaString($deed) }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="font-semibold text-gray-700">দখল উল্লেখ করা আছে কিনা:</label>
                                    <p class="text-gray-900">{{ isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
                                <div>
                                    <label class="font-semibold text-gray-700">দখলের দাগ নম্বর:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($deed['possession_plot_no'] ?? '') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">দখল এর বর্ণনা:</label>
                                    <p class="text-gray-900">{{ $deed['possession_description'] ?? '' }}</p>
                                </div>
                                @endif
                                
                                <!-- New Possession Fields -->
                                <div>
                                    <label class="font-semibold text-gray-700">দলিলের বিবরণ ও হস্তান্তরের সময় দখল উল্লেখ রয়েছে কিনা:</label>
                                    <p class="text-gray-900">{{ isset($deed['possession_deed']) && $deed['possession_deed'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা:</label>
                                    <p class="text-gray-900">{{ isset($deed['possession_application']) && $deed['possession_application'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                @if(isset($deed['mentioned_areas']) && $deed['mentioned_areas'])
                                <div>
                                    <label class="font-semibold text-gray-700">যে সকল দাগে দখল উল্লেখ করা:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($deed['mentioned_areas']) }}</p>
                                </div>
                                @endif
                                @if(isset($deed['special_details']) && $deed['special_details'])
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                                    <p class="text-gray-900">{{ $deed['special_details'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach($inheritanceRecords as $index => $inheritance)
                @if(!in_array($index, $displayedInheritances))
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-green-600">ওয়ারিশ মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="font-semibold mb-2">ওয়ারিশ #{{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="font-semibold text-gray-700">পূর্ববর্তী মালিকের নাম:</label>
                                    <p class="text-gray-900">{{ $inheritance['previous_owner_name'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">মৃত্যুর তারিখ:</label>
                                    <p class="text-gray-900">{{ $inheritance['death_date'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">মৃত্যু সনদ আছে কিনা:</label>
                                    <p class="text-gray-900">{{ isset($inheritance['has_death_cert']) && $inheritance['has_death_cert'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">ওয়ারিশ সনদের তথ্য:</label>
                                    <p class="text-gray-900">{{ $inheritance['heirship_certificate_info'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach($rsRecords as $index => $rs)
                @if(!in_array($index, $displayedRsRecords))
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-green-600">আরএস রেকর্ড তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="font-semibold mb-2">আরএস রেকর্ড #{{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস দাগ নম্বর:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($rs['plot_no'] ?? '') }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস খতিয়ান নম্বর:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($rs['khatian_no'] ?? '') }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস জমির পরিমাণ:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($rs['land_amount'] ?? '') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">আরএস মালিকের নাম:</label>
                                    @if(isset($rs['owner_names']))
                                        @foreach($rs['owner_names'] as $owner)
                                            <p class="text-gray-900">• {{ $owner['name'] ?? '' }}</p>
                                        @endforeach
                                    @elseif(isset($rs['owner_name']))
                                        <p class="text-gray-900">• {{ $rs['owner_name'] }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">ডিপি খতিয়ান:</label>
                                    <p class="text-gray-900">{{ isset($rs['dp_khatian']) && $rs['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <!-- Fallback: Show sections in original order if no story sequence -->
            @if(isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-3 text-green-600">দলিল মূলে হস্তান্তর তথ্য</h3>
                @foreach($compensation->ownership_details['deed_transfers'] as $index => $deed)
                <div class="mb-4 p-4 border rounded-lg">
                    <h4 class="font-semibold mb-2">দলিল #{{ $index + 1 }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">দাতার নাম:</label>
                            @if(isset($deed['donor_names']))
                                @foreach($deed['donor_names'] as $donor)
                                    <p class="text-gray-900">• {{ $donor['name'] ?? '' }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">গ্রহীতার নাম:</label>
                            @if(isset($deed['recipient_names']))
                                @foreach($deed['recipient_names'] as $recipient)
                                    <p class="text-gray-900">• {{ $recipient['name'] ?? '' }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">দলিল নম্বর:</label>
                            <p class="text-gray-900">{{ $compensation->bnDigits($deed['deed_number'] ?? '') }}</p>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">দলিলের তারিখ:</label>
                            <p class="text-gray-900">{{ $deed['deed_date'] ?? '' }}</p>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">দলিলের ধরন:</label>
                            <p class="text-gray-900">{{ $deed['sale_type'] ?? '' }}</p>
                        </div>

                        <!-- Application Area Fields -->
                        @if(isset($deed['application_type']) && $deed['application_type'])
                        <div>
                            <label class="font-semibold text-gray-700">আবেদনকৃত দাগের সুনির্দিষ্টভাবে বিক্রয়:</label>
                        <p class="text-gray-900">{{ $compensation->formatApplicationAreaString($deed) }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="font-semibold text-gray-700">দখল উল্লেখ করা আছে কিনা:</label>
                            <p class="text-gray-900">{{ isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                        @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
                        <div>
                            <label class="font-semibold text-gray-700">দখলের দাগ নম্বর:</label>
                            <p class="text-gray-900">{{ $compensation->bnDigits($deed['possession_plot_no'] ?? '') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="font-semibold text-gray-700">দখল এর বর্ণনা:</label>
                            <p class="text-gray-900">{{ $deed['possession_description'] ?? '' }}</p>
                        </div>
                        @endif
                        
                        <!-- New Possession Fields -->
                        <div>
                            <label class="font-semibold text-gray-700">দলিলের বিবরণ ও হস্তান্তরের সময় দখল উল্লেখ রয়েছে কিনা:</label>
                            <p class="text-gray-900">{{ isset($deed['possession_deed']) && $deed['possession_deed'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা:</label>
                            <p class="text-gray-900">{{ isset($deed['possession_application']) && $deed['possession_application'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                        @if(isset($deed['mentioned_areas']) && $deed['mentioned_areas'])
                        <div>
                            <label class="font-semibold text-gray-700">যে সকল দাগে দখল উল্লেখ করা:</label>
                            <p class="text-gray-900">{{ $compensation->bnDigits($deed['mentioned_areas']) }}</p>
                        </div>
                        @endif
                        @if(isset($deed['special_details']) && $deed['special_details'])
                        <div class="md:col-span-2">
                            <label class="font-semibold text-gray-700">প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                            <p class="text-gray-900">{{ $deed['special_details'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(isset($compensation->ownership_details['inheritance_records']) && count($compensation->ownership_details['inheritance_records']) > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-3 text-green-600">ওয়ারিশ মূলে হস্তান্তর তথ্য</h3>
                @foreach($compensation->ownership_details['inheritance_records'] as $index => $inheritance)
                <div class="mb-4 p-4 border rounded-lg">
                    <h4 class="font-semibold mb-2">ওয়ারিশ #{{ $index + 1 }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">পূর্ববর্তী মালিকের নাম:</label>
                            <p class="text-gray-900">{{ $inheritance['previous_owner_name'] ?? '' }}</p>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">মৃত্যুর তারিখ:</label>
                            <p class="text-gray-900">{{ $inheritance['death_date'] ?? '' }}</p>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">মৃত্যু সনদ আছে কিনা:</label>
                            <p class="text-gray-900">{{ isset($inheritance['has_death_cert']) && $inheritance['has_death_cert'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="font-semibold text-gray-700">ওয়ারিশ সনদের তথ্য:</label>
                            <p class="text-gray-900">{{ $inheritance['heirship_certificate_info'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(isset($compensation->ownership_details['rs_records']) && count($compensation->ownership_details['rs_records']) > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-3 text-green-600">আরএস রেকর্ড তথ্য</h3>
                @foreach($compensation->ownership_details['rs_records'] as $index => $rs)
                <div class="mb-4 p-4 border rounded-lg">
                    <h4 class="font-semibold mb-2">আরএস রেকর্ড #{{ $index + 1 }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">আরএস দাগ নম্বর:</label>
                            <p class="text-gray-900">{{ $compensation->bnDigits($rs['plot_no'] ?? '') }}</p>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">আরএস খতিয়ান নম্বর:</label>
                            <p class="text-gray-900">{{ $compensation->bnDigits($rs['khatian_no'] ?? '') }}</p>
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">আরএস জমির পরিমাণ:</label>
                            <p class="text-gray-900">{{ $compensation->bnDigits($rs['land_amount'] ?? '') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="font-semibold text-gray-700">আরএস মালিকের নাম:</label>
                            @if(isset($rs['owner_names']))
                                @foreach($rs['owner_names'] as $owner)
                                    <p class="text-gray-900">• {{ $owner['name'] ?? '' }}</p>
                                @endforeach
                            @elseif(isset($rs['owner_name']))
                                <p class="text-gray-900">• {{ $rs['owner_name'] }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">ডিপি খতিয়ান:</label>
                            <p class="text-gray-900">{{ isset($rs['dp_khatian']) && $rs['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        @endif

        @if(isset($compensation->ownership_details['applicant_info']))
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">আবেদনকারীর অনুকূলে নামজারির তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">আবেদনকারীর নাম:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['applicant_name'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ কেস নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->bnDigits($compensation->ownership_details['applicant_info']['kharij_case_no'] ?? '') }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->bnDigits($compensation->ownership_details['applicant_info']['kharij_plot_no'] ?? '') }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->bnDigits($compensation->ownership_details['applicant_info']['kharij_land_amount'] ?? '') }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজের তারিখ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_date'] ?? '' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700">খারিজের বিবরণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_details'] ?? '' }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    @else
    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <p class="text-yellow-800">
            <strong>Debug:</strong> ownership_details is null or empty. 
            <br>Value: {{ var_export($compensation->ownership_details, true) }}
        </p>
    </div>
    @endif



    <!-- Tax Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            খাজনার তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-gray-700">হোল্ডিং নম্বর:</label>
                @if(!empty($compensation->tax_info['holding_no'] ?? ''))
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('tax_info.holding_no') }}</p>
                @else
                    <p class="text-red-500 italic">তথ্য নেই</p>
                @endif
            </div>
            <div>
                <label class="font-semibold text-gray-700">আবেদনকৃত দাগে খাজনা প্রদানকৃত জমির পরিমান (একরে)</label>
                @if(!empty($compensation->tax_info['paid_land_amount'] ?? ''))
                    <p class="text-gray-900">{{ $compensation->getBengaliNestedValue('tax_info.paid_land_amount') }}</p>
                @else
                    <p class="text-red-500 italic">তথ্য নেই</p>
                @endif
            </div>
            <div>
                <label class="font-semibold text-gray-700">ইংরেজি বছর:</label>
                @if(!empty($compensation->tax_info['english_year'] ?? ''))
                                                <p class="text-gray-900">{{ $compensation->bnDigits($compensation->tax_info['english_year']) }}</p>
                @else
                    <p class="text-red-500 italic">তথ্য নেই</p>
                @endif
            </div>
            <div>
                <label class="font-semibold text-gray-700">বাংলা বছর:</label>
                @if(!empty($compensation->tax_info['bangla_year'] ?? ''))
                                                <p class="text-gray-900">{{ $compensation->bnDigits($compensation->tax_info['bangla_year']) }}</p>
                @else
                    <p class="text-red-500 italic">তথ্য নেই</p>
                @endif
            </div>
            
        </div>
    </div>

    <!-- Additional Documents -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            বণ্টন / না-দাবি / আপসনামা / এফিডেভিটের তথ্য
        </h2>
        @if(isset($compensation->additional_documents_info['selected_types']) && !empty($compensation->additional_documents_info['selected_types']))
        <div class="mb-3">
            <label class="font-semibold text-gray-700">দাখিলকৃত ডকুমেন্টের ধরন:</label>
            <div class="mt-2">
                @foreach($compensation->additional_documents_info['selected_types'] as $type)
                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-md text-xs mr-2 mb-1">{{ $type }}</span>
                @endforeach
            </div>
        </div>
        @else
        <div class="mb-3">
            <label class="font-semibold text-gray-700">দাখিলকৃত ডকুমেন্টের ধরন:</label>
            <p class="text-red-500 italic text-sm">তথ্য নেই</p>
        </div>
        @endif
        
        @if(isset($compensation->additional_documents_info['details']) && !empty($compensation->additional_documents_info['details']))
        <div>
            <label class="font-semibold text-gray-700">ডকুমেন্টের বিবরণ:</label>
            @foreach($compensation->additional_documents_info['details'] as $type => $details)
            <div class="mt-3 p-3 border rounded-lg">
                <h4 class="font-semibold text-gray-700 mb-2">{{ $type }}:</h4>
                <p class="text-gray-900">{{ $details }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div>
            <label class="font-semibold text-gray-700">ডকুমেন্টের বিবরণ:</label>
            <p class="text-red-500 italic">তথ্য নেই</p>
        </div>
        @endif
    </div>

    <!-- Kanungo Opinion -->
    @if($compensation->kanungo_opinion)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            কানুনগো/সার্ভেয়ারের মতামত
        </h2>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="font-semibold text-gray-700">মালিকানার ধারাবাহিকতা আছে কিনা:</label>
                                        <p class="text-gray-900">{{ isset($compensation->kanungo_opinion['has_ownership_continuity']) && $compensation->kanungo_opinion['has_ownership_continuity'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মতামতের বিবরণ:</label>
                <p class="text-gray-900">{{ $compensation->kanungo_opinion['opinion_details'] ?? '' }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Application Analysis -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            আবেদনপত্র বিশ্লেষণ
        </h2>
        <div class="space-y-3">
            <!-- Application Type -->
            <div class="p-3 bg-gray-50 rounded-md border border-gray-200">
                <p class="text-gray-800 text-sm">
                    আবেদনকারী 
                    @if($compensation->award_type )
                    {{ is_array($compensation->award_type) ? implode(', ', $compensation->award_type) : $compensation->award_type }}
                    @else
                        ক্ষতিপূরণের জন্য আবেদন করেছেন।
                    @endif
                    ক্ষতিপূরণের জন্য আবেদন করেছেন।
                </p>
            </div>

            <!-- Applicant Count -->
            <div class="p-3 bg-gray-50 rounded-md border border-gray-200">
                <p class="text-gray-800 text-sm">
                    আবেদনকারী 
                    @if($compensation->applicants && is_array($compensation->applicants))
                        {{ count($compensation->applicants) }} জন।
                    @else
                        ১ জন।
                    @endif
                </p>
            </div>

            <!-- Award Holder Count -->
            <div class="p-3 bg-gray-50 rounded-md border border-gray-200">
                <p class="text-gray-800 text-sm">
                    রোয়েদাদভুক্ত মালিক 
                    @if($compensation->award_holder_names && is_array($compensation->award_holder_names))
                        {{ count($compensation->award_holder_names) }} জন।
                    @else
                        ১ জন।
                    @endif
                </p>
            </div>

            <!-- Applicant in Award Status -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    আবেদনকারীর নাম রোয়েদাদে 
                    @if($compensation->is_applicant_in_award)
                        আছে।
                    @else
                        নাই।
                    @endif
                </p>
            </div>

            <!-- Settlement Distribution Logic -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) == 1 && $compensation->is_applicant_in_award)
                        রোয়েদাদভুক্ত মালিক ১ জন বিধায় আপসবন্টন/ না-দাবীনামা প্রয়োজন নেই।
                    @elseif($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 1)
                    রোয়েদাদভুক্ত মালিক একাধিক বিধায়- আপসবন্টন/ না-দাবী/ সরেজমিন দখল প্রতিবেদন প্রয়োজন।
                    @else
                        রোয়েদাদভুক্ত মালিকের সংখ্যা নির্ধারণ করা যায়নি।
                    @endif
                </p>
            </div>

            <!-- Settlement/No Claim Documents -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    @php
                        $hasSettlementOrNoClaim = $compensation->additional_documents_info && 
                                                isset($compensation->additional_documents_info['selected_types']) && 
                                                is_array($compensation->additional_documents_info['selected_types']) &&
                                                (in_array('আপস- বন্টননামা', $compensation->additional_documents_info['selected_types']) || 
                                                 in_array('না-দাবি', $compensation->additional_documents_info['selected_types']));
                    @endphp
                    
                    @if($hasSettlementOrNoClaim)
                        আপসবন্টন নামা/ না- দাবীনামা দাখিল করা হয়েছে
                    @else
                        আপসবন্টন নামা/ না- দাবীনামা দাখিল করা হয়নাই
                    @endif
                </p>
            </div>

            <!-- Mutation Status -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    আবেদনকারীর নামে উল্লিখিত দাগে খারিজ করা 
                    @if($compensation->mutation_info && isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'])
                        আছে।
                    @else
                        নাই।
                    @endif
                </p>
            </div>

            <!-- Tax Receipt Status -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    @php
                        $hasTaxInfo = $compensation->tax_info && 
                                     isset($compensation->tax_info['english_year']) && 
                                     !empty($compensation->tax_info['english_year']) &&
                                     isset($compensation->tax_info['bangla_year']) && 
                                     !empty($compensation->tax_info['bangla_year']) &&
                                     isset($compensation->tax_info['paid_land_amount']) && 
                                     !empty($compensation->tax_info['paid_land_amount']);
                    @endphp
                    
                    @if($hasTaxInfo)
                        ইংরেজি {{ $compensation->bnDigits($compensation->tax_info['english_year']) }} এবং বাংলা {{ $compensation->bnDigits($compensation->tax_info['bangla_year']) }} সন পর্যন্ত {{ $compensation->bnDigits($compensation->tax_info['paid_land_amount']) }} একর জমির খাজনা পরিশোধ করা হয়েছে।
                    @else
                        উল্লিখিত দাগে খাজনার রশিদ দাখিল করা হয়নাই
                    @endif
                </p>
            </div>

            <!-- Deed Information -->
            @if($compensation->ownership_details && isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0)
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    @foreach($compensation->ownership_details['deed_transfers'] as $deed)
                        @if(isset($deed['deed_number']) && !empty($deed['deed_number']))
                            আবেদনকারীর দাখিলকৃত দলিল নং {{ $compensation->bnDigits($deed['deed_number']) }} তে উল্লিখিত দাগে দখল উল্লেখ করা 
                            @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'])
                                রয়েছে
                            @else
                                নাই
                            @endif
                            ।<br>
                        @endif
                    @endforeach
                </p>
            </div>
            @endif

            <!-- Land Compensation Claim -->
            @if($compensation->land_category && is_array($compensation->land_category))
            @php
                $total_land = number_format($compensation->total_land_amount, 6);
                $applicant_acquired_land = number_format($compensation->applicant_acquired_land, 6);
            @endphp
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    আবেদনকারী উল্লিখিত দাগে অধিগ্রহণকৃত {{ $compensation->bnDigits($total_land) }} একর জমির মধ্যে {{ $compensation->bnDigits($applicant_acquired_land) }} একরের ক্ষতিপূরণ দাবী করেন।
                </p>
            </div>
            @endif

            <!-- Acquisition Record Basis -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    {{ $compensation->acquisition_record_basis ?? 'এসএ/ আরএস' }} রেকর্ডমূলে অধিগ্রহণ।
                </p>
            </div>
            @if($compensation->acquisition_record_basis === 'SA' && (!$compensation->ownership_details || !isset($compensation->ownership_details['rs_record_info'])))
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                        এস এ রেকর্ডমূলে অধিগ্রহণ, কিন্তু আরএস রেকর্ডের তথ্য দাখিল করা হয়নি।
                </p>
            </div>
            @endif
            <!-- Objection Status -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-800">
                    রোয়েদাদে আপত্তি দাখিল 
                    @if($compensation->objector_details)
                        আছে।
                    @else
                        নাই।
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Final Order Information -->
    @if($compensation->final_order)
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold text-blue-600 border-b border-blue-200 pb-2">
                চূড়ান্ত আদেশ
            </h2>
            <a href="{{ route('compensation.final-order.preview', $compensation->id) }}" target="_blank" class="bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold text-base py-2 px-4 rounded">
                চূড়ান্ত আদেশ প্রিভিউ দেখুন
            </a>
        </div>
        
        @if(isset($compensation->final_order['land']) && $compensation->final_order['land']['selected'])
        <div class="mb-4">
            <h3 class="font-semibold text-base mb-2 text-green-600">জমি</h3>
            <div class="space-y-2">
                @if(isset($compensation->final_order['land']['categories']) && is_array($compensation->final_order['land']['categories']))
                    @foreach($compensation->final_order['land']['categories'] as $index => $category)
                    <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="font-semibold text-gray-700">জমির শ্রেণী:</label>
                                <p class="text-gray-900">{{ $category['category_name'] ?? '' }}</p>
                            </div>
                            <div>
                                <label class="font-semibold text-gray-700">অধিগ্রহণকৃত জমি (একর):</label>
                                <p class="text-gray-900">{{ $compensation->bnDigits($category['acquired_land'] ?? '') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @elseif(isset($compensation->final_order['land']['records']) && is_array($compensation->final_order['land']['records']))
                    <!-- Fallback for old format -->
                    @foreach($compensation->final_order['land']['records'] as $index => $record)
                    <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="font-semibold text-gray-700">দাগ নম্বর:</label>
                                <p class="text-gray-900">{{ $compensation->bnDigits($record['plot_no'] ?? '') }}</p>
                            </div>
                            <div>
                                <label class="font-semibold text-gray-700">জমির পরিমাণ:</label>
                                <p class="text-gray-900">{{ $compensation->bnDigits($record['area'] ?? '') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

        @if(isset($compensation->final_order['trees_crops']) && $compensation->final_order['trees_crops']['selected'])
        <div class="mb-4">
            <h3 class="font-semibold text-base mb-2 text-green-600">গাছপালা/ফসল</h3>
            <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="font-semibold text-gray-700">ক্ষতিপূরণের ধরন:</label>
                        <p class="text-gray-900">{{ $compensation->final_order['trees_crops']['compensation_type'] === 'full' ? 'সম্পূর্ণ' : 'আংশিক' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">ক্ষতিপূরণের পরিমাণ:</label>
                        <p class="text-gray-900">{{ $compensation->bnDigits($compensation->final_order['trees_crops']['amount'] ?? '') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($compensation->final_order['infrastructure']) && $compensation->final_order['infrastructure']['selected'])
        <div class="mb-4">
            <h3 class="font-semibold text-base mb-2 text-green-600">অবকাঠামো</h3>
            <div class="bg-gray-50 p-3 rounded-md border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="font-semibold text-gray-700">ক্ষতিপূরণের ধরন:</label>
                        <p class="text-gray-900">{{ $compensation->final_order['infrastructure']['compensation_type'] === 'full' ? 'সম্পূর্ণ' : 'আংশিক' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">ক্ষতিপূরণের পরিমাণ:</label>
                        <p class="text-gray-900">{{ $compensation->bnDigits($compensation->final_order['infrastructure']['amount'] ?? '') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Order Information - Case Completion Status -->
    @if($compensation->order_signature_date)
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-green-600 border-b border-green-200 pb-2">
            আদেশ তথ্য - কেস নিষ্পত্তিকৃত
        </h2>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-green-800">এই ক্ষতিপূরণ কেসটি নিষ্পত্তিকৃত হয়েছে</h3>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-gray-700">আদেশ স্বাক্ষরের তারিখ:</label>
                <p class="text-gray-900">{{ $compensation->order_signature_date }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">স্বাক্ষরকারী কর্মকর্তার নাম:</label>
                <p class="text-gray-900">{{ $compensation->signing_officer_name ?? 'তথ্য নেই' }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            পরবর্তী কার্যক্রম
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <a href="{{ route('compensation.present.preview', $compensation->id) }}" target="_blank" class="action-card bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-white font-bold text-base">ক্ষতিপূরণ কেসে উপস্থাপন</span>
                </div>
            </a>
            
            <a href="{{ route('compensation.notice.preview', $compensation->id) }}" class="action-card bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-white font-bold text-base">সকল পক্ষকে নোটিশ করুন</span>
                </div>
            </a>
            
            <a target="_blank" href="{{ route('compensation.preview.pdf', $compensation->id) }}" class="action-card bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-white font-bold text-base">আবেদনপত্র প্রিভিউ PDF</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Required Actions Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-4">
        <h2 class="text-lg font-semibold mb-3 text-blue-600 border-b border-blue-200 pb-2">
            প্রয়োজনীয় কার্যক্রম
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <button type="button" onclick="openKanungoOpinionModal({{ $compensation->id }})" class="action-card bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8" />
                    </svg>
                    <span class="text-white font-bold text-base">কানুনগো/সার্ভেয়ারের মতামত</span>
                </div>
            </button>
            <button type="button" onclick="openFinalOrderModal({{ $compensation->id }})" class="action-card bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-white font-bold text-base">চূড়ান্ত আদেশ</span>
                </div>
            </button>

            <button type="button" onclick="openOrderModal({{ $compensation->id }})" class="action-card bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-white font-bold text-base">কেস নিষ্পত্তি করুন</span>
                </div>
            </button>

            

        </div>
    </div>

</div>

<!-- Kanungo Opinion Modal -->
<div id="kanungoOpinionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">কানুনগো/সার্ভেয়ারের মতামত</h3>
                <button onclick="closeKanungoOpinionModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="kanungoOpinionForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">মালিকানার ধারাবাহিকতা আছে কিনা<span class="text-red-500">*</span></label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="kanungo_opinion[has_ownership_continuity]" value="yes" class="mr-2">
                                <span>হ্যাঁ</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="kanungo_opinion[has_ownership_continuity]" value="no" class="mr-2">
                                <span>না</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">মতামতঃ</label>
                        <textarea name="kanungo_opinion[opinion_details]" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="আপনার মতামত লিখুন..."></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeKanungoOpinionModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        বাতিল
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        জমা দিন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">আদেশ</h3>
                <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="orderForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">আদেশ স্বাক্ষরের তারিখ<span class="text-red-500">*</span></label>
                        <input type="text" name="order_signature_date" value="{{ $compensation->order_signature_date ?? '' }}" placeholder="দিন/মাস/বছর" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">স্বাক্ষরকারী কর্মকর্তার নাম<span class="text-red-500">*</span></label>
                        <input type="text" name="signing_officer_name" value="{{ $compensation->signing_officer_name ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="কর্মকর্তার নাম লিখুন..." required>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeOrderModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        বাতিল
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        আদেশ নিষ্পত্তিকৃত করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Final Order Modal -->
<div id="finalOrderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">চূড়ান্ত আদেশ</h3>
                <button onclick="closeFinalOrderModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="finalOrderForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <div class="space-y-6">
                    <!-- Land Section -->
                    @if($compensation->award_type && is_array($compensation->award_type) && in_array('জমি', $compensation->award_type))
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="flex items-center mb-3">
                            <input type="checkbox" name="final_order[land][selected]" value="1" class="mr-2" onchange="toggleLandFields()">
                            <span class="font-semibold text-gray-700">জমি</span>
                        </label>
                        <div id="landFields" class="hidden space-y-3">
                            <div id="landRecords" class="space-y-3">
                                @if($compensation->land_category && is_array($compensation->land_category))
                                    @foreach($compensation->land_category as $index => $category)
                                    <div class="land-record bg-gray-50 p-3 rounded border">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $category['category_name'] ?? 'জমির শ্রেণী' }}</label>
                                                <input type="text" name="final_order[land][categories][{{ $index }}][category_name]" value="{{ $category['category_name'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" readonly>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">অধিগ্রহণকৃত জমি (একর)</label>
                                                <input type="text" name="final_order[land][categories][{{ $index }}][acquired_land]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="জমির পরিমাণ লিখুন">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <!-- Fallback if no land categories -->
                                    <div class="land-record bg-gray-50 p-3 rounded border">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">জমির শ্রেণী</label>
                                                <input type="text" name="final_order[land][categories][0][category_name]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="জমির শ্রেণী লিখুন">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">অধিগ্রহণকৃত জমি (একর)</label>
                                                <input type="text" name="final_order[land][categories][0][acquired_land]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="জমির পরিমাণ লিখুন">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Trees/Crops Section -->
                    @if($compensation->award_type && is_array($compensation->award_type) && in_array('গাছপালা/ফসল', $compensation->award_type))
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="flex items-center mb-3">
                            <input type="checkbox" name="final_order[trees_crops][selected]" value="1" class="mr-2" onchange="toggleTreesCropsFields()">
                            <span class="font-semibold text-gray-700">গাছপালা/ফসল</span>
                        </label>
                        <div id="treesCropsFields" class="hidden space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ক্ষতিপূরণের ধরন</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="final_order[trees_crops][compensation_type]" value="full" class="mr-2">
                                        <span>সম্পূর্ণ</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="final_order[trees_crops][compensation_type]" value="partial" class="mr-2">
                                        <span>আংশিক</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ক্ষতিপূরণের পরিমাণ</label>
                                <input type="text" name="final_order[trees_crops][amount]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ক্ষতিপূরণের পরিমাণ লিখুন">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Infrastructure Section -->
                    @if($compensation->award_type && is_array($compensation->award_type) && in_array('অবকাঠামো', $compensation->award_type))
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="flex items-center mb-3">
                            <input type="checkbox" name="final_order[infrastructure][selected]" value="1" class="mr-2" onchange="toggleInfrastructureFields()">
                            <span class="font-semibold text-gray-700">অবকাঠামো</span>
                        </label>
                        <div id="infrastructureFields" class="hidden space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ক্ষতিপূরণের ধরন</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="final_order[infrastructure][compensation_type]" value="full" class="mr-2">
                                        <span>সম্পূর্ণ</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="final_order[infrastructure][compensation_type]" value="partial" class="mr-2">
                                        <span>আংশিক</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ক্ষতিপূরণের পরিমাণ</label>
                                <input type="text" name="final_order[infrastructure][amount]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ক্ষতিপূরণের পরিমাণ লিখুন">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeFinalOrderModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        বাতিল
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        চূড়ান্ত আদেশ জমা দিন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.section-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-size: 11px;
    font-weight: bold;
    margin-right: 6px;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

.btn-primary {
    @apply bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-3 rounded-md text-sm transition-colors duration-200;
}

.btn-secondary {
    @apply bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-3 rounded-md text-sm transition-colors duration-200;
}

.btn-action {
    @apply text-white font-bold py-3 px-4 rounded-md transition-all duration-200 transform hover:scale-102 shadow-md hover:shadow-lg;
}

.action-card {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 16px;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.2s ease;
    transform: scale(1);
    border: 1px solid transparent;
}

.action-card:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    border-color: rgba(255, 255, 255, 0.2);
}

.action-icon {
    @apply w-12 h-12 mb-2 text-white;
}

/* Modern card styling */
.bg-white {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

/* Improved typography */
.font-semibold {
    font-weight: 600;
}

/* Compact spacing */
.mb-4 {
    margin-bottom: 1rem;
}

.mb-3 {
    margin-bottom: 0.75rem;
}

.gap-3 {
    gap: 0.75rem;
}

/* Enhanced borders */
.border-gray-100 {
    border-color: #f3f4f6;
}

.border-blue-200 {
    border-color: #bfdbfe;
}

/* Smooth transitions */
* {
    transition: all 0.2s ease;
}

/* Enhanced shadows */
.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

/* Improved spacing for labels and values */
label {
    font-size: 0.875rem;
    color: #374151;
    margin-bottom: 0.25rem;
    display: block;
}

p {
    margin: 0;
    line-height: 1.5;
}

/* Compact grid improvements */
.grid {
    align-items: start;
}

/* Modern card hover effects */
.bg-white:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Responsive improvements */
@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .grid {
        gap: 0.5rem;
    }
    
    .p-4 {
        padding: 0.75rem;
    }
}
</style>

<script>
  window.openKanungoOpinionModal = function(compensationId) {
    const modal = document.getElementById('kanungoOpinionModal');
    const form = document.getElementById('kanungoOpinionForm');
    form.action = `/compensation/${compensationId}/kanungo-opinion`;
    modal.classList.remove('hidden');
    // Prefill if exists
    fetch(`/compensation/${compensationId}/kanungo-opinion`)
      .then(r => r.ok ? r.json() : null)
      .then(data => {
        if (data && data.kanungo_opinion) {
          const opinion = data.kanungo_opinion;
          const radio = document.querySelector(`input[name="kanungo_opinion[has_ownership_continuity]"][value="${opinion.has_ownership_continuity}"]`);
          if (radio) radio.checked = true;
          const textarea = document.querySelector('textarea[name="kanungo_opinion[opinion_details]"]');
          if (textarea) textarea.value = opinion.opinion_details || '';
        }
      })
      .catch(() => {});
  };

  window.closeKanungoOpinionModal = function() {
    const modal = document.getElementById('kanungoOpinionModal');
    modal.classList.add('hidden');
    const form = document.getElementById('kanungoOpinionForm');
    if (form) form.reset();
  };

  const kanungoFormEl = document.getElementById('kanungoOpinionForm');
  if (kanungoFormEl) {
    kanungoFormEl.addEventListener('submit', function(e) {
      e.preventDefault();
      const form = this;
      const formData = new FormData(form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
      })
      .then(resp => { if (!resp.ok) throw new Error('Network'); return resp.json(); })
      .then(data => {
        if (data.success) {
          window.closeKanungoOpinionModal();
          setTimeout(() => { window.location.reload(); }, 500);
        } else {
          alert('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
      })
      .catch(() => alert('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।'));
    });
  }

  const kanungoModalEl = document.getElementById('kanungoOpinionModal');
  if (kanungoModalEl) {
    kanungoModalEl.addEventListener('click', function(e) {
      if (e.target === this) { window.closeKanungoOpinionModal(); }
    });
  }

  // Order Modal Functions
  window.openOrderModal = function(compensationId) {
    const modal = document.getElementById('orderModal');
    const form = document.getElementById('orderForm');
    form.action = `/compensation/${compensationId}/order`;
    modal.classList.remove('hidden');
    
    // Prefill with existing data from the page if available
    const existingDate = '{{ $compensation->order_signature_date ?? "" }}';
    const existingName = '{{ $compensation->signing_officer_name ?? "" }}';
    
    if (existingDate || existingName) {
      const dateInput = document.querySelector('input[name="order_signature_date"]');
      const nameInput = document.querySelector('input[name="signing_officer_name"]');
      
      if (dateInput && existingDate) dateInput.value = existingDate;
      if (nameInput && existingName) nameInput.value = existingName;
    }
    
    // Also try to fetch from API if available
    fetch(`/compensation/${compensationId}/order`)
      .then(r => r.ok ? r.json() : null)
      .then(data => {
        if (data && data.order) {
          const order = data.order;
          const dateInput = document.querySelector('input[name="order_signature_date"]');
          const nameInput = document.querySelector('input[name="signing_officer_name"]');
          if (dateInput) dateInput.value = order.order_signature_date || dateInput.value || '';
          if (nameInput) nameInput.value = order.signing_officer_name || nameInput.value || '';
        }
      })
      .catch(() => {});
  };

  window.closeOrderModal = function() {
    const modal = document.getElementById('orderModal');
    modal.classList.add('hidden');
    // Don't reset the form to preserve existing data
    // const form = document.getElementById('orderForm');
    // if (form) form.reset();
  };

  const orderFormEl = document.getElementById('orderForm');
  if (orderFormEl) {
    orderFormEl.addEventListener('submit', function(e) {
      e.preventDefault();
      const form = this;
      const formData = new FormData(form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
      })
      .then(resp => { if (!resp.ok) throw new Error('Network'); return resp.json(); })
      .then(data => {
        if (data.success) {
          window.closeOrderModal();
          setTimeout(() => { window.location.reload(); }, 500);
        } else {
          alert('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
      })
      .catch(() => alert('কিছু সমস্যা হয়েছে। আবার চেষ্টা করুন।'));
    });
  }

  const orderModalEl = document.getElementById('orderModal');
  if (orderModalEl) {
    orderModalEl.addEventListener('click', function(e) {
      if (e.target === this) { window.closeOrderModal(); }
    });
  }

  // Final Order Modal Functions
  window.openFinalOrderModal = function(compensationId) {
    const modal = document.getElementById('finalOrderModal');
    const form = document.getElementById('finalOrderForm');
    form.action = `/compensation/${compensationId}/final-order`;
    modal.classList.remove('hidden');
    
    // Prefill if exists
    fetch(`/compensation/${compensationId}/final-order`)
      .then(r => r.ok ? r.json() : null)
      .then(data => {
        if (data && data.final_order) {
          const finalOrder = data.final_order;
          
          // Handle land checkbox and fields
          const landCheckbox = document.querySelector('input[name="final_order[land][selected]"]');
          if (landCheckbox) {
            landCheckbox.checked = finalOrder.land && finalOrder.land.selected;
            if (finalOrder.land && finalOrder.land.selected) {
              toggleLandFields();
              // Load land categories
              const landRecords = document.getElementById('landRecords');
              if (landRecords && finalOrder.land.categories) {
                // Prefill existing land categories data
                finalOrder.land.categories.forEach((category, index) => {
                  const categoryNameInput = landRecords.querySelector(`input[name="final_order[land][categories][${index}][category_name]"]`);
                  const acquiredLandInput = landRecords.querySelector(`input[name="final_order[land][categories][${index}][acquired_land]"]`);
                  if (categoryNameInput) categoryNameInput.value = category.category_name || '';
                  if (acquiredLandInput) acquiredLandInput.value = category.acquired_land || '';
                });
              }
            }
          }
          
          // Handle trees/crops checkbox and fields
          const treesCropsCheckbox = document.querySelector('input[name="final_order[trees_crops][selected]"]');
          if (treesCropsCheckbox) {
            treesCropsCheckbox.checked = finalOrder.trees_crops && finalOrder.trees_crops.selected;
            if (finalOrder.trees_crops && finalOrder.trees_crops.selected) {
              toggleTreesCropsFields();
              // Set compensation type
              const radio = document.querySelector(`input[name="final_order[trees_crops][compensation_type]"][value="${finalOrder.trees_crops.compensation_type}"]`);
              if (radio) radio.checked = true;
              // Set amount
              const amountInput = document.querySelector('input[name="final_order[trees_crops][amount]"]');
              if (amountInput) amountInput.value = finalOrder.trees_crops.amount || '';
            }
          }
          
          // Handle infrastructure checkbox and fields
          const infrastructureCheckbox = document.querySelector('input[name="final_order[infrastructure][selected]"]');
          if (infrastructureCheckbox) {
            infrastructureCheckbox.checked = finalOrder.infrastructure && finalOrder.infrastructure.selected;
            if (finalOrder.infrastructure && finalOrder.infrastructure.selected) {
              toggleInfrastructureFields();
              // Set compensation type
              const radio = document.querySelector(`input[name="final_order[infrastructure][compensation_type]"][value="${finalOrder.infrastructure.compensation_type}"]`);
              if (radio) radio.checked = true;
              // Set amount
              const amountInput = document.querySelector('input[name="final_order[infrastructure][amount]"]');
              if (amountInput) amountInput.value = finalOrder.infrastructure.amount || '';
            }
          }
        }
      })
      .catch(() => {});
  };

  window.closeFinalOrderModal = function() {
    const modal = document.getElementById('finalOrderModal');
    modal.classList.add('hidden');
    const form = document.getElementById('finalOrderForm');
    if (form) {
      form.reset();
      // Reset all field visibility
      const landFields = document.getElementById('landFields');
      const treesCropsFields = document.getElementById('treesCropsFields');
      const infrastructureFields = document.getElementById('infrastructureFields');
      
      if (landFields) landFields.classList.add('hidden');
      if (treesCropsFields) treesCropsFields.classList.add('hidden');
      if (infrastructureFields) infrastructureFields.classList.add('hidden');

    }
  };

  const finalOrderFormEl = document.getElementById('finalOrderForm');
  if (finalOrderFormEl) {
    finalOrderFormEl.addEventListener('submit', function(e) {
      e.preventDefault();
      const form = this;
      const formData = new FormData(form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      
      // Process form data before submission
      const finalOrderData = {
        land: {
          selected: formData.get('final_order[land][selected]') === '1',
          categories: []
        },
        trees_crops: {
          selected: formData.get('final_order[trees_crops][selected]') === '1',
          compensation_type: formData.get('final_order[trees_crops][compensation_type]'),
          amount: formData.get('final_order[trees_crops][amount]')
        },
        infrastructure: {
          selected: formData.get('final_order[infrastructure][selected]') === '1',
          compensation_type: formData.get('final_order[infrastructure][compensation_type]'),
          amount: formData.get('final_order[infrastructure][amount]')
        }
      };

      console.log('Form data processing:', {
        landSelected: formData.get('final_order[land][selected]'),
        treesCropsSelected: formData.get('final_order[trees_crops][selected]'),
        infrastructureSelected: formData.get('final_order[infrastructure][selected]')
      });

      // Process land categories only if land section exists
      if (document.getElementById('landFields')) {
        const landRecords = document.querySelectorAll('.land-record');
        console.log('Found land records:', landRecords.length);
        landRecords.forEach((record, index) => {
          const categoryNameInput = record.querySelector('input[name*="[category_name]"]');
          const acquiredLandInput = record.querySelector('input[name*="[acquired_land]"]');
          
          if (categoryNameInput && acquiredLandInput) {
            const categoryName = categoryNameInput.value;
            const acquiredLand = acquiredLandInput.value;
            console.log(`Land record ${index}:`, { categoryName, acquiredLand });
            
            if (categoryName || acquiredLand) {
              finalOrderData.land.categories.push({
                category_name: categoryName,
                acquired_land: acquiredLand
              });
            }
          }
        });
      }

      // Create new FormData with processed data
      const processedFormData = new FormData();
      processedFormData.append('_token', csrfToken);
      processedFormData.append('_method', 'PUT');
      processedFormData.append('final_order', JSON.stringify(finalOrderData));

      fetch(form.action, {
        method: 'POST',
        body: processedFormData,
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
      })
      .then(resp => {
        console.log('Response status:', resp.status);
        console.log('Response headers:', resp.headers);
        if (!resp.ok) {
          throw new Error(`HTTP ${resp.status}: ${resp.statusText}`);
        }
        return resp.json();
      })
      .then(data => {
        console.log('Response data:', data);
        if (data.success) {
          window.closeFinalOrderModal();
          setTimeout(() => { window.location.reload(); }, 500);
        } else {
          alert('কিছু সমস্যা হয়েছে: ' + (data.message || 'অজানা ত্রুটি'));
        }
      })
      .catch((error) => {
        console.error('Fetch error details:', {
          error: error,
          message: error.message,
          stack: error.stack,
          name: error.name
        });
        alert('কিছু সমস্যা হয়েছে: ' + error.message);
      });
    });
  }

  const finalOrderModalEl = document.getElementById('finalOrderModal');
  if (finalOrderModalEl) {
    finalOrderModalEl.addEventListener('click', function(e) {
      if (e.target === this) { window.closeFinalOrderModal(); }
    });
  }

  // Toggle Land Fields
  function toggleLandFields() {
    const landFields = document.getElementById('landFields');
    const landCheckbox = document.querySelector('input[name="final_order[land][selected]"]');
    
    if (!landFields || !landCheckbox) {
      console.warn('Land fields or checkbox not found');
      return;
    }
    
    if (landCheckbox.checked) {
      landFields.classList.remove('hidden');
    } else {
      landFields.classList.add('hidden');
    }
  }

  // Toggle Trees/Crops Fields
  function toggleTreesCropsFields() {
    const treesCropsFields = document.getElementById('treesCropsFields');
    const treesCropsCheckbox = document.querySelector('input[name="final_order[trees_crops][selected]"]');
    
    if (!treesCropsFields || !treesCropsCheckbox) {
      console.warn('Trees/Crops fields or checkbox not found');
      return;
    }
    
    if (treesCropsCheckbox.checked) {
      treesCropsFields.classList.remove('hidden');
    } else {
      treesCropsFields.classList.add('hidden');
    }
  }

  // Toggle Infrastructure Fields
  function toggleInfrastructureFields() {
    const infrastructureFields = document.getElementById('infrastructureFields');
    const infrastructureCheckbox = document.querySelector('input[name="final_order[infrastructure][selected]"]');
    
    if (!infrastructureFields || !infrastructureCheckbox) {
      console.warn('Infrastructure fields or checkbox not found');
      return;
    }
    
    if (infrastructureCheckbox.checked) {
      infrastructureFields.classList.remove('hidden');
    } else {
      infrastructureFields.classList.add('hidden');
    }
  }


</script>
@endsection 