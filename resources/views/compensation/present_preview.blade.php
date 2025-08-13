@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ কেসে উপস্থাপন প্রিভিউ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button and Actions -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('compensation.preview', $compensation->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            ফিরে যান
        </a>
        <div class="flex space-x-3">
            <a href="{{ route('compensation.present.pdf', $compensation->id) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                PDF ডাউনলোড করুন
            </a>
        </div>
    </div>

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Present Content -->
    <div class="bg-white w-[21cm] min-h-[29.7cm] mx-auto my-8 p-10 shadow-lg text-[16px] leading-8">
        <!-- Title -->
        <h1 class="text-center text-lg font-bold">আদেশ পত্র</h1>
        <p class="text-center text-sm mb-4">( ১৯১৭ সালের রেকর্ড ম্যানুয়েলের ১২৯ নং বিধি )</p>

        <!-- Date Row -->
        <div class="flex justify-between mb-1">
          <span>আদেশ পত্র তারিখ: ...........................................</span>
          <span>হইতে: ........................................................ পর্যন্ত</span>
        </div>

        <!-- Region Row -->
        <div class="flex justify-between mb-1">
          <span>জেলা: {{ $compensation->district ?? '…………………………….' }}</span>
          <span>সাল: …………………………. পর্যন্ত</span>
        </div>

        <!-- Case Info -->
        <div class="flex justify-between mb-1">
          <span>মামলার ধরন: ক্ষতিপূরণ কেস নং: {{ $compensation->bnDigits($compensation->case_number ?? 'N/A') }}</span> 
          <span>এল.এ কেস: {{ $compensation->bnDigits($compensation->la_case_no ?? 'N/A') }}</span>
        </div>

        <!-- Orders Table with wide second column -->
        <table class="w-full border border-black border-collapse mb-6">
          <thead>
            <tr>
              <th class="border border-black p-2 w-[25mm]">আদেশের ক্রমিক নং ও তারিখ</th>
              <th class="border border-black p-2">আদেশ ও অফিসারের স্বাক্ষর</th>
              <th class="border border-black p-2 w-[25mm]">আদেশের উপর গৃহীত ব্যবস্থা</th>
            </tr>
          </thead>
          <tbody>
            <tr class="align-top">
              <td class="border border-black p-4 h-[90mm]"></td>
              <td class="border border-black p-4">
                @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                    @php $applicant = $compensation->applicants[0]; @endphp
                    <p class="text-sm">{{ $applicant['name'] ?? 'N/A' }}</p>
                    <p class="text-sm">পিতা- {{ $applicant['father_name'] ?? 'N/A' }}, সাং- {{ $applicant['address'] ?? 'N/A' }}</p>
                    <p class="text-sm">উপজেলা- {{ $compensation->upazila ?? 'N/A' }}, জেলা: বগুড়া</p> 
                @else
                    <p class="text-sm">(আবেদনকারীর নাম)</p>
                    <p class="text-sm">পিতা- (পিতার নাম), সাং- (ঠিকানা)</p>
                    <p class="text-sm">উপজেলা- (উপজেলার নাম), জেলা: বগুড়া</p> 
                @endif
                <br>
                <p>নিম্ন তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণ দাবী করে আবেদন দাখিল করেছেন</p>
                <br>
                <p>উপজেলা: {{ $compensation->upazila ?? 'N/A' }}</p>
                <p>মৌজা: {{ $compensation->mouza_name ?? 'N/A' }}</p>
                <p>জেএল নং: {{ $compensation->bnDigits($compensation->jl_no ?? 'N/A') }}</p>
                <p>খতিয়ান নং: {{ $compensation->bnDigits($compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A') }}</p>
                <p>দাগ নং: {{ $compensation->bnDigits($compensation->plot_no ?? 'N/A') }}</p>
                <p>আবেদনকৃত ক্ষতিপূরণের ধরণ: 
                    @if($compensation->award_type && is_array($compensation->award_type))
                        {{ implode(', ', $compensation->award_type) }}
                    @else
                        {{ $compensation->award_type ?? 'N/A' }}
                    @endif
                </p>
                @php
                    $total_land = isset($compensation->total_land_amount) ? $compensation->total_land_amount : 'N/A';
                    $applicant_acquired_land = isset($compensation->applicant_acquired_land) ? $compensation->applicant_acquired_land : 'N/A';
                @endphp
                <p>অধিগ্রহণকৃত জমির পরিমাণ (একরে): {{ $compensation->bnDigits($total_land) }}</p>
                <p>দাবীকৃত জমির পরিমাণ (একরে): {{ $compensation->bnDigits($applicant_acquired_land) }}</p>
                
                <br>
                <p>আবেদিত জমি {{ $compensation->bnDigits($compensation->la_case_no ?? 'N/A') }} নং এল.এ কেসে অধিগ্রহণ করা হয়েছে। উক্ত জমির ক্ষতিপূরণ বাবদ 
                    @if($compensation->award_type && is_array($compensation->award_type))
                        @if(in_array('জমি', $compensation->award_type) && in_array('গাছপালা/ফসল', $compensation->award_type))
                            @if($compensation->land_award_serial_no && $compensation->tree_award_serial_no)
                                জমির রোয়েদাদ নং {{ $compensation->bnDigits($compensation->land_award_serial_no) }} এবং গাছপালা/ফসলের রোয়েদাদ নং {{ $compensation->bnDigits($compensation->tree_award_serial_no) }}
                            @elseif($compensation->land_award_serial_no)
                                জমির রোয়েদাদ নং {{ $compensation->bnDigits($compensation->land_award_serial_no) }}
                            @elseif($compensation->tree_award_serial_no)
                                গাছপালা/ফসলের রোয়েদাদ নং {{ $compensation->bnDigits($compensation->tree_award_serial_no) }}
                            @else
                                N/A
                            @endif
                        @elseif(in_array('জমি', $compensation->award_type) && $compensation->land_award_serial_no)
                            জমির রোয়েদাদ নং {{ $compensation->bnDigits($compensation->land_award_serial_no) }}
                        @elseif(in_array('গাছপালা/ফসল', $compensation->award_type) && $compensation->tree_award_serial_no)
                            গাছপালা/ফসলের রোয়েদাদ নং {{ $compensation->bnDigits($compensation->tree_award_serial_no) }}
                        @elseif(in_array('অবকাঠামো', $compensation->award_type) && $compensation->infrastructure_award_serial_no)
                            অবকাঠামোর রোয়েদাদ নং {{ $compensation->bnDigits($compensation->infrastructure_award_serial_no) }}
                        @else
                            N/A
                        @endif
                    @else
                        N/A
                    @endif
                    নং এওয়ার্ড প্রার্থীর নামে আছে/নাই। আবেদনকারীকে নোটিশ প্রদান করা হোক। শুনানির জন্য পরবর্তী তারিখঃ  ............... </p>
                <br><br>
                <div class="text-right font-bold">
                  ভূমি অধিগ্রহণ কর্মকর্তা <br>
                  বগুড়া
                </div>
              </td>
              <td class="border border-black p-4"></td>
            </tr>
          </tbody>
        </table>
    </div>
</div>
@endsection
