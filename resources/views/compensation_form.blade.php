@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ তথ্য ফরম')

@section('styles')
<style>
    body { 
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .form-section { 
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 2px solid #e2e8f0; 
        border-radius: 15px; 
        padding: 2rem; 
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
    }
    
    .form-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
    }
    
    .form-section-title { 
        font-size: 1.5rem; 
        font-weight: 700; 
        margin-bottom: 1.5rem; 
        padding-bottom: 0.75rem; 
        border-bottom: 3px solid #e2e8f0;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-section-title::before {
        content: '';
        width: 8px;
        height: 8px;
        background: linear-gradient(45deg, #3b82f6, #8b5cf6);
        border-radius: 50%;
        display: inline-block;
    }
    
    .sub-section { 
        background: linear-gradient(145deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0; 
        border-radius: 12px; 
        padding: 1.5rem; 
        margin-top: 1.5rem; 
        position: relative;
        transition: all 0.3s ease;
    }
    
    .sub-section:hover {
        border-color: #06b6d4;
        box-shadow: 0 4px 12px rgba(6, 182, 212, 0.1);
    }
    
    label { 
        font-weight: 600; 
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
    }
    
    input[type="text"], 
    input[type="number"],
    input[type="tel"], 
    input[type="date"], 
    input[type="email"], 
    select, 
    textarea {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    input[type="text"]:focus, 
    input[type="number"]:focus,
    input[type="tel"]:focus, 
    input[type="date"]:focus, 
    input[type="email"]:focus, 
    select:focus, 
    textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(59, 130, 246, 0.25);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(59, 130, 246, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(107, 114, 128, 0.25);
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(107, 114, 128, 0.4);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.25);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(16, 185, 129, 0.4);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.25);
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(239, 68, 68, 0.4);
    }
    
    .record-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .record-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #06b6d4;
    }
    
    .record-card h3, .record-card h4 {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .record-card h3::before, .record-card h4::before {
        content: '';
        width: 6px;
        height: 6px;
        background: linear-gradient(45deg, #06b6d4, #3b82f6);
        border-radius: 50%;
        display: inline-block;
    }
    
    .radio-group, .checkbox-group {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }
    
    .radio-group label, .checkbox-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(145deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .radio-group label:hover, .checkbox-group label:hover {
        border-color: #3b82f6;
        background: linear-gradient(145deg, #eff6ff, #dbeafe);
    }
    
    .radio-group input:checked + span,
    .checkbox-group input:checked + span {
        color: #3b82f6;
        font-weight: 600;
    }
    
    .alert {
        background: linear-gradient(145deg, #fef2f2, #fee2e2);
        border: 2px solid #fecaca;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        color: #991b1b;
        font-weight: 500;
    }
    
    .alert ul {
        margin-top: 0.5rem;
        padding-left: 1.5rem;
    }
    
    .alert li {
        margin-bottom: 0.25rem;
    }
    
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header p {
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    .form-footer {
        background: linear-gradient(145deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        text-align: center;
    }
    
    .form-footer .btn {
        margin: 0 0.5rem;
    }
    
    .section-icon {
        width: 24px;
        height: 24px;
        background: linear-gradient(45deg, #3b82f6, #8b5cf6);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: bold;
        margin-right: 0.75rem;
    }
    
    .floating-label {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .floating-label input,
    .floating-label select,
    .floating-label textarea {
        width: 100%;
        padding-top: 1.5rem;
        padding-bottom: 0.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .floating-label textarea {
        padding-left: 1rem;
        padding-right: 1rem;
        resize: vertical;
        min-height: 100px;
    }
    
    .floating-label label {
        position: absolute;
        top: 0.75rem;
        left: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
        transition: all 0.3s ease;
        pointer-events: none;
    }
    
    .floating-label input:focus + label,
    .floating-label input:not(:placeholder-shown) + label,
    .floating-label select:focus + label,
    .floating-label select:not([value=""]) + label,
    .floating-label textarea:focus + label,
    .floating-label textarea:not(:placeholder-shown) + label {
        top: 0.25rem;
        font-size: 0.75rem;
        color: #3b82f6;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .radio-group, .checkbox-group {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
    
    /* Number input specific styles */
    input[type="number"] {
        -moz-appearance: textfield; /* Firefox */
    }
    
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    /* Show spinner on hover/focus for better UX */
    input[type="number"]:hover::-webkit-outer-spin-button,
    input[type="number"]:hover::-webkit-inner-spin-button,
    input[type="number"]:focus::-webkit-outer-spin-button,
    input[type="number"]:focus::-webkit-inner-spin-button {
        -webkit-appearance: inner-spin-button;
        opacity: 1;
    }

    /* Required field indicator styles */
    .text-red-500 {
        color: #ef4444;
    }
    
    label .text-red-500 {
        font-weight: 600;
    }
    
    /* Conditional field note styles */
    .bg-yellow-50 {
        background-color: #fefce8;
    }
    
    .border-yellow-200 {
        border-color: #fde047;
    }
    
    .text-yellow-800 {
        color: #92400e;
    }
    
    /* Required fields note styles */
    .bg-blue-50 {
        background-color: #eff6ff;
    }
    
    .border-blue-200 {
        border-color: #bfdbfe;
    }
    
    .text-blue-800 {
        color: #1e40af;
    }

    @media (max-width: 1024px) {
        .container {
            padding: 2rem 0.5rem !important;
        }
        .form-container {
            padding: 1.5rem !important;
        }
        .form-section {
            padding: 1.25rem !important;
        }
        .form-footer {
            padding: 1.25rem !important;
        }
    }
    @media (max-width: 768px) {
        .container {
            padding: 1rem 0.25rem !important;
        }
        .form-container {
            padding: 1rem !important;
        }
        .form-section {
            padding: 1rem !important;
        }
        .form-section-title {
            font-size: 1.1rem;
        }
        .form-footer {
            padding: 1rem !important;
        }
        .page-header {
            padding: 1rem !important;
        }
        .page-header h1 {
            font-size: 1.25rem !important;
        }
        .grid {
            grid-template-columns: 1fr !important;
        }
        .btn-primary, .btn-secondary, .btn-success {
            padding: 0.5rem 1rem !important;
            font-size: 0.95rem !important;
        }
        .record-card {
            padding: 1rem !important;
        }
    }
    @media (max-width: 480px) {
        .container {
            padding: 0.5rem 0 !important;
        }
        .form-container {
            padding: 0.5rem !important;
        }
        .form-section {
            padding: 0.5rem !important;
        }
        .form-footer {
            padding: 0.5rem !important;
        }
        .form-section-title {
            font-size: 1rem;
        }
        .btn-primary, .btn-secondary, .btn-success {
            padding: 0.4rem 0.75rem !important;
            font-size: 0.9rem !important;
        }
    }
</style>
@endsection

@section('scripts')
@include('components.compensation.alpine-component')
<script>
    // Pass old form data to Alpine.js for validation error handling
    window.oldFormData = {
        applicants: @json(old('applicants', [])),
        acquisition_record_basis: @json(old('acquisition_record_basis', '')),
        award_type: @json(old('award_type', '')),
        award_holder_names: @json(old('award_holder_names', [])),
        land_category: @json(old('land_category', [])),
        ownership_details: @json(old('ownership_details', [])),
        additional_documents_info: @json(old('additional_documents_info', [])),
        tax_info: @json(old('tax_info', [])),
    };
</script>
@endsection

@section('content')
<div class="container mx-auto p-8 sm:p-4 xs:p-2">
    <div class="page-header">
        <div class="flex justify-between items-center">
            <div>
                <h1>{{ isset($compensation) ? 'ক্ষতিপূরণ প্রাপ্তির আবেদন ফরম আপডেট' : 'ক্ষতিপূরণ প্রাপ্তির আবেদন ফরম' }}</h1>
                <p>ভূমি অধিগ্রহণ সম্পর্কিত ক্ষতিপূরণের জন্য আবেদন ফরম</p>
            </div>
            <a href="{{ route('compensation.index') }}" class="btn-secondary">
                ← তালিকা দেখুন
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert" role="alert">
            <p><strong>অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($compensation) ? route('compensation.update', $compensation->id) : route('compensation.store') }}" method="POST" class="form-container p-8" x-data="compensationForm()" 
          data-compensation="{{ isset($compensation) ? json_encode($compensation->toBengaliDisplayArray()) : 'null' }}">
        @csrf
        @if(isset($compensation))
            @method('PUT')
        @endif
        
        <!-- Required Fields Note -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-800">
                <span class="text-red-500 font-semibold">*</span> চিহ্নিত ক্ষেত্রগুলি অবশ্যই পূরণ করতে হবে। 
                <span class="text-gray-600">(Fields marked with <span class="text-red-500">*</span> are required)</span>
            </p>
        </div>
        
        <!-- Compensation Case Filing Section -->
        <div class="form-section mb-6">
            <div class="form-section-title">ক্ষতিপূরণ কেস দায়ের</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="floating-label">
                    <input type="text" name="case_number" id="compensation_case_number" class="form-input" placeholder=" " value="{{ old('case_number', $compensation->case_number ?? '') }}" required aria-required="true">
                    <label for="compensation_case_number">ক্ষতিপূরণ কেস নং<span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="case_date" id="compensation_case_date" class="form-input" placeholder="দিন/মাস/বছর" value="{{ old('case_date', isset($compensation) ? $compensation->case_date_bengali : '') }}" required aria-required="true">
                    <label for="compensation_case_date">তারিখ<span class="text-red-500">*</span></label>
                </div>
            </div>
        </div>
        <!-- Applicant Section (required fields) -->
        @include('components.compensation.applicant-section')
        <!-- Award Section (required fields) -->
        @include('components.compensation.award-section')
        <!-- Land Schedule Section (required fields) -->
        @include('components.compensation.land-schedule-section')
        <!-- Ownership Continuity Section -->
        @include('components.compensation.ownership-continuity-section')

        <!-- Tax Section -->
        @include('components.compensation.tax-section')
        <!-- Additional Documents Section -->
        @include('components.compensation.additional-documents-section')
        <div class="form-footer">
            <button type="submit" class="btn-primary">
                জমা দিন
            </button>
        </div>
    </form>
</div>
@endsection
