@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ তথ্য প্রিভিউ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">ক্ষতিপূরণ তথ্য প্রিভিউ</h1>
        <div class="space-x-4">
            <a href="{{ route('compensation.edit', $compensation->id) }}" class="btn-primary">
                সম্পাদনা করুন
            </a>
            <a href="{{ route('compensation.index') }}" class="btn-secondary">
                তালিকায় ফিরে যান
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{!! session('success') !!}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{!! session('error') !!}</span>
        </div>
    @endif

    <!-- Case Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">১</span>
            মামলার তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold text-gray-700">মামলা নম্বর:</label>
                <p class="text-gray-900">{{ $compensation->case_number }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মামলার তারিখ:</label>
                <p class="text-gray-900">{{ $compensation->case_date }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">এলএ কেস নং:</label>
                <p class="text-gray-900">{{ $compensation->la_case_no }}</p>
            </div>
            @if($compensation->land_award_serial_no)
            <div>
                <label class="font-semibold text-gray-700">জমির রোয়েদাদ নং:</label>
                <p class="text-gray-900">{{ $compensation->land_award_serial_no }}</p>
            </div>
            @endif
            @if($compensation->tree_award_serial_no)
            <div>
                <label class="font-semibold text-gray-700">গাছপালার রোয়েদাদ নং:</label>
                <p class="text-gray-900">{{ $compensation->tree_award_serial_no }}</p>
            </div>
            @endif
            @if($compensation->infrastructure_award_serial_no)
            <div>
                <label class="font-semibold text-gray-700">অবকাঠামোর রোয়েদাদ নং:</label>
                <p class="text-gray-900">{{ $compensation->infrastructure_award_serial_no }}</p>
            </div>
            @endif
            <div>
                <label class="font-semibold text-gray-700">যে রেকর্ড মূলে অধিগ্রহণ:</label>
                <p class="text-gray-900">{{ $compensation->acquisition_record_basis }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->plot_no }}</p>
            </div>
        </div>
    </div>

    <!-- Applicant Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">২</span>
            আবেদনকারীর তথ্য
        </h2>
        @foreach($compensation->applicants as $index => $applicant)
        <div class="mb-4 p-4 border rounded-lg">
            <h3 class="font-semibold text-lg mb-2">আবেদনকারী #{{ $index + 1 }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <p class="text-gray-900">{{ $applicant['nid'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Award Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৩</span>
            রোয়েদাদের তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold text-gray-700">রোয়েদাদভুক্ত মালিকের নাম:</label>
                <div class="text-gray-900">
                    @foreach($compensation->award_holder_names as $index => $holder)
                        <div class="mb-1">
                            {{ $index + 1 }}. {{ $holder['name'] }}
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
                        echo number_format($totalLand, 2) . ' একর';
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
                        echo number_format($totalCompensation, 2) . ' টাকা';
                    @endphp
                </p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">উৎস কর %:</label>
                <p class="text-gray-900">{{ $compensation->source_tax_percentage }}</p>
            </div>
            @if($compensation->tree_compensation)
            <div>
                <label class="font-semibold text-gray-700">গাছপালার মোট ক্ষতিপূরণ:</label>
                <p class="text-gray-900">{{ $compensation->tree_compensation }}</p>
            </div>
            @endif
            @if($compensation->infrastructure_compensation)
            <div>
                <label class="font-semibold text-gray-700">অবকাঠামোর মোট ক্ষতিপূরণ:</label>
                <p class="text-gray-900">{{ $compensation->infrastructure_compensation }}</p>
            </div>
            @endif
            @if($compensation->applicant_acquired_land)
            <div>
                <label class="font-semibold text-gray-700">আবেদনকারীর অধিগ্রহণকৃত জমির পরিমাণ:</label>
                <p class="text-gray-900">{{ $compensation->applicant_acquired_land }}</p>
            </div>
            @endif
            @if($compensation->land_category && count($compensation->land_category) > 0)
            <div class="md:col-span-2 lg:col-span-3">
                <label class="font-semibold text-gray-700">অধিগ্রহণকৃত জমির শ্রেণী:</label>
                <div class="mt-2 space-y-2">
                    @foreach($compensation->land_category as $index => $category)
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <span class="font-medium text-gray-600">জমির শ্রেণী:</span>
                                <span class="text-gray-900">{{ $category['category_name'] ?? '' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">মোট জমির পরিমাণ:</span>
                                <span class="text-gray-900">{{ $category['total_land'] ?? '' }} একর</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">মোট ক্ষতিপূরণ:</span>
                                <span class="text-gray-900">{{ $category['total_compensation'] ?? '' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">আবেদনকারীর অধিগ্রহণকৃত জমি:</span>
                                <span class="text-gray-900">{{ $category['applicant_land'] ?? '' }} একর</span>
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
                <p class="text-gray-900">{{ $compensation->sa_plot_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">SA খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->sa_khatian_no }}</p>
            </div>
            @endif
            @if($compensation->acquisition_record_basis === 'RS')
            <div>
                <label class="font-semibold text-gray-700">RS দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->rs_plot_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">RS খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->rs_khatian_no }}</p>
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
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৪</span>
            আবেদনকৃত জমির তফসিল
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold text-gray-700">মৌজার নাম:</label>
                <p class="text-gray-900">{{ $compensation->mouza_name }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">জেএল নং:</label>
                <p class="text-gray-900">{{ $compensation->jl_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">এসএ খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->sa_khatian_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">SA দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->land_schedule_sa_plot_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">আর এস খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->rs_khatian_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">RS দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->land_schedule_rs_plot_no }}</p>
            </div>
        </div>
    </div>

    <!-- Ownership Continuity -->
    @if($compensation->ownership_details)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৫</span>
            মালিকানার ধারাবাহিকতার বর্ণনা
        </h2>
        
        @if($compensation->acquisition_record_basis === 'SA' && isset($compensation->ownership_details['sa_info']))
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">SA রেকর্ড তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">SA দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_plot_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA খতিয়ান নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_khatian_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA দাগে মোট জমি:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_total_land_in_plot'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA উক্ত খতিয়ানে জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_land_in_khatian'] ?? '' }}</p>
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
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">RS রেকর্ড তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">RS দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_plot_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS খতিয়ান নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_khatian_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS দাগে মোট জমি:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_total_land_in_plot'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS খতিয়ানে মোট জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_land_in_khatian'] ?? '' }}</p>
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
                        <p class="text-gray-900">{{ $deed['deed_number'] ?? '' }}</p>
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
                        <p class="text-gray-900">{{ ($deed['possession_mentioned'] ?? 'no') === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                    </div>
                    @if(($deed['possession_mentioned'] ?? 'no') === 'yes')
                    <div>
                        <label class="font-semibold text-gray-700">দখলের দাগ নম্বর:</label>
                        <p class="text-gray-900">{{ $deed['possession_plot_no'] ?? '' }}</p>
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
                        <p class="text-gray-900">{{ $deed['mentioned_areas'] }}</p>
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
                        <label class="font-semibold text-gray-700">ওয়ারিশের ধরন:</label>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">মৃত্যু সনদ আছে কিনা:</label>
                        <p class="text-gray-900">{{ $inheritance['has_death_cert'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
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
                        <p class="text-gray-900">{{ $rs['plot_no'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">আরএস খতিয়ান নম্বর:</label>
                        <p class="text-gray-900">{{ $rs['khatian_no'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">আরএস জমির পরিমাণ:</label>
                        <p class="text-gray-900">{{ $rs['land_amount'] ?? '' }}</p>
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

        @if(isset($compensation->ownership_details['applicant_info']))
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">উপরোক্ত মালিকই আবেদনকারী</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">আবেদনকারীর নাম:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['applicant_name'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ কেস নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_case_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_plot_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_land_amount'] ?? '' }}</p>
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
    @endif

    <!-- Tax Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৬</span>
            করের তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="font-semibold text-gray-700">হোল্ডিং নম্বর:</label>
                @if(!empty($compensation->tax_info['holding_no'] ?? ''))
                    <p class="text-gray-900">{{ $compensation->tax_info['holding_no'] }}</p>
                @else
                    <p class="text-red-500 italic">অনুপলব্ধ</p>
                @endif
            </div>
            <div>
                <label class="font-semibold text-gray-700">আবেদনকৃত দাগে খাজনা প্রদানকৃত জমির পরিমান (একরে)</label>
                @if(!empty($compensation->tax_info['paid_land_amount'] ?? ''))
                    <p class="text-gray-900">{{ $compensation->tax_info['paid_land_amount'] }}</p>
                @else
                    <p class="text-red-500 italic">অনুপলব্ধ</p>
                @endif
            </div>
            <div>
                <label class="font-semibold text-gray-700">ইংরেজি বছর:</label>
                @if(!empty($compensation->tax_info['english_year'] ?? ''))
                    <p class="text-gray-900">{{ $compensation->tax_info['english_year'] }}</p>
                @else
                    <p class="text-red-500 italic">অনুপলব্ধ</p>
                @endif
            </div>
            <div>
                <label class="font-semibold text-gray-700">বাংলা বছর:</label>
                @if(!empty($compensation->tax_info['bangla_year'] ?? ''))
                    <p class="text-gray-900">{{ $compensation->tax_info['bangla_year'] }}</p>
                @else
                    <p class="text-red-500 italic">অনুপলব্ধ</p>
                @endif
            </div>
            
        </div>
    </div>

    <!-- Additional Documents -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৭</span>
            বণ্টন / না-দাবি / আপসনামা / এফিডেভিটের তথ্য
        </h2>
        @if(isset($compensation->additional_documents_info['selected_types']) && !empty($compensation->additional_documents_info['selected_types']))
        <div class="mb-4">
            <label class="font-semibold text-gray-700">দাখিলকৃত ডকুমেন্টের ধরন:</label>
            <div class="mt-2">
                @foreach($compensation->additional_documents_info['selected_types'] as $type)
                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm mr-2 mb-2">{{ $type }}</span>
                @endforeach
            </div>
        </div>
        @else
        <div class="mb-4">
            <label class="font-semibold text-gray-700">দাখিলকৃত ডকুমেন্টের ধরন:</label>
            <p class="text-red-500 italic">অনুপলব্ধ</p>
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
            <p class="text-red-500 italic">অনুপলব্ধ</p>
        </div>
        @endif
    </div>

    <!-- Kanungo Opinion -->
    @if($compensation->kanungo_opinion)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৮</span>
            কানুনগো মতামত
        </h2>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="font-semibold text-gray-700">মালিকানার ধারাবাহিকতা আছে কিনা:</label>
                <p class="text-gray-900">{{ $compensation->kanungo_opinion['has_ownership_continuity'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মতামতের বিবরণ:</label>
                <p class="text-gray-900">{{ $compensation->kanungo_opinion['opinion_details'] ?? '' }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.section-icon {
    display: inline-block;
    width: 24px;
    height: 24px;
    background-color: #3b82f6;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 24px;
    font-size: 12px;
    font-weight: bold;
    margin-right: 8px;
}

.btn-primary {
    @apply bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded;
}

.btn-secondary {
    @apply bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded;
}
</style>
@endsection 