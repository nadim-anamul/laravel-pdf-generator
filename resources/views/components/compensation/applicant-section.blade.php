<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">১</span>
        আবেদনকারীর তথ্যঃ
    </h2>
    <template x-for="(applicant, index) in applicants" :key="index">
        <div class="record-card relative">
            <h3 x-text="'আবেদনকারী #' + (index + 1)"></h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-4 xs:gap-2">
                <div class="floating-label">
                    <input type="text" :name="'applicants[' + index + '][name]'" x-model="applicant.name" placeholder=" " required>
                    <label>নাম (এনআইডি অনুযায়ী)<span class="text-red-500">*</span></label>
                    @error('applicants.*.name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="floating-label">
                    <input type="text" :name="'applicants[' + index + '][father_name]'" x-model="applicant.father_name" placeholder=" " required>
                    <label>পিতার নাম<span class="text-red-500">*</span></label>
                    @error('applicants.*.father_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="floating-label md:col-span-2">
                    <input type="text" :name="'applicants[' + index + '][address]'" x-model="applicant.address" placeholder=" " required>
                    <label>ঠিকানা<span class="text-red-500">*</span></label>
                    @error('applicants.*.address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="floating-label">
                    <input type="text" :name="'applicants[' + index + '][nid]'" x-model="applicant.nid" placeholder=" " required pattern="[০-৯0-9]+" maxlength="17" @input="formatNumberInput($event.target.value, $event.target)">
                    <label>এনআইডি নং<span class="text-red-500">*</span></label>
                    @error('applicants.*.nid')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="floating-label">
                    <input type="text" :name="'applicants[' + index + '][mobile]'" x-model="applicant.mobile" placeholder=" " required pattern="[০-৯0-9]{11}" maxlength="11" @input="formatNumberInput($event.target.value, $event.target)">
                    <label>মোবাইল নং<span class="text-red-500">*</span></label>
                    @error('applicants.*.mobile')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button
                type="button"
                @click="removeApplicant(index)"
                x-show="applicants.length > 1 && index !== 0"
                class="btn-danger absolute top-4 right-4 sm:static sm:mt-4 sm:ml-auto sm:block"
                style="min-width: 40px; min-height: 40px;"
                title="আবেদনকারী মুছুন"
            >×</button>
        </div>
    </template>
    <div class="flex items-center space-x-4 mt-4 sm:space-x-2 xs:space-x-1">
        <button type="button" @click="addApplicant()" class="btn-success w-full sm:w-auto">
            + আবেদনকারী যোগ করুন
        </button>
    </div>
    <style>
    @media (max-width: 768px) {
        .record-card { padding: 0.75rem !important; }
        .form-section { padding: 0.75rem !important; }
        .form-section-title { font-size: 1.1rem; }
        .btn-success, .btn-danger { min-width: 40px; min-height: 40px; font-size: 1rem; }
    }
    @media (max-width: 480px) {
        .record-card { padding: 0.5rem !important; }
        .form-section { padding: 0.5rem !important; }
        .form-section-title { font-size: 1rem; }
        .btn-success, .btn-danger { min-width: 36px; min-height: 36px; font-size: 0.95rem; }
    }
    </style>
</div> 