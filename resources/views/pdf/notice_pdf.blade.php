<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নোটিশ</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Embedded Noto Serif Bengali font -->
    <style>
        @font-face {
            font-family: 'Noto Serif Bengali';
            font-style: normal;
            font-weight: 400;
            src: url('https://fonts.gstatic.com/s/notoserifbengali/v1/yYLrQh9-fIXkJvOfkYQ2bL3XYPFvqA.woff2') format('woff2');
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Noto Serif Bengali', serif;
        }
        .notice-page {
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            padding: 15mm;
            background: white;
            box-sizing: border-box;
        }
        .notice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .notice-title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
            font-size: 18px;
        }
        .notice-content {
            font-size: 14px;
            line-height: 1.6;
        }
        .notice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .notice-table th,
        .notice-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .notice-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .notice-signature {
            margin-top: 40px;
            text-align: right;
            font-weight: bold;
        }
        @media print {
            body { margin: 0; }
            .notice-page { 
                width: 21cm; 
                height: 29.7cm; 
                margin: 0; 
                padding: 15mm;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="notice-page">
        <div class="notice-header">
            <h1 style="font-size: 20px; font-weight: bold; margin: 0;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h1>
            <h2 style="font-size: 18px; font-weight: bold; margin: 5px 0;">জেলা প্রশাসকের কার্যালয়</h2>
            <h2 style="font-size: 18px; font-weight: bold; margin: 5px 0;">বগুড়া</h2>
            <h3 style="font-size: 16px; margin: 5px 0;">(ভূমি অধিগ্রহণ শাখা)</h3>
        </div>

        <div class="notice-title">নোটিশ</div>

        <div class="notice-content">
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <p class="mb-1">প্রসেস নং:</p>
                    <p class="mb-1">ক্ষতিপূরণ কেস নং: {{ $compensation->getBengaliValue('case_number') ?? 'N/A' }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <p class="mb-1">তারিখ: ............................</p>
                    <p class="mb-1">এল.এ কেস নং: {{ $compensation->getBengaliValue('la_case_no') ?? 'N/A' }}</p>
                </div>
            </div>

            <table class="notice-table">
                <thead>
                    <tr>
                        <th class="border border-black p-2 w-1/2">আবেদনকারীর নাম ও ঠিকানা</th>
                        <th class="border border-black p-2 w-1/2">রোয়েদাদভুক্ত মালিকের নাম ও ঠিকানা</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="vertical-align: top;">
                            @if($compensation->applicants && is_array($compensation->applicants))
                                @foreach($compensation->applicants as $index => $applicant)
                                    @if($index > 0)<br><br>@endif
                                    <strong>#{{ $index + 1 }}:</strong><br>
                                    {{ $applicant['name'] ?? 'N/A' }}<br>
                                    পিতার নাম- {{ $applicant['father_name'] ?? 'N/A' }}<br>
                                    সাং- {{ $applicant['address'] ?? 'N/A' }}@if(isset($applicant['mobile']) && $applicant['mobile'])<br>মোবাইল- {{ $applicant['mobile'] }}@endif
                                @endforeach
                            @else
                                <span style="color: #6b7280;">কোন আবেদনকারী নেই</span>
                            @endif
                        </td>
                        <td style="vertical-align: top;">
                            @if($compensation->award_holder_names && is_array($compensation->award_holder_names))
                                @foreach($compensation->award_holder_names as $index => $holder)
                                    @if($index > 0)<br><br>@endif
                                    <strong>#{{ $index + 1 }}:</strong><br>
                                    {{ $holder['name'] ?? 'N/A' }}<br>
                                    @if(isset($holder['father_name']) && $holder['father_name'])পিতার নাম- {{ $holder['father_name'] }}<br>@endif
                                    @if(isset($holder['address']) && $holder['address'])সাং- {{ $holder['address'] }}@endif
                                @endforeach
                            @else
                                <span style="color: #6b7280;">কোন রোয়েদাদভুক্ত মালিক নেই</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <p style="margin: 20px 0; text-align: justify;">
                এতদ্বারা জানানো যাচ্ছে যে, নিম্ন তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণের বিষয়টি নিষ্পত্তির লক্ষ্যে শুনানীর জন্য আগামী <strong>............................</strong> ইং তারিখ দিন ধার্য করা হয়েছে। ধার্য তারিখে বেলা ৯.৩০ ঘটিকায় ক্ষতিপূরণ প্রাপ্তির স্বপক্ষে যাবতীয় প্রমাণাদির মূল কপিসহ শুনানীতে উপস্থিত হওয়ার জন্য বলা হলো।
            </p>
            <p style="margin: 10px 0; text-align: justify;">
                অন্যথায় বিধি মোতাবেক পরবর্তী আইনগত ব্যবস্থা গ্রহণ করা হবে।
            </p>

            <p style="margin: 20px 0; font-weight: bold;">তফসিলঃ</p>
            <p style="margin: 5px 0;">জেলা: {{ $compensation->district ?? 'তথ্য নেই' }}</p>
            <p style="margin: 5px 0;">উপজেলা: {{ $compensation->upazila ?? 'তথ্য নেই' }}</p>
            <p style="margin: 5px 0;">মৌজা: {{ $compensation->mouza_name ?? 'তথ্য নেই' }}</p>

            <table class="notice-table">
                <thead>
                    <tr>
                        <th>খতিয়ান নং</th>
                        <th>দাগ নং</th>
                        <th>পরিমাণ (একরে)</th>
                        <th>আবেদনকৃত ক্ষতিপূরণের ধরণ</th>
                    </tr>
                </thead>
                <tbody>
                    @if($compensation->land_category && is_array($compensation->land_category) && count($compensation->land_category) > 0)
                        @foreach($compensation->land_category as $category)
                        <tr>
                            <td>{{ $compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A' }}</td>
                            <td>{{ $compensation->plot_no ?? 'N/A' }}</td>
                            <td>{{ $compensation->bnDigits($category['total_land'] ?? 'N/A') }}</td>
                            <td>
                                @if($compensation->award_type && is_array($compensation->award_type))
                                    {{ implode(', ', $compensation->award_type) }}
                                @else
                                    {{ $compensation->award_type ?? 'N/A' }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td>{{ $compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A' }}</td>
                        <td>{{ $compensation->plot_no ?? 'N/A' }}</td>
                        <td>N/A</td>
                        <td>
                            @if($compensation->award_type && is_array($compensation->award_type))
                                {{ implode(', ', $compensation->award_type) }}
                            @else
                                {{ $compensation->award_type ?? 'N/A' }}
                            @endif
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            </br>
        </br>

            <div class="notice-signature">
                <p style="margin: 5px 0;">ভূমি অধিগ্রহণ কর্মকর্তা</p>
                <p style="margin: 5px 0;">বগুড়া</p>
            </div>
        </div>
    </div>
</body>
</html>
