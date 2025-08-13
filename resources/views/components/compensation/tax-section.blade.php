<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৪</span>
        খাজনার তথ্য
    </h2>
    <div class="grid grid-cols-1 xl:grid-cols-4 md:grid-cols-3 gap-4 sm:gap-2 xs:gap-1">
        <div class="floating-label">
            <input type="text" name="tax_info[holding_no]" value="{{ old('tax_info.holding_no', isset(
                $compensation) ? $compensation->tax_info['holding_no'] ?? '' : '') }}" placeholder=" ">
            <label>হোল্ডিং নম্বর<span class="text-blue-500">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="tax_info[paid_land_amount]" value="{{ old('tax_info.paid_land_amount', isset(
                $compensation) ? $compensation->tax_info['paid_land_amount'] ?? '' : '') }}" 
                   placeholder=" " pattern="[০-৯0-9\.]+" title="শুধুমাত্র সংখ্যা এবং দশমিক বিন্দু অনুমোদিত">
            <label>আবেদনকৃত দাগে খাজনা প্রদানকৃত জমির পরিমান (একর)<span class="text-blue-500">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="tax_info[english_year]" value="{{ old('tax_info.english_year', isset($compensation) ? $compensation->tax_info['english_year'] ?? '' : '') }}" placeholder=" ">
            <label>ইংরেজি সাল পর্যন্ত<span class="text-blue-500">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="tax_info[bangla_year]" value="{{ old('tax_info.bangla_year', isset($compensation) ? $compensation->tax_info['bangla_year'] ?? '' : '') }}" placeholder=" ">
            <label>বাংলা সাল পর্যন্ত<span class="text-blue-500">*</span></label>
        </div>
        
    </div>
    <style>
    @media (max-width: 1024px) {
        .form-section { padding: 1rem !important; }
    }
    @media (max-width: 768px) {
        .form-section { padding: 0.75rem !important; }
        .form-section-title { font-size: 1.1rem; }
        .grid { grid-template-columns: 1fr !important; }
    }
    @media (max-width: 480px) {
        .form-section { padding: 0.5rem !important; }
        .form-section-title { font-size: 1rem; }
    }
    </style>
</div> 