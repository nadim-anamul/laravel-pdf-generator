<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">২</span>
        রোয়েদাদের তথ্যঃ
    </h2>
    
    <!-- Conditional Fields Note -->
    <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <p class="text-sm text-yellow-800">
            <span class="font-semibold">দ্রষ্টব্য:</span> SA নির্বাচন করলে SA দাগ নং এবং SA খতিয়ান নং প্রয়োজন। 
            RS নির্বাচন করলে RS দাগ নং এবং RS খতিয়ান নং প্রয়োজন।
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-4 xs:gap-2">
        <div class="floating-label">
            <input type="text" name="la_case_no" value="{{ old('la_case_no', isset($compensation) ? $compensation->la_case_no : '') }}" placeholder=" " required>
            <label>এলএ কেস নং<span class="text-red-500">*</span></label>
        </div>
        
        <div class="floating-label">
            <select name="acquisition_record_basis" id="acquisition_record_basis" x-model="acquisition_record_basis" class="form-input" required aria-required="true">
                <option value="">-- নির্বাচন করুন --</option>
                <option value="SA">SA</option>
                <option value="RS">RS</option>
            </select>
            <label for="acquisition_record_basis">যে রেকর্ড মূলে অধিগ্রহণ<span class="text-red-500">*</span></label>
            @error('acquisition_record_basis')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="floating-label">
            <input type="text" name="plot_no" value="{{ old('plot_no', isset($compensation) ? $compensation->plot_no : '') }}" placeholder=" " required>
                                    <label>খতিয়ান নং<span class="text-red-500">*</span></label>
        </div>
        <template x-if="acquisition_record_basis === 'SA'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2 sm:gap-4 xs:gap-2">
                <div class="floating-label">
                    <input type="text" name="sa_plot_no" id="award_sa_plot_no" value="{{ old('sa_plot_no', isset($compensation) ? $compensation->sa_plot_no : '') }}" placeholder=" " required>
                    <label for="award_sa_plot_no">SA দাগ নং<span class="text-red-500">*</span></label>
                    @if(old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') == 'SA')
                        @error('sa_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
                <div class="floating-label">
                    <input type="text" name="rs_plot_no" id="award_rs_plot_no_sa" value="{{ old('rs_plot_no', isset($compensation) ? $compensation->rs_plot_no : '') }}" placeholder=" ">
                    <label for="award_rs_plot_no_sa">RS দাগ নং</label>
                    @if(old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') == 'SA')
                        @error('rs_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
            </div>
        </template>
        <template x-if="acquisition_record_basis === 'RS'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2 sm:gap-4 xs:gap-2">
                <div class="floating-label">
                    <input type="text" name="rs_plot_no" id="award_rs_plot_no_rs" value="{{ old('rs_plot_no', isset($compensation) ? $compensation->rs_plot_no : '') }}" placeholder=" " required>
                    <label for="award_rs_plot_no_rs">RS দাগ নং<span class="text-red-500">*</span></label>
                    @if(old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') == 'RS')
                        @error('rs_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
            </div>
        </template>
        <!-- Award Holder Names Section -->
        <div class="md:col-span-2">
            <div class="sub-section">
                <h4 class="text-lg font-semibold mb-4">রোয়েদাদভুক্ত মালিকের তথ্য<span class="text-red-500">*</span></h4>
                <div>
                    <template x-for="(holder, index) in award_holder_names" :key="index">
                        <div class="record-card relative mb-4">
                            <h5 x-text="'মালিক #' + (index + 1)" class="font-semibold mb-3"></h5>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4 sm:gap-2 xs:gap-1">
                                <div class="floating-label">
                                    <input type="text" 
                                           :name="'award_holder_names[' + index + '][name]'" 
                                           x-model="holder.name" 
                                           placeholder=" " 
                                           class="form-input w-full" 
                                           required>
                                    <label>মালিকের নাম<span class="text-red-500">*</span></label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" 
                                           :name="'award_holder_names[' + index + '][father_name]'" 
                                           x-model="holder.father_name" 
                                           placeholder=" " 
                                           class="form-input w-full" 
                                           required>
                                    <label>পিতার নাম<span class="text-red-500">*</span></label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" 
                                           :name="'award_holder_names[' + index + '][address]'" 
                                           x-model="holder.address" 
                                           placeholder=" " 
                                           class="form-input w-full" 
                                           required>
                                    <label>ঠিকানা<span class="text-red-500">*</span></label>
                                </div>
                            </div>
                            <button type="button" 
                                    @click="award_holder_names.splice(index, 1)" 
                                    class="btn-danger absolute top-4 right-4 sm:static sm:mt-4 sm:ml-auto sm:block"
                                    x-show="award_holder_names.length > 1"
                                    style="min-width: 40px; min-height: 40px;"
                                    title="মালিক মুছুন">
                                ×
                            </button>
                        </div>
                    </template>
                    <button type="button" 
                            @click="award_holder_names.push({name: '', father_name: '', address: ''})" 
                            class="btn-success w-full sm:w-auto">
                        + মালিকের তথ্য যোগ করুন
                    </button>
                </div>
            </div>
        </div>
        <div class="floating-label md:col-span-2">
            <textarea name="objector_details" rows="3" placeholder=" ">{{ old('objector_details', isset($compensation) ? $compensation->objector_details : '') }}</textarea>
            <label>রোয়েদাদে কোন আপত্তি অন্তর্ভুক্ত থাকলে আপত্তিকারীর নাম ও ঠিকানা</label>
        </div>
        <div>
            <label>আবেদনকারীর নাম রোয়েদাদে আছে কিনা?<span class="text-red-500">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="is_applicant_in_award" value="1" {{ (old('is_applicant_in_award', isset($compensation) ? $compensation->is_applicant_in_award : '')) == '1' ? 'checked' : '' }} class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="is_applicant_in_award" value="0" {{ (old('is_applicant_in_award', isset($compensation) ? $compensation->is_applicant_in_award : '')) == '0' ? 'checked' : '' }} class="mr-2"><span>না</span></label>
            </div>
        </div>
        <div class="floating-label">
            <input type="text" name="source_tax_percentage" value="{{ old('source_tax_percentage', isset($compensation) ? $compensation->source_tax_percentage : '') }}" placeholder=" " required pattern="[০-৯0-9\.]+" @input="formatNumberInput($event.target.value, $event.target)">
            <label>উৎস কর %<span class="text-red-500">*</span></label>
        </div>
        <div>
            <label>রোয়েদাদের ধরন<span class="text-red-500">*</span></label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="award_type[]" value="জমি" x-model="award_type" class="mr-2"><span>জমি</span></label>
                <label><input type="checkbox" name="award_type[]" value="গাছপালা/ফসল" x-model="award_type" class="mr-2"><span>গাছপালা/ফসল</span></label>
                <label><input type="checkbox" name="award_type[]" value="অবকাঠামো" x-model="award_type" class="mr-2"><span>অবকাঠামো</span></label>
            </div>
        </div>
        
        <!-- Conditional Fields based on Award Type -->
        <!-- For জমি (Land) -->
        <template x-if="award_type.includes('জমি')">
            <div class="md:col-span-2">
                <div class="section-header mb-4">
                    <h3 class="text-lg font-semibold text-blue-600 border-b-2 border-blue-200 pb-2">জমির রোয়েদাদ</h3>
                </div>
                
                <div class="floating-label">
                    <input type="text" name="land_award_serial_no" value="{{ old('land_award_serial_no', isset($compensation) ? $compensation->land_award_serial_no : '') }}" placeholder=" " required>
                    <label>জমির রোয়েদাদ নং<span class="text-red-500">*</span></label>
                </div>
                
                <!-- Land Category Section -->
                <div class="sub-section mt-6">
                    <h4 class="text-lg font-semibold mb-4">জমির রোয়েদাদ<span class="text-red-500">*</span></h4>
                    <div>
                        <template x-for="(category, index) in land_category" :key="index">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 sm:gap-2 xs:gap-1">
                                <div class="floating-label">
                                    <input type="text" 
                                           :name="'land_category[' + index + '][category_name]'" 
                                           x-model="category.category_name" 
                                           placeholder="জমির শ্রেণী" 
                                           class="form-input w-full" 
                                           required>
                                    <label>জমির শ্রেণী<span class="text-red-500">*</span></label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" 
                                           :name="'land_category[' + index + '][total_land]'" 
                                           x-model="category.total_land" 
                                           placeholder="মোট জমির পরিমাণ" 
                                           class="form-input w-full" 
                                           required
                                           pattern="[০-৯0-9\.]+"
                                           @input="formatNumberInput($event.target.value, $event.target)">
                                    <label>মোট জমির পরিমাণ (একর)<span class="text-red-500">*</span></label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" 
                                           :name="'land_category[' + index + '][total_compensation]'" 
                                           x-model="category.total_compensation" 
                                           placeholder="মোট ক্ষতিপূরণ" 
                                           class="form-input w-full" 
                                           required
                                           pattern="[০-৯0-9\.]+"
                                           @input="formatNumberInput($event.target.value, $event.target)">
                                    <label>মোট ক্ষতিপূরণ<span class="text-red-500">*</span></label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" 
                                           :name="'land_category[' + index + '][applicant_land]'" 
                                           x-model="category.applicant_land" 
                                           placeholder="আবেদনকারীর জমি" 
                                           class="form-input w-full"
                                           pattern="[০-৯0-9\.]+"
                                           @input="formatNumberInput($event.target.value, $event.target)">
                                    <label>আবেদনকারীর অধিগ্রহণকৃত জমি (একর)<span class="text-blue-500">*</span></label>
                                </div>
                                <button type="button" 
                                        @click="removeLandCategory(index)" 
                                        class="btn-danger"
                                        x-show="land_category.length > 1"
                                        style="min-width: 40px; min-height: 40px;">
                                    ×
                                </button>
                            </div>
                        </template>
                        <button type="button" 
                                @click="addLandCategory()" 
                                class="btn-success w-full sm:w-auto">
                            আরো শ্রেণী যোগ করুন
                        </button>
                    </div>
                </div>
            </div>
        </template>
        
        <!-- For গাছপালা/ফসল (Trees/Crops) -->
        <template x-if="award_type.includes('গাছপালা/ফসল')">
            <div class="md:col-span-2">
                <div class="section-header mb-4">
                    <h3 class="text-lg font-semibold text-green-600 border-b-2 border-green-200 pb-2">গাছপালা/ফসলের রোয়েদাদ</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label">
                        <input type="text" name="tree_award_serial_no" value="{{ old('tree_award_serial_no', isset($compensation) ? $compensation->tree_award_serial_no : '') }}" placeholder=" " required>
                        <label>গাছপালা/ফসলের রোয়েদাদ নং<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="tree_compensation" value="{{ old('tree_compensation', isset($compensation) ? $compensation->tree_compensation : '') }}" placeholder=" " required pattern="[০-৯0-9\.]+" @input="formatNumberInput($event.target.value, $event.target)">
                        <label>গাছপালা/ফসলের মোট ক্ষতিপূরণ<span class="text-red-500">*</span></label>
                    </div>
                </div>
            </div>
        </template>
        
        <!-- For অবকাঠামো (Infrastructure) -->
        <template x-if="award_type.includes('অবকাঠামো')">
            <div class="md:col-span-2">
                <div class="section-header mb-4">
                    <h3 class="text-lg font-semibold text-purple-600 border-b-2 border-purple-200 pb-2">অবকাঠামোর রোয়েদাদ</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label">
                        <input type="text" name="infrastructure_award_serial_no" value="{{ old('infrastructure_award_serial_no', isset($compensation) ? $compensation->infrastructure_award_serial_no : '') }}" placeholder=" " required>
                        <label>অবকাঠামোর রোয়েদাদ নং<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="infrastructure_compensation" value="{{ old('infrastructure_compensation', isset($compensation) ? $compensation->infrastructure_compensation : '') }}" placeholder=" " required pattern="[০-৯0-9\.]+" @input="formatNumberInput($event.target.value, $event.target)">
                        <label>অবকাঠামোর মোট ক্ষতিপূরণ<span class="text-red-500">*</span></label>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <style>
    @media (max-width: 768px) {
        .form-section { padding: 0.75rem !important; }
        .form-section-title { font-size: 1.1rem; }
        .sub-section { padding: 0.75rem !important; }
        .btn-success, .btn-danger { min-width: 40px; min-height: 40px; font-size: 1rem; }
    }
    @media (max-width: 480px) {
        .form-section { padding: 0.5rem !important; }
        .form-section-title { font-size: 1rem; }
        .sub-section { padding: 0.5rem !important; }
        .btn-success, .btn-danger { min-width: 36px; min-height: 36px; font-size: 0.95rem; }
    }
    </style>
</div> 