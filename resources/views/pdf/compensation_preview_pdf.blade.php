@extends('layouts.pdf')

@section('title', 'ক্ষতিপূরণ তথ্য প্রিভিউ')

@section('content')
<div class="container-pdf">
    <!-- Header with case summary -->
    <div class="header-section">
        <h1 class="main-title">ক্ষতিপূরণ তথ্য প্রিভিউ</h1>
        <div class="case-summary">
            <div class="summary-item">
                <span class="summary-label">মামলা নং:</span>
                <span class="summary-value">{{ $compensation->getBengaliValue('case_number') }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">তারিখ:</span>
                <span class="summary-value">{{ $compensation->case_date_bengali }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">এলএ কেস:</span>
                <span class="summary-value">{{ $compensation->getBengaliValue('la_case_no') }}</span>
            </div>
        </div>
    </div>

    <!-- Case Information -->
    <div class="card-pdf">
        <h2 class="section-header">
            মামলার তথ্য
        </h2>
        <div class="info-grid">
            <div class="info-item">
                <label>মামলা নম্বর:</label>
                <span>{{ $compensation->getBengaliValue('case_number') }}</span>
            </div>
            <div class="info-item">
                <label>মামলার তারিখ:</label>
                <span>{{ $compensation->case_date_bengali }}</span>
            </div>
            <div class="info-item">
                <label>এলএ কেস নং:</label>
                <span>{{ $compensation->getBengaliValue('la_case_no') }}</span>
            </div>
            @if($compensation->land_award_serial_no)
            <div class="info-item">
                <label>জমির রোয়েদাদ নং:</label>
                <span>{{ $compensation->getBengaliValue('land_award_serial_no') }}</span>
            </div>
            @endif
            @if($compensation->tree_award_serial_no)
            <div class="info-item">
                <label>গাছপালার রোয়েদাদ নং:</label>
                <span>{{ $compensation->getBengaliValue('tree_award_serial_no') }}</span>
            </div>
            @endif
            @if($compensation->infrastructure_award_serial_no)
            <div class="info-item">
                <label>অবকাঠামোর রোয়েদাদ নং:</label>
                <span>{{ $compensation->getBengaliValue('infrastructure_award_serial_no') }}</span>
            </div>
            @endif
            <div class="info-item">
                <label>রেকর্ড মূলে অধিগ্রহণ:</label>
                <span>{{ $compensation->acquisition_record_basis }}</span>
            </div>
            <div class="info-item">
                <label>দাগ নং:</label>
                <span>{{ $compensation->getBengaliValue('plot_no') }}</span>
            </div>
        </div>
    </div>

    <!-- Applicant Information -->
    <div class="card-pdf">
        <h2 class="section-header">
            আবেদনকারীর তথ্য
        </h2>
        @foreach($compensation->applicants as $index => $applicant)
        <div class="applicant-card">
            <h3 class="applicant-title">আবেদনকারী #{{ $index + 1 }}</h3>
            <div class="applicant-info">
                <div class="info-row">
                    <div class="info-col">
                        <label>নাম:</label>
                        <span>{{ $applicant['name'] }}</span>
                    </div>
                    <div class="info-col">
                        <label>পিতার নাম:</label>
                        <span>{{ $applicant['father_name'] }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-col full-width">
                        <label>ঠিকানা:</label>
                        <span>{{ $applicant['address'] }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-col">
                        <label>এন আই ডি:</label>
                        <span>{{ $compensation->bnDigits($applicant['nid']) }}</span>
                    </div>
                    @if(isset($applicant['mobile']) && $applicant['mobile'])
                    <div class="info-col">
                        <label>মোবাইল নং:</label>
                        <span>{{ $compensation->bnDigits($applicant['mobile']) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Award Information -->
    <div class="card-pdf">
        <h2 class="section-header">
            রোয়েদাদের তথ্য
        </h2>
        
        <!-- Award Summary -->
        <div class="award-summary">
            <div class="summary-grid">
                <div class="summary-box">
                    <label>মোট জমির পরিমাণ:</label>
                    <span class="highlight-value">
                        @php
                            $totalLand = 0;
                            if($compensation->land_category && is_array($compensation->land_category)) {
                                foreach($compensation->land_category as $category) {
                                    $totalLand += floatval($category['total_land'] ?? 0);
                                }
                            }
                            echo $compensation->bnDigits(number_format($totalLand, 6)) . ' একর';
                        @endphp
                    </span>
                </div>
                <div class="summary-box">
                    <label>মোট ক্ষতিপূরণ:</label>
                    <span class="highlight-value">
                        @php
                            $totalCompensation = 0;
                            if($compensation->land_category && is_array($compensation->land_category)) {
                                foreach($compensation->land_category as $category) {
                                    $totalCompensation += floatval($category['total_compensation'] ?? 0);
                                }
                            }
                            echo $compensation->bnDigits(number_format($totalCompensation, 2)) . ' টাকা';
                        @endphp
                    </span>
                </div>
                <div class="summary-box">
                    <label>উৎস কর %:</label>
                    <span>{{ $compensation->getBengaliValue('source_tax_percentage') }}</span>
                </div>
                <div class="summary-box">
                    <label>আবেদনকারী রোয়েদাদে আছে:</label>
                    <span class="status-badge {{ $compensation->is_applicant_in_award ? 'status-yes' : 'status-no' }}">
                        {{ $compensation->is_applicant_in_award ? 'হ্যাঁ' : 'না' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Award Holders -->
        @if($compensation->award_holder_names && count($compensation->award_holder_names) > 0)
        <div class="award-holders">
            <h3 class="subsection-title">রোয়েদাদভুক্ত মালিকের তথ্য</h3>
            @foreach($compensation->award_holder_names as $index => $holder)
            <div class="holder-card">
                <h4 class="holder-title">মালিক #{{ $index + 1 }}</h4>
                <div class="holder-info">
                    <div class="info-row">
                        <div class="info-col">
                            <label>নাম:</label>
                            <span>{{ $holder['name'] }}</span>
                        </div>
                        @if(isset($holder['father_name']) && $holder['father_name'])
                        <div class="info-col">
                            <label>পিতার নাম:</label>
                            <span>{{ $holder['father_name'] }}</span>
                        </div>
                        @endif
                    </div>
                    @if(isset($holder['address']) && $holder['address'])
                    <div class="info-row">
                        <div class="info-col full-width">
                            <label>ঠিকানা:</label>
                            <span>{{ $holder['address'] }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Additional Compensation Details -->
        @if($compensation->tree_compensation || $compensation->infrastructure_compensation || $compensation->applicant_acquired_land)
        <div class="additional-compensation">
            <h3 class="subsection-title">অতিরিক্ত ক্ষতিপূরণের তথ্য</h3>
            <div class="compensation-grid">
                @if($compensation->tree_compensation)
                <div class="compensation-item">
                    <label>গাছপালার ক্ষতিপূরণ:</label>
                    <span class="highlight-value">{{ $compensation->tree_compensation }}</span>
                </div>
                @endif
                @if($compensation->infrastructure_compensation)
                <div class="compensation-item">
                    <label>অবকাঠামোর ক্ষতিপূরণ:</label>
                    <span class="highlight-value">{{ $compensation->infrastructure_compensation }}</span>
                </div>
                @endif
                @if($compensation->applicant_acquired_land)
                <div class="compensation-item">
                    <label>আবেদনকারীর অধিগ্রহণকৃত জমি:</label>
                    <span class="highlight-value">{{ $compensation->bnDigits($compensation->applicant_acquired_land) }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Land Categories -->
        @if($compensation->land_category && count($compensation->land_category) > 0)
        <div class="land-categories">
            <h3 class="subsection-title">জমির শ্রেণী অনুযায়ী তথ্য</h3>
            <div class="category-table">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>জমির শ্রেণী</th>
                            <th>মোট জমি</th>
                            <th>মোট ক্ষতিপূরণ</th>
                            <th>আবেদনকারীর জমি</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compensation->land_category as $category)
                        <tr>
                            <td>{{ $category['category_name'] ?? '' }}</td>
                            <td>{{ $compensation->bnDigits($category['total_land'] ?? '') }} একর</td>
                            <td>{{ $compensation->bnDigits($category['total_compensation'] ?? '') }}</td>
                            <td>{{ $category['applicant_land'] ? $compensation->bnDigits($category['applicant_land']) . ' একর' : 'তথ্য নেই' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Award Type and Records -->
        <div class="award-details">
            @if($compensation->award_type)
            <div class="detail-item">
                <label>রোয়েদাদের ধরন:</label>
                <span>{{ is_array($compensation->award_type) ? implode(', ', $compensation->award_type) : $compensation->award_type }}</span>
            </div>
            @endif
            
            @if($compensation->acquisition_record_basis === 'SA')
            <div class="record-info">
                <h4>SA রেকর্ড তথ্য</h4>
                <div class="info-row">
                    <div class="info-col">
                        <label>SA দাগ নং:</label>
                        <span>{{ $compensation->getBengaliValue('sa_plot_no') }}</span>
                    </div>
                    <div class="info-col">
                        <label>SA খতিয়ান নং:</label>
                        <span>{{ $compensation->getBengaliValue('sa_khatian_no') }}</span>
                    </div>
                </div>
            </div>
            @endif
            
            @if($compensation->acquisition_record_basis === 'RS')
            <div class="record-info">
                <h4>RS রেকর্ড তথ্য</h4>
                <div class="info-row">
                    <div class="info-col">
                        <label>RS দাগ নং:</label>
                        <span>{{ $compensation->getBengaliValue('rs_plot_no') }}</span>
                    </div>
                    <div class="info-col">
                        <label>RS খতিয়ান নং:</label>
                        <span>{{ $compensation->getBengaliValue('rs_khatian_no') }}</span>
                    </div>
                </div>
            </div>
            @endif
            
            @if($compensation->objector_details)
            <div class="objector-info">
                <label>আপত্তিকারীর তথ্য:</label>
                <span>{{ $compensation->objector_details }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Land Schedule -->
    <div class="card-pdf">
        <h2 class="section-header">
            আবেদনকৃত জমির তফসিল
        </h2>
        <div class="land-schedule-info">
            <div class="location-details">
                <div class="info-row">
                    <div class="info-col">
                        <label>জেলা:</label>
                        <span>{{ $compensation->district ?? 'তথ্য নেই' }}</span>
                    </div>
                    <div class="info-col">
                        <label>উপজেলা:</label>
                        <span>{{ $compensation->upazila ?? 'তথ্য নেই' }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-col">
                        <label>মৌজার নাম:</label>
                        <span>{{ $compensation->mouza_name }}</span>
                    </div>
                    <div class="info-col">
                        <label>জেএল নং:</label>
                        <span>{{ $compensation->getBengaliValue('jl_no') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="record-details">
                <div class="info-row">
                    <div class="info-col">
                        <label>এসএ খতিয়ান নং:</label>
                        <span>{{ $compensation->getBengaliValue('sa_khatian_no') }}</span>
                    </div>
                    <div class="info-col">
                        <label>SA দাগ নং:</label>
                        <span>{{ $compensation->getBengaliValue('land_schedule_sa_plot_no') }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-col">
                        <label>আর এস খতিয়ান নং:</label>
                        <span>{{ $compensation->getBengaliValue('rs_khatian_no') }}</span>
                    </div>
                    <div class="info-col">
                        <label>RS দাগ নং:</label>
                        <span>{{ $compensation->getBengaliValue('land_schedule_rs_plot_no') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ownership Continuity -->
    @if($compensation->ownership_details)
    <div class="card-pdf">
        <h2 class="section-header">
            মালিকানার ধারাবাহিকতার বর্ণনা
        </h2>
        
        <!-- Story Sequence Display - Show First -->
        @if(isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
        <div class="mb-4">
            <h3 class="subsection-title">মালিকানার ধারাবাহিকতার ক্রম</h3>
            <div class="story-sequence">
                @foreach($compensation->ownership_details['storySequence'] as $index => $item)
                <div class="story-item">
                    <div class="story-number">{{ $index + 1 }}</div>
                    <div class="story-content">
                        <div class="story-type">{{ $item['type'] }}</div>
                        <div class="story-description">{{ $item['description'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($compensation->acquisition_record_basis === 'SA' && isset($compensation->ownership_details['sa_info']))
        <div class="mb-4">
            <h3 class="subsection-title">SA রেকর্ড তথ্য</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>SA দাগ নম্বর:</label>
                    <span>{{ $compensation->ownership_details['sa_info']['sa_plot_no'] ?? '' }}</span>
                </div>
                <div class="info-item">
                    <label>SA খতিয়ান নম্বর:</label>
                    <span>{{ $compensation->ownership_details['sa_info']['sa_khatian_no'] ?? '' }}</span>
                </div>
                <div class="info-item">
                    <label>SA দাগে মোট জমি:</label>
                                            <span>{{ $compensation->bnDigits($compensation->ownership_details['sa_info']['sa_total_land_in_plot'] ?? '') }}</span>
                </div>
                <div class="info-item">
                    <label>SA উক্ত খতিয়ানে জমির পরিমাণ:</label>
                    <span>{{ $compensation->getBengaliNestedValue('ownership_details.sa_info.sa_land_in_khatian') ?? '' }}</span>
                </div>
            </div>
            
            @if(isset($compensation->ownership_details['sa_owners']))
            <div class="mt-3">
                <h4 class="subsection-subtitle">SA মালিকগণ:</h4>
                @foreach($compensation->ownership_details['sa_owners'] as $owner)
                <p class="owner-item">• {{ $owner['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        @if($compensation->acquisition_record_basis === 'RS' && isset($compensation->ownership_details['rs_info']))
        <div class="mb-4">
            <h3 class="subsection-title">RS রেকর্ড তথ্য</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>RS দাগ নম্বর:</label>
                    <span>{{ $compensation->ownership_details['rs_info']['rs_plot_no'] ?? '' }}</span>
                </div>
                <div class="info-item">
                    <label>RS খতিয়ান নম্বর:</label>
                    <span>{{ $compensation->ownership_details['rs_info']['rs_khatian_no'] ?? '' }}</span>
                </div>
                <div class="info-item">
                    <label>RS দাগে মোট জমি:</label>
                                            <span>{{ $compensation->bnDigits($compensation->ownership_details['rs_info']['rs_total_land_in_plot'] ?? '') }}</span>
                </div>
                <div class="info-item">
                    <label>RS খতিয়ানে মোট জমির পরিমাণ:</label>
                    <span>{{ $compensation->ownership_details['rs_info']['rs_land_in_khatian'] ?? '' }}</span>
                </div>
                <div class="info-item">
                    <label>ডিপি খতিয়ান:</label>
                    <span>{{ isset($compensation->ownership_details['rs_info']['dp_khatian']) && $compensation->ownership_details['rs_info']['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</span>
                </div>
            </div>
            
            @if(isset($compensation->ownership_details['rs_owners']))
            <div class="mt-3">
                <h4 class="subsection-subtitle">RS মালিকগণ:</h4>
                @foreach($compensation->ownership_details['rs_owners'] as $owner)
                <p class="owner-item">• {{ $owner['name'] }}</p>
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
                @if($item['itemType'] === 'deed' && isset($deedTransfers[$item['itemIndex']]))
                    @php $deed = $deedTransfers[$item['itemIndex']]; $displayedDeeds[] = $item['itemIndex']; @endphp
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-green-600">দলিল মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="font-semibold mb-2">দলিল #{{ $item['itemIndex'] + 1 }}</h4>
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
                                    <p class="text-gray-900">{{ isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
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
                                @if(isset($deed['tax_info']) && $deed['tax_info'])
                                <div class="md:col-span-2">
                                    <label class="font-semibold text-gray-700">খারিজের তথ্য:</label>
                                    <p class="text-gray-900">{{ $deed['tax_info'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
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
                                    <p class="text-gray-900">{{ $rs['plot_no'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস খতিয়ান নম্বর:</label>
                                    <p class="text-gray-900">{{ $rs['khatian_no'] ?? '' }}</p>
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
                                    <p class="text-gray-900">{{ isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
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
                                    <p class="text-gray-900">{{ $rs['plot_no'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label class="font-semibold text-gray-700">আরএস খতিয়ান নম্বর:</label>
                                    <p class="text-gray-900">{{ $rs['khatian_no'] ?? '' }}</p>
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
                            <p class="text-gray-900">{{ isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                        @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
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
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_case_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_plot_no'] ?? '' }}</p>
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
    @endif

    <!-- Tax Information -->
    <div class="card-pdf">
        <h2 class="section-header">
            খাজনার তথ্য
        </h2>
        <div class="info-grid">
            <div class="info-item">
                <label>হোল্ডিং নম্বর:</label>
                @if(!empty($compensation->tax_info['holding_no'] ?? ''))
                    <span>{{ $compensation->tax_info['holding_no'] }}</span>
                @else
                    <span class="no-data">তথ্য নেই</span>
                @endif
            </div>
            <div class="info-item">
                <label>আবেদনকৃত দাগে খাজনা প্রদানকৃত জমির পরিমান (একরে):</label>
                @if(!empty($compensation->tax_info['paid_land_amount'] ?? ''))
                                                <span>{{ $compensation->bnDigits($compensation->tax_info['paid_land_amount']) }}</span>
                @else
                    <span class="no-data">তথ্য নেই</span>
                @endif
            </div>
            <div class="info-item">
                <label>ইংরেজি বছর:</label>
                @if(!empty($compensation->tax_info['english_year'] ?? ''))
                    <span>{{ $compensation->tax_info['english_year'] }}</span>
                @else
                    <span class="no-data">তথ্য নেই</span>
                @endif
            </div>
            <div class="info-item">
                <label>বাংলা বছর:</label>
                @if(!empty($compensation->tax_info['bangla_year'] ?? ''))
                    <span>{{ $compensation->tax_info['bangla_year'] }}</span>
                @else
                    <span class="no-data">তথ্য নেই</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional Documents -->
    <div class="card-pdf">
        <h2 class="section-header">
            বণ্টন / না-দাবি / আপসনামা / এফিডেভিটের তথ্য
        </h2>
        @if(isset($compensation->additional_documents_info['selected_types']) && !empty($compensation->additional_documents_info['selected_types']))
        <div class="mb-3">
            <label class="section-label">দাখিলকৃত ডকুমেন্টের ধরন:</label>
            <div class="document-types">
                @foreach($compensation->additional_documents_info['selected_types'] as $type)
                <span class="document-type-badge">{{ $type }}</span>
                @endforeach
            </div>
        </div>
        @else
        <div class="mb-3">
            <label class="section-label">দাখিলকৃত ডকুমেন্টের ধরন:</label>
            <span class="no-data">তথ্য নেই</span>
        </div>
        @endif
        
        @if(isset($compensation->additional_documents_info['details']) && !empty($compensation->additional_documents_info['details']))
        <div>
            <label class="section-label">ডকুমেন্টের বিবরণ:</label>
            @foreach($compensation->additional_documents_info['details'] as $type => $details)
            <div class="document-detail">
                <h4 class="document-type-title">{{ $type }}:</h4>
                <p class="document-description">{{ $details }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div>
            <label class="section-label">ডকুমেন্টের বিবরণ:</label>
            <span class="no-data">তথ্য নেই</span>
        </div>
        @endif
    </div>

    <!-- Kanungo Opinion -->
    @if($compensation->kanungo_opinion)
    <div class="card-pdf">
        <h2 class="section-header">
            কানুনগো/সার্ভেয়ারের মতামত
        </h2>
        <div class="info-grid">
            <div class="info-item">
                <label>মালিকানার ধারাবাহিকতা আছে কিনা:</label>
                <span class="status-badge {{ isset($compensation->kanungo_opinion['has_ownership_continuity']) && $compensation->kanungo_opinion['has_ownership_continuity'] === 'yes' ? 'status-yes' : 'status-no' }}">
                    {{ isset($compensation->kanungo_opinion['has_ownership_continuity']) && $compensation->kanungo_opinion['has_ownership_continuity'] === 'yes' ? 'হ্যাঁ' : 'না' }}
                </span>
            </div>
            <div class="info-item">
                <label>মতামতের বিবরণ:</label>
                <span>{{ $compensation->kanungo_opinion['opinion_details'] ?? '' }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Final Order Information -->
    @if($compensation->final_order)
    <div class="card-pdf">
        <h2 class="section-header">
            চূড়ান্ত আদেশ
        </h2>
        
        @if(isset($compensation->final_order['land']) && $compensation->final_order['land']['selected'])
        <div class="mb-4">
            <h3 class="subsection-title">জমি</h3>
            <div class="land-categories">
                @if(isset($compensation->final_order['land']['categories']) && is_array($compensation->final_order['land']['categories']))
                    @foreach($compensation->final_order['land']['categories'] as $index => $category)
                    <div class="category-item">
                        <div class="category-grid">
                            <div class="category-field">
                                <label>জমির শ্রেণী:</label>
                                <span>{{ $category['category_name'] ?? '' }}</span>
                            </div>
                            <div class="category-field">
                                <label>অধিগ্রহণকৃত জমি (একর):</label>
                                <span>{{ $category['acquired_land'] ?? '' }}</span>
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
            <h3 class="subsection-title">গাছপালা/ফসল</h3>
            <div class="compensation-item">
                <div class="compensation-grid">
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের ধরন:</label>
                        <span>{{ $compensation->final_order['trees_crops']['compensation_type'] === 'full' ? 'সম্পূর্ণ' : 'আংশিক' }}</span>
                    </div>
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের পরিমাণ:</label>
                        <span>{{ $compensation->final_order['trees_crops']['amount'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($compensation->final_order['infrastructure']) && $compensation->final_order['infrastructure']['selected'])
        <div class="mb-4">
            <h3 class="subsection-title">অবকাঠামো</h3>
            <div class="compensation-item">
                <div class="compensation-grid">
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের ধরন:</label>
                        <span>{{ $compensation->final_order['infrastructure']['compensation_type'] === 'full' ? 'সম্পূর্ণ' : 'আংশিক' }}</span>
                    </div>
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের পরিমাণ:</label>
                        <span>{{ $compensation->final_order['infrastructure']['amount'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Order Information - Case Completion Status -->
    @if($compensation->order_signature_date)
    <div class="card-pdf">
        <h2 class="section-header">
            আদেশ তথ্য - কেস নিষ্পত্তিকৃত
        </h2>
        <div class="completion-status">
            <div class="status-indicator">
                <span class="status-icon">✓</span>
                <span class="status-text">এই ক্ষতিপূরণ কেসটি নিষ্পত্তিকৃত হয়েছে</span>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <label>আদেশ স্বাক্ষরের তারিখ:</label>
                <span>{{ $compensation->order_signature_date }}</span>
            </div>
            <div class="info-item">
                <label>স্বাক্ষরকারী কর্মকর্তার নাম:</label>
                <span>{{ $compensation->signing_officer_name ?? 'তথ্য নেই' }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Mutation Information -->
    @if($compensation->mutation_info)
    <div class="card-pdf">
        <h2 class="section-header">
            নামজারির তথ্য
        </h2>
        <div class="info-grid">
            <div class="info-item">
                <label>নামজারি আছে কিনা:</label>
                <span class="status-badge {{ isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'] ? 'status-yes' : 'status-no' }}">
                    {{ isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'] ? 'হ্যাঁ' : 'না' }}
                </span>
            </div>
            @if(isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'])
            <div class="info-item">
                <label>নামজারির ধরন:</label>
                <span>{{ $compensation->mutation_info['mutation_type'] ?? '' }}</span>
            </div>
            <div class="info-item">
                <label>নামজারির তারিখ:</label>
                <span>{{ $compensation->mutation_info['mutation_date'] ?? '' }}</span>
            </div>
            <div class="info-item">
                <label>নামজারির বিবরণ:</label>
                <span>{{ $compensation->mutation_info['mutation_details'] ?? '' }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Order Details -->
    @if($compensation->order_signature_date || $compensation->signing_officer_name)
    <div class="card-pdf">
        <h2 class="section-header">
            আদেশের তথ্য
        </h2>
        <div class="info-grid">
            @if($compensation->order_signature_date)
            <div class="info-item">
                <label>আদেশ স্বাক্ষরের তারিখ:</label>
                <span>{{ $compensation->order_signature_date }}</span>
            </div>
            @endif
            @if($compensation->signing_officer_name)
            <div class="info-item">
                <label>স্বাক্ষরকারী কর্মকর্তার নাম:</label>
                <span>{{ $compensation->signing_officer_name }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Former and Current Plot Information -->
    @if($compensation->former_plot_no || $compensation->current_plot_no)
    <div class="card-pdf">
        <h2 class="section-header">
            দাগ নম্বরের তথ্য
        </h2>
        <div class="info-grid">
            @if($compensation->former_plot_no)
            <div class="info-item">
                <label>পূর্ববর্তী দাগ নম্বর:</label>
                <span>{{ $compensation->former_plot_no }}</span>
            </div>
            @endif
            @if($compensation->current_plot_no)
            <div class="info-item">
                <label>বর্তমান দাগ নম্বর:</label>
                <span>{{ $compensation->current_plot_no }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Application Analysis -->
    <div class="card-pdf">
        <h2 class="section-header">
            আবেদনপত্র বিশ্লেষণ
        </h2>
        <div class="space-y-4">
            <!-- Application Type -->
            <div class="analysis-item">
                <p class="analysis-text">
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
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারী 
                    @if($compensation->applicants && is_array($compensation->applicants))
                        {{ $compensation->bnDigits(count($compensation->applicants)) }} জন।
                    @else
                        ১ জন।
                    @endif
                </p>
            </div>

            <!-- Award Holder Count -->
            <div class="analysis-item">
                <p class="text-gray-800">
                    রোয়েদাদভুক্ত মালিক 
                    @if($compensation->award_holder_names && is_array($compensation->award_holder_names))
                        {{ $compensation->bnDigits(count($compensation->award_holder_names)) }} জন।
                    @else
                        ১ জন।
                    @endif
                </p>
            </div>

            <!-- Applicant in Award Status -->
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারীর নাম রোয়েদাদে 
                    @if($compensation->is_applicant_in_award)
                        আছে।
                    @else
                        নাই।
                    @endif
                </p>
            </div>

            <!-- Settlement Distribution Logic -->
            <div class="analysis-item">
                <p class="analysis-text">
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
            <div class="analysis-item">
                <p class="analysis-text">
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
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারীর নামে উল্লিখিত দাগে খারিজ করা 
                    @if($compensation->mutation_info && isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'])
                        আছে।
                    @else
                        নাই।
                    @endif
                </p>
            </div>

            <!-- Tax Receipt Status -->
            <div class="analysis-item">
                <p class="analysis-text">
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
                        ইংরেজি {{ $compensation->tax_info['english_year'] }} এবং বাংলা {{ $compensation->tax_info['bangla_year'] }} সন পর্যন্ত {{ $compensation->bnDigits($compensation->tax_info['paid_land_amount']) }} একর জমির খাজনা পরিশোধ করা হয়েছে।
                    @else
                        উল্লিখিত দাগে খাজনার রশিদ দাখিল করা হয়নাই
                    @endif
                </p>
            </div>

            <!-- Deed Information -->
            @if($compensation->ownership_details && isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0)
            <div class="analysis-item">
                <p class="analysis-text">
                    @foreach($compensation->ownership_details['deed_transfers'] as $deed)
                        @if(isset($deed['deed_number']) && !empty($deed['deed_number']))
                            আবেদনকারীর দাখিলকৃত দলিল নং {{ $deed['deed_number'] }} তে উল্লিখিত দাগে দখল উল্লেখ করা 
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
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারী উল্লিখিত দাগে অধিগ্রহণকৃত {{ $compensation->bnDigits($total_land) }} একর জমির মধ্যে {{ $compensation->bnDigits($applicant_acquired_land) }} একরের ক্ষতিপূরণ দাবী করেন।
                </p>
            </div>
            @endif

            <!-- Acquisition Record Basis -->
            <div class="analysis-item">
                <p class="analysis-text">
                    {{ $compensation->acquisition_record_basis ?? 'এসএ/ আরএস' }} রেকর্ডমূলে অধিগ্রহণ।
                </p>
            </div>
            @if($compensation->acquisition_record_basis === 'SA' && (!$compensation->ownership_details || !isset($compensation->ownership_details['rs_record_info'])))
            <div class="analysis-item">
                <p class="analysis-text">
                        এস এ রেকর্ডমূলে অধিগ্রহণ, কিন্তু আরএস রেকর্ডের তথ্য দাখিল করা হয়নি।
                </p>
            </div>
            @endif
            <!-- Objection Status -->
            <div class="analysis-item">
                <p class="analysis-text">
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

    
</div>

<style>
/* PDF-optimized styles matching preview page */
body {
    font-family: 'Tiro Bangla', serif;
    line-height: 1.5;
    color: #111827;
    margin: 0;
    padding: 0;
    background-color: #f9fafb;
}

/* Container matching preview page */
.container-pdf {
    max-width: 100%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9fafb;
}

/* Header section matching preview */
.header-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    padding: 20px;
    margin-bottom: 20px;
    text-align: center;
}

.main-title {
    font-size: 28px;
    font-weight: bold;
    color: #1f2937;
    margin: 0 0 20px 0;
    border-bottom: 2px solid #3b82f6;
    padding-bottom: 15px;
}

.case-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.summary-item {
    text-align: center;
    padding: 15px;
    background: #f8fafc;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.summary-label {
    display: block;
    font-weight: 600;
    color: #4b5563;
    font-size: 14px;
    margin-bottom: 5px;
}

.summary-value {
    color: #1f2937;
    font-size: 16px;
    font-weight: 600;
}

/* Section headers matching preview page */
h2 {
    font-size: 20px;
    font-weight: 600;
    margin: 20px 0 15px 0;
    color: #2563eb;
    border-bottom: 2px solid #bfdbfe;
    padding-bottom: 8px;
}

h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 15px 0 10px 0;
    color: #059669;
}

/* Cards matching preview page styling */
.card-pdf {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    transition: all 0.2s ease;
}

.card-pdf:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Compact grids */
.grid-pdf {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 8px;
}

.grid-pdf-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
}

.grid-pdf-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

/* Info grid matching preview page */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.info-item label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    margin-bottom: 4px;
}

.info-item span {
    color: #111827;
    font-size: 14px;
    padding: 6px 0;
    line-height: 1.5;
}

/* Status badges matching preview page */
.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    min-width: 70px;
    border: 1px solid transparent;
}

.status-yes {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.status-no {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fecaca;
}

/* Compact form fields */
.field-pdf {
    margin-bottom: 6px;
}

.field-pdf label {
    font-weight: 600;
    color: #4b5563;
    font-size: 13px;
    display: block;
    margin-bottom: 2px;
}

.field-pdf p {
    margin: 0;
    color: #111827;
    font-size: 13px;
    padding: 2px 0;
}

/* Applicant sections matching preview page */
.applicant-card {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
    background: #f9fafb;
}

.applicant-title {
    font-size: 16px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 10px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 5px;
}

.applicant-info {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.info-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.info-col {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-col.full-width {
    grid-column: 1 / -1;
}

.info-col label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.info-col span {
    color: #111827;
    font-size: 14px;
    padding: 4px 0;
}

/* Award holders matching preview page */
.holder-card {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
    background: #f9fafb;
}

.holder-title {
    font-size: 16px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 10px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 5px;
}

.holder-info {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Tables matching preview page */
.data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
    background: white;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

.data-table th,
.data-table td {
    border: 1px solid #e5e7eb;
    padding: 12px;
    font-size: 14px;
    text-align: left;
}

.data-table th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

.data-table tr:nth-child(even) {
    background: #f9fafb;
}

.data-table tr:hover {
    background: #f3f4f6;
}

/* Compact status indicators */
.status-pdf {
    display: inline-block;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}

.status-yes {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-no {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* Compact spacing utilities */
.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 12px; }
.mb-4 { margin-bottom: 16px; }
.mb-5 { margin-bottom: 20px; }

.p-2 { padding: 8px; }
.p-3 { padding: 12px; }
.p-4 { padding: 16px; }

/* Page break controls */
.page-break {
    page-break-before: always;
}

.avoid-break {
    page-break-inside: avoid;
}

/* Print optimizations */
@media print {
    .card-pdf {
        break-inside: avoid;
    }
    
    h2 {
        break-after: avoid;
    }
}



/* Analysis section matching preview page */
.analysis-item {
    padding: 16px;
    background: #f9fafb;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    margin-bottom: 12px;
}

.analysis-text {
    margin: 0;
    color: #111827;
    font-size: 14px;
    line-height: 1.5;
}

/* Award summary matching preview page */
.award-summary {
    margin: 15px 0;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.summary-box {
    background: #f8fafc;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    text-align: center;
}

.summary-box label {
    display: block;
    font-weight: 600;
    color: #4b5563;
    font-size: 13px;
    margin-bottom: 8px;
}

.highlight-value {
    color: #1f2937;
    font-size: 16px;
    font-weight: 600;
}

/* Subsection titles matching preview page */
.subsection-title {
    font-size: 16px;
    font-weight: 600;
    color: #059669;
    margin: 15px 0 10px 0;
    border-bottom: 1px solid #d1fae5;
    padding-bottom: 5px;
}

.subsection-subtitle {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin: 10px 0 5px 0;
}

/* Section label matching preview page */
.section-label {
    font-weight: 600;
    color: #4b5563;
    font-size: 13px;
    display: block;
    margin-bottom: 8px;
}

/* Story sequence matching preview page */
.story-sequence {
    margin-top: 10px;
}

.story-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
    padding: 8px;
    background: #eff6ff;
    border-radius: 6px;
    border-left: 4px solid #3b82f6;
}

.story-number {
    width: 24px;
    height: 24px;
    background: #3b82f6;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 24px;
    font-size: 12px;
    font-weight: bold;
    margin-right: 10px;
    flex-shrink: 0;
}

.story-content {
    flex: 1;
}

.story-type {
    font-weight: 600;
    color: #1e40af;
    font-size: 13px;
    margin-bottom: 2px;
}

.story-description {
    color: #6b7280;
    font-size: 12px;
}

.owner-item {
    margin: 4px 0;
    color: #111827;
    font-size: 13px;
}

.no-data {
    color: #dc2626;
    font-style: italic;
    font-size: 13px;
}

/* Document types matching preview page */
.document-types {
    margin-top: 8px;
}

.document-type-badge {
    display: inline-block;
    background: #dbeafe;
    color: #1e40af;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    margin-right: 6px;
    margin-bottom: 6px;
}

.document-detail {
    margin-top: 12px;
    padding: 8px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: #f9fafb;
}

.document-type-title {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 5px 0;
}

.document-description {
    margin: 0;
    color: #111827;
    font-size: 12px;
    line-height: 1.4;
}

/* Land categories matching preview page */
.land-categories {
    margin-top: 10px;
}

.category-item {
    background: #f9fafb;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    margin-bottom: 8px;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 8px;
}

.category-field {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.category-field label {
    font-weight: 600;
    color: #4b5563;
    font-size: 12px;
}

.category-field span {
    color: #111827;
    font-size: 12px;
}

.compensation-item {
    background: #f9fafb;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.compensation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 8px;
}

.compensation-field {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.compensation-field label {
    font-weight: 600;
    color: #4b5563;
    font-size: 12px;
}

.compensation-field span {
    color: #111827;
    font-size: 12px;
}

.completion-status {
    margin: 15px 0;
    padding: 12px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-icon {
    width: 20px;
    height: 20px;
    background: #16a34a;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-size: 12px;
    font-weight: bold;
}

.status-text {
    font-size: 14px;
    font-weight: 600;
    color: #166534;
}

/* Summary section styles */
.summary-content {
    margin-top: 15px;
}

.summary-item {
    margin-bottom: 20px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
}

.summary-title {
    font-size: 16px;
    font-weight: 600;
    color: #1e40af;
    margin: 0 0 10px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 5px;
}

.summary-text {
    margin: 0;
    color: #374151;
    font-size: 14px;
    line-height: 1.5;
}

.recommendations {
    margin-top: 10px;
}

.recommendation-item {
    margin: 8px 0;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
}

.recommendation-item.positive {
    background: #dcfce7;
    color: #166534;
    border-left: 3px solid #16a34a;
}

.recommendation-item.negative {
    background: #fef2f2;
    color: #991b1b;
    border-left: 3px solid #dc2626;
}

.recommendation-item.warning {
    background: #fef3c7;
    color: #92400e;
    border-left: 3px solid #f59e0b;
}
</style>
@endsection 