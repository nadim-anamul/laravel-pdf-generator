<div class="form-section" x-data="ownershipContinuity()">
    <h2 class="form-section-title">
        <span class="section-icon">৪</span>
        মালিকানার ধারাবাহিকতার বর্ণনাঃ
    </h2>

    <!-- Hidden form fields for story sequence -->
            <input type="hidden" name="ownership_details[storySequence]" :value="JSON.stringify(storySequence)">
        <input type="hidden" name="ownership_details[currentStep]" :value="currentStep">
        <input type="hidden" name="ownership_details[completedSteps]" :value="JSON.stringify(completedSteps)">
        <input type="hidden" name="ownership_details[rs_record_disabled]" :value="rs_record_disabled">
        
        <!-- Hidden fields for arrays to ensure data persistence -->
        <input type="hidden" name="ownership_details[sa_owners]" :value="JSON.stringify(sa_owners)">
        <input type="hidden" name="ownership_details[rs_owners]" :value="JSON.stringify(rs_owners)">
        <input type="hidden" name="ownership_details[deed_transfers]" :value="JSON.stringify(deed_transfers)">
        <input type="hidden" name="ownership_details[inheritance_records]" :value="JSON.stringify(inheritance_records)">
        <input type="hidden" name="ownership_details[rs_records]" :value="JSON.stringify(rs_records)">
        
        <!-- Hidden fields for info objects -->
        <input type="hidden" name="ownership_details[sa_info]" :value="JSON.stringify(sa_info)">
        <input type="hidden" name="ownership_details[rs_info]" :value="JSON.stringify(rs_info)">
        <input type="hidden" name="ownership_details[applicant_info]" :value="JSON.stringify(applicant_info)">

    <!-- Enhanced Step Progress Indicator -->
    <div class="mb-8">
        <div class="max-w-4xl mx-auto">
            <!-- Progress Bar Container -->
            <div class="relative">
                <!-- Background Progress Bar -->
                <div class="absolute top-5 left-0 right-0 h-1.5 bg-gray-200 rounded-full"></div>
                
                <!-- Active Progress Bar -->
                <div class="absolute top-5 left-0 h-1.5 bg-gradient-to-r from-blue-500 to-green-500 rounded-full transition-all duration-500 ease-in-out shadow-sm"
                     :style="`width: ${getProgressWidth()}%`"></div>
                
                <!-- Step Indicators -->
                <div class="relative flex justify-between items-center">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 hover:scale-110 relative"
                                 :class="getStepClasses('info')"
                                 @click="goToStep('info')"
                                 :style="getStepClasses('info').includes('cursor-not-allowed') ? 'cursor: not-allowed;' : 'cursor: pointer;'">
                                <span x-text="'১'"></span>
                                
                                <!-- Small Check Icon for Completed Steps -->
                                <svg x-show="completedSteps.includes('info')" class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 text-white rounded-full p-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            

                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold transition-colors duration-200"
                                 :class="currentStep === 'info' ? 'text-blue-500' : completedSteps.includes('info') ? 'text-green-500' : 'text-gray-500'">
                                রেকর্ডের বর্ণনা
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 hover:scale-110 relative"
                                 :class="getStepClasses('transfers')"
                                 @click="goToStep('transfers')"
                                 :style="getStepClasses('transfers').includes('cursor-not-allowed') ? 'cursor: not-allowed;' : 'cursor: pointer;'">
                                <span x-text="'২'"></span>
                                
                                <!-- Small Check Icon for Completed Steps -->
                                <svg x-show="completedSteps.includes('transfers')" class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 text-white rounded-full p-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            

                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold transition-colors duration-200"
                                 :class="currentStep === 'transfers' ? 'text-green-500' : completedSteps.includes('transfers') ? 'text-green-500' : 'text-gray-500'">
                                হস্তান্তর/রেকর্ড
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 hover:scale-110 relative"
                                 :class="getStepClasses('applicant')"
                                 @click="goToStep('applicant')"
                                 :style="getStepClasses('applicant').includes('cursor-not-allowed') ? 'cursor: not-allowed;' : 'cursor: pointer;'">
                                <span x-text="'৩'"></span>
                                
                                <!-- Small Check Icon for Completed Steps -->
                                <svg x-show="completedSteps.includes('applicant')" class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 text-white rounded-full p-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold transition-colors duration-200"
                                 :class="currentStep === 'applicant' ? 'text-blue-500' : completedSteps.includes('applicant') ? 'text-green-500' : 'text-gray-500'">
                                 আবেদনকারীর খারিজ ও খাজনা
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Status -->
            <div class="mt-4 text-center">
                <div class="text-sm font-medium text-gray-700">
                    <span x-text="getCurrentStepText()"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 1: SA/RS Information -->
    <div x-show="currentStep === 'info'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ১: SA/RS রেকর্ডের বর্ণনা</h3>
        
        <!-- SA Flow -->
        <template x-if="acquisition_record_basis === 'SA'">
            <div>
                <h4 class="font-bold mb-4">SA রেকর্ডের তথ্য:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <template x-for="(owner, index) in sa_owners" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'sa_owner_name_' + index" x-model="owner.name" class="form-input flex-1" placeholder="SA মালিকের নাম">
                                <label :for="'sa_owner_name_' + index" class="ml-2">SA মালিকের নাম</label>
                                <button type="button" @click="removeSaOwner(index)" x-show="sa_owners.length > 1" class="btn-danger ml-2" title="মালিক মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addSaOwner()" class="btn-success mt-2">+ SA মালিক যোগ করুন</button>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_plot_no" x-model="sa_info.sa_plot_no" placeholder=" ">
                        <label for="ownership_sa_plot_no">SA দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_khatian_no" x-model="sa_info.sa_khatian_no" placeholder=" ">
                        <label for="ownership_sa_khatian_no">SA খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_total_land_in_plot" x-model="sa_info.sa_total_land_in_plot" placeholder=" " pattern="[০-৯0-9\.]+" @input="formatNumberInput($event.target.value, $event.target)">
                        <label for="ownership_sa_plot_no">SA দাগে মোট জমি (একর)</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_land_in_khatian" x-model="sa_info.sa_land_in_khatian" placeholder=" " pattern="[০-৯0-9\.]+" @input="formatNumberInput($event.target.value, $event.target)">
                        <label for="ownership_sa_land_in_khatian">উক্ত SA খতিয়ানে জমির পরিমাণ (একর)</label>
                    </div>
                </div>
            </div>
        </template>

        <!-- RS Flow -->
        <template x-if="acquisition_record_basis === 'RS'">
            <div>
                <h4 class="font-bold mb-4">RS রেকর্ডের তথ্য:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <template x-for="(owner, index) in rs_owners" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'rs_owner_name_' + index" x-model="owner.name" class="form-input flex-1" placeholder="RS মালিকের নাম">
                                <label :for="'rs_owner_name_' + index" class="ml-2">RS মালিকের নাম</label>
                                <button type="button" @click="removeRsOwner(index)" x-show="rs_owners.length > 1" class="btn-danger ml-2" title="মালিক মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addRsOwner()" class="btn-success mt-2">+ RS মালিক যোগ করুন</button>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_plot_no" x-model="rs_info.rs_plot_no" placeholder=" ">
                        <label for="ownership_rs_plot_no">RS দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_khatian_no" x-model="rs_info.rs_khatian_no" placeholder=" ">
                        <label for="ownership_rs_khatian_no">RS খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_total_land_in_plot" x-model="rs_info.rs_total_land_in_plot" placeholder=" " pattern="[০-৯0-9\.]+" @input="formatNumberInput($event.target.value, $event.target)">
                        <label for="ownership_rs_total_land_in_plot">RS দাগে মোট জমি (একর)</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_land_in_khatian" x-model="rs_info.rs_land_in_khatian" placeholder=" " pattern="[০-৯0-9\.]+" @input="formatNumberInput($event.target.value, $event.target)">
                        <label for="ownership_rs_land_in_khatian">উক্ত দাগে RS খতিয়ানের হিস্যানুযায়ী জমির পরিমাণ (একর)</label>

                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="ownership_rs_dp_khatian">
                            <input type="checkbox" id="ownership_rs_dp_khatian" x-model="rs_info.dp_khatian" class="form-checkbox mr-2">
                            ডিপি খতিয়ান
                        </label>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            <button type="button" @click="nextStep()" class="btn-secondary" :disabled="!isStep1Valid()">
                পরবর্তী ধাপ
            </button>
        </div>
    </div>

    <!-- Step 2: Transfers and Records -->
    <div x-show="currentStep === 'transfers'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ২: হস্তান্তর ও রেকর্ড</h3>


        <!-- Story Sequence Summary -->
        <div class="bg-blue-50 p-6 rounded-lg mb-6">
            <h4 class="font-bold text-lg mb-4 text-blue-800">মালিকানার ধারাবাহিকতার ক্রম</h4>
            <div class="space-y-3">
                <template x-for="(item, index) in storySequence" :key="index">
                    <div class="flex items-center justify-between bg-white p-3 rounded-lg border-l-4 border-blue-500 hover:bg-blue-50 cursor-pointer transition-all duration-200" @click="scrollToStoryItem(item)">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                <span x-text="index + 1"></span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800" x-text="item.type"></div>
                                <div class="text-sm text-gray-600" x-text="item.description"></div>
                            </div>
                        </div>
                        <button type="button" @click.stop="removeStoryItem(index)" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors duration-200" title="মুছুন">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </template>
                <div x-show="storySequence.length === 0" class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>কোন ক্রম যোগ করা হয়নি</p>
                    <p class="text-sm">নিচের বোতামগুলি ব্যবহার করে মালিকানার ধারাবাহিকতার ক্রম তৈরি করুন</p>
                </div>
            </div>
        </div>

        <!-- Deed Transfer Forms -->
        <template x-for="(deed, index) in deed_transfers" :key="'deed_' + index">
            <div class="record-card mb-4">
                <h5 x-text="'দলিল #' + (index + 1)" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Multiple Donors -->
                    <div>
                        <template x-for="(donor, donorIdx) in deed.donor_names" :key="donorIdx">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'deed_donor_name_' + index + '_' + donorIdx" x-model="donor.name" class="form-input flex-1" placeholder="দলিল দাতার নাম">
                                <label :for="'deed_donor_name_' + index + '_' + donorIdx" class="ml-2">দলিল দাতার নাম</label>
                                <button type="button" @click="removeDeedDonor(index, donorIdx)" x-show="deed.donor_names.length > 1" class="btn-danger ml-2" title="দাতার নাম মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addDeedDonor(index)" class="btn-success mt-2">+ দলিল দাতার নাম যোগ করুন</button>
                    </div>
                    <!-- Multiple Recipients -->
                    <div>
                        <template x-for="(recipient, recipientIdx) in deed.recipient_names" :key="recipientIdx">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'deed_recipient_name_' + index + '_' + recipientIdx" x-model="recipient.name" class="form-input flex-1" placeholder="দলিল গ্রহীতার নাম">
                                <label :for="'deed_recipient_name_' + index + '_' + recipientIdx" class="ml-2">দলিল গ্রহীতার নাম</label>
                                <button type="button" @click="removeDeedRecipient(index, recipientIdx)" x-show="deed.recipient_names.length > 1" class="btn-danger ml-2" title="গ্রহীতার নাম মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addDeedRecipient(index)" class="btn-success mt-2">+ দলিল গ্রহীতার নাম যোগ করুন</button>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'deed_number_' + index" x-model="deed.deed_number" placeholder=" ">
                        <label :for="'deed_number_' + index">দলিল নম্বর<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'deed_date_' + index" x-model="deed.deed_date" placeholder="দিন/মাস/বছর">
                        <label :for="'deed_date_' + index">দলিলের তারিখ<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" x-model="deed.sale_type">
                        <label>দলিলের ধরন</label>
                    </div>

                    
                    <!-- Application Area Section -->
                    <div class="form-section md:col-span-2">
                        <label class="font-semibold text-gray-700 mb-2"> আবেদনকৃত দাগে বিক্রয়ের ধরন: <span class="text-red-500">*</span></label>
                        <div class="space-y-4">
                            <!-- Radio button selection -->
                            <div class="mb-4">
                                <div class="radio-group">
                                    <label class="flex items-center mb-2 p-2 rounded" :class="deed.application_type === 'specific' ? 'bg-blue-100 border border-blue-300' : 'bg-gray-50 border border-gray-200'">
                                        <input type="radio" value="specific" x-model="deed.application_type" @change="handleApplicationTypeChange(deed)" class="mr-2">
                                        <span class="font-medium">সুনির্দিষ্ট দাগ</span>
                                    </label>
                                    <label class="flex items-center p-2 rounded" :class="deed.application_type === 'multiple' ? 'bg-green-100 border border-green-300' : 'bg-gray-50 border border-gray-200'">
                                        <input type="radio" value="multiple" x-model="deed.application_type" @change="handleApplicationTypeChange(deed)" class="mr-2">
                                        <span class="font-medium">বিভিন্ন দাগ</span>
                                    </label>
                                </div>
                                <!-- Validation Error Message -->
                                <div x-show="getApplicationAreaValidation(deed).hasError" class="mt-2 text-red-500 text-sm">
                                    <span x-text="getApplicationAreaValidation(deed).message"></span>
                                </div>
                            </div>
                            
                            <!-- Specific Plot Option -->
                            <div x-show="deed.application_type === 'specific'" class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    আবেদনকৃত 
                                    <input type="text" x-model="deed.application_specific_area" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'specific' && !deed.application_specific_area}">
                                    <span class="text-red-500">*</span> দাগে সুনির্দিষ্টভাবে 
                                    <input type="text" x-model="deed.application_sell_area" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'specific' && !deed.application_sell_area}">
                                    <span class="text-red-500">*</span> একর বিক্রয়
                                </label>
                                <div x-show="deed.application_type === 'specific' && (!deed.application_specific_area || !deed.application_sell_area)" class="mt-2 text-red-500 text-sm">
                                    সুনির্দিষ্ট দাগের জন্য সকল তথ্য পূরণ করুন
                                </div>
                            </div>
                            
                            <!-- Multiple Plots Option -->
                            <div x-show="deed.application_type === 'multiple'" class="p-4 border border-green-200 rounded-lg bg-green-50">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    আবেদনকৃত 
                                    <input type="text" x-model="deed.application_other_areas" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'multiple' && !deed.application_other_areas}">
                                    <span class="text-red-500">*</span> দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট 
                                    <input type="text" x-model="deed.application_total_area" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'multiple' && !deed.application_total_area}">
                                    <span class="text-red-500">*</span> একরের কাতে 
                                    <input type="text" x-model="deed.application_sell_area_other" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'multiple' && !deed.application_sell_area_other}">
                                    <span class="text-red-500">*</span> একর বিক্রয়
                                </label>
                                <div x-show="deed.application_type === 'multiple' && (!deed.application_other_areas || !deed.application_total_area || !deed.application_sell_area_other)" class="mt-2 text-red-500 text-sm">
                                    বিভিন্ন দাগের জন্য সকল তথ্য পূরণ করুন
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Possession Section -->
                    <div class="form-section md:col-span-2">
                        <label class="font-semibold text-gray-700 mb-2"> দখলের বর্ণনা:</label>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">i) দলিলের বিবরণ ও হাতনকশায় দখল উল্লেখ রয়েছে কিনা?</label>
                                <div class="radio-group">
                                                                    <label class="flex items-center">
                                    <input type="radio" value="yes" x-model="deed.possession_deed" class="mr-2">
                                    <span>হ্যাঁ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" value="no" x-model="deed.possession_deed" class="mr-2">
                                    <span>না</span>
                                </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ii) আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা?</label>
                                <div class="radio-group">
                                                                    <label class="flex items-center">
                                    <input type="radio" value="yes" x-model="deed.possession_application" class="mr-2">
                                    <span>হ্যাঁ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" value="no" x-model="deed.possession_application" class="mr-2">
                                    <span>না</span>
                                </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    iii) যে সকল দাগে দখল উল্লেখ করা 
                                    <input type="text" x-model="deed.mentioned_areas" class="form-input ml-2" style="width: 250px; display: inline;" placeholder=" ">
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Special Details Section -->
                    <div class="form-section md:col-span-2">
                        <label class="font-semibold text-gray-700 mb-2">প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                        <textarea x-model="deed.special_details" rows="4" class="form-input w-full" placeholder=" "></textarea>
                    </div>
                    
                    <!-- Tax Information Section -->
                    <div class="form-section md:col-span-2">
                        <label class="font-semibold text-gray-700 mb-2">খারিজের তথ্য:</label>
                        <textarea x-model="deed.tax_info" rows="4" class="form-input w-full"></textarea>
                    </div>

                </div>
            </div>
        </template>

        <!-- Inheritance Transfer Forms -->
        <template x-for="(inheritance, index) in inheritance_records" :key="'inheritance_' + index">
            <div class="record-card mb-4">
                <h5 x-text="'ওয়ারিশ #' + (index + 1)" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label">
                        <input type="text" :id="'inheritance_previous_owner_name_' + index" x-model="inheritance.previous_owner_name" placeholder=" ">
                        <label :for="'inheritance_previous_owner_name_' + index">পূর্ববর্তী মালিকের নাম<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'inheritance_death_date_' + index" x-model="inheritance.death_date" placeholder="দিন/মাস/বছর">
                        <label :for="'inheritance_death_date_' + index">মৃত্যুর তারিখ<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <select x-model="inheritance.has_death_cert">
                            <option value="yes">হ্যাঁ</option>
                            <option value="no">না</option>
                        </select>
                        <label>মৃত্যু সনদ আছে কিনা</label>
                    </div>
                    <div class="floating-label md:col-span-2">
                        <textarea rows="3" x-model="inheritance.heirship_certificate_info" placeholder=" "></textarea>
                        <label>ওয়ারিশান সনদের বিবরণ</label>
                    </div>
                </div>
            </div>
        </template>

        <!-- RS Record Form -->
        <template x-for="(rs, index) in rs_records" :key="'rs_' + index">
            <div class="record-card mb-4">
                <h5 x-text="'আরএস রেকর্ড #' + (index + 1)" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <template x-for="(owner, ownerIdx) in rs.owner_names" :key="ownerIdx">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'rs_record_owner_name_' + index + '_' + ownerIdx" x-model="owner.name" class="form-input flex-1" placeholder="আরএস মালিকের নাম">
                                <label :for="'rs_record_owner_name_' + index + '_' + ownerIdx" class="ml-2">আরএস মালিকের নাম</label>
                                <button type="button" @click="removeRsRecordOwner(index, ownerIdx)" x-show="rs.owner_names.length > 1" class="btn-danger ml-2" title="মালিকের নাম মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addRsRecordOwner(index)" class="btn-success mt-2">+ আরএস মালিকের নাম যোগ করুন</button>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'rs_record_plot_no_' + index" x-model="rs.plot_no" placeholder=" ">
                        <label :for="'rs_record_plot_no_' + index">আরএস দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'rs_record_khatian_no_' + index" x-model="rs.khatian_no" placeholder=" ">
                        <label :for="'rs_record_khatian_no_' + index">আরএস খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'rs_record_land_amount_' + index" x-model="rs.land_amount" placeholder=" " 
                               @input="rs.land_amount = $parent.formatNumberInput($event.target.value)"
                               pattern="[০-৯0-9\.]+" title="শুধুমাত্র সংখ্যা এবং দশমিক বিন্দু অনুমোদিত">
                        <label :for="'rs_record_land_amount_' + index">আরএস দাগে জমির পরিমাণ (একর)</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="">
                            <input type="checkbox" :id="'rs_record_dp_khatian_' + index" x-model="rs.dp_khatian" class="form-checkbox mr-2">
                            ডিপি খতিয়ান
                        </label>
                    </div>
                    
                </div>
            </div>
        </template>
        
        <!-- Action Buttons at Bottom -->
        <div class="flex flex-wrap gap-4 mt-6">
            <button type="button" @click="addDeedTransfer()" class="btn-primary">দলিলমূলে হস্তান্তর যোগ করুন</button>
            <button type="button" @click="addInheritanceRecord()" class="btn-primary">ওয়ারিশমূলে হস্তান্তর যোগ করুন</button>
            <button type="button" @click="addRsRecord()" :disabled="rs_record_disabled" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200" :class="{ 'opacity-50 cursor-not-allowed': rs_record_disabled }" x-show="acquisition_record_basis === 'SA'">আরএস রেকর্ড যোগ করুন</button>
            <button type="button" @click="nextStep()" class="btn-success">উপরোক্ত মালিকই আবেদনকারী</button>
        </div>
    </div>

    <!-- Step 3: Applicant Owner Information -->
    <div x-show="currentStep === 'applicant'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ৩: আবেদনকারীর খারিজ ও খাজনা</h3>
        
        <!-- Summary Section -->
        <div class="bg-blue-50 p-6 rounded-lg mb-6">
            <h4 class="font-bold text-lg mb-4 text-blue-800">মালিকানার ধারাবাহিকতার সারসংক্ষেপ</h4>
            
            <!-- SA/RS Info Summary -->
            <div class="mb-4">
                <h5 class="font-semibold text-blue-700 mb-2">১। SA/RS তথ্য:</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div x-show="sa_info.sa_plot_no">
                        <span class="font-medium">SA দাগ নম্বর:</span> <span x-text="sa_info.sa_plot_no"></span>
                    </div>
                    <div x-show="sa_info.sa_khatian_no">
                        <span class="font-medium">SA খতিয়ান নম্বর:</span> <span x-text="sa_info.sa_khatian_no"></span>
                    </div>
                    <div x-show="sa_info.sa_total_land_in_plot">
                        <span class="font-medium">SA দাগে মোট জমি:</span> <span x-text="sa_info.sa_total_land_in_plot"></span>
                    </div>
                    <div x-show="sa_info.sa_land_in_khatian">
                        <span class="font-medium">SA খতিয়ানে জমির পরিমাণ (একর):</span> <span x-text="sa_info.sa_land_in_khatian"></span>
                    </div>
                    <div x-show="rs_info.rs_plot_no">
                        <span class="font-medium">RS দাগ নম্বর:</span> <span x-text="rs_info.rs_plot_no"></span>
                    </div>
                    <div x-show="rs_info.rs_khatian_no">
                        <span class="font-medium">RS খতিয়ান নম্বর:</span> <span x-text="rs_info.rs_khatian_no"></span>
                    </div>
                    <div x-show="rs_info.rs_total_land_in_plot">
                        <span class="font-medium">RS দাগে মোট জমি:</span> <span x-text="rs_info.rs_total_land_in_plot"></span>
                    </div>
                    <div x-show="rs_info.rs_land_in_khatian">
                        <span class="font-medium">RS খতিয়ানে জমির পরিমাণ (একর):</span> <span x-text="rs_info.rs_land_in_khatian"></span>
                    </div>
                </div>
            </div>
            
            <!-- Story Sequence Summary -->
            <div class="mb-4" x-show="storySequence.length > 0">
                <h5 class="font-semibold text-blue-700 mb-2">২। মালিকানার ধারাবাহিকতার ক্রম:</h5>
                <div class="space-y-2">
                    <template x-for="(item, index) in storySequence" :key="index">
                        <div class="bg-white p-3 rounded-lg border-l-4 border-blue-500">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">
                                    <span x-text="index + 1"></span>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800" x-text="item.type"></div>
                                    <div class="text-sm text-gray-600" x-text="item.description"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Applicant Info Summary -->
            <div>
                <h5 class="font-semibold text-blue-700 mb-2">৩। আবেদনকারীর খারিজ ও খাজনা:</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div x-show="applicant_info.applicant_name">
                        <span class="font-medium">আবেদনকারীর নাম:</span> <span x-text="applicant_info.applicant_name"></span>
                    </div>
                    <div x-show="applicant_info.kharij_case_no">
                        <span class="font-medium">খারিজ কেস নম্বর:</span> <span x-text="applicant_info.kharij_case_no"></span>
                    </div>
                    <div x-show="applicant_info.kharij_plot_no">
                        <span class="font-medium">খারিজ দাগ নম্বর:</span> <span x-text="applicant_info.kharij_plot_no"></span>
                    </div>
                    <div x-show="applicant_info.kharij_land_amount">
                        <span class="font-medium">খারিজকৃত জমির পরিমাণ (একর):</span> <span x-text="applicant_info.kharij_land_amount"></span>
                    </div>
                    <div x-show="applicant_info.kharij_date">
                        <span class="font-medium">খারিজের তারিখ:</span> <span x-text="applicant_info.kharij_date"></span>
                    </div>
                    <div x-show="applicant_info.kharij_details" class="md:col-span-2">
                        <span class="font-medium">খারিজের বিস্তারিত বিবরণ:</span> <span x-text="applicant_info.kharij_details"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- উপরোক্ত মালিকই আবেদনকারী Form -->
        <div class="bg-white p-6 rounded-lg border border-gray-200">
            <h4 class="font-bold text-lg mb-4 text-blue-800">উপরোক্ত মালিকই আবেদনকারী</h4>
            <p class="text-gray-600 mb-4">আবেদনকারী যদি উপরোক্ত মালিক হন, তাহলে তার খারিজের তথ্য দিন:</p>
            <h5 class="font-semibold text-blue-700 mb-2">খারিজের তথ্য</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="floating-label">
                    <input type="text" x-model="applicant_info.applicant_name" placeholder=" ">
                    <label>আবেদনকারীর নাম</label>
                </div>
                <div class="floating-label">
                    <input type="text" x-model="applicant_info.kharij_case_no" placeholder=" ">
                    <label>খারিজ কেস নম্বর</label>
                </div>
                <div class="floating-label">
                    <input type="text" x-model="applicant_info.kharij_plot_no" placeholder=" ">
                    <label>খারিজ দাগ নম্বর</label>
                </div>
                <div class="floating-label">
                    <input type="text" x-model="applicant_info.kharij_land_amount" placeholder=" " 
                           @input="applicant_info.kharij_land_amount = formatNumberInput($event.target.value)"
                           pattern="[০-৯0-9\.]+" title="শুধুমাত্র সংখ্যা এবং দশমিক বিন্দু অনুমোদিত">
                    <label>উক্ত দাগে খারিজকৃত জমির পরিমাণ (একর)</label>
                </div>
                                    <div class="floating-label">
                        <input type="text" x-model="applicant_info.kharij_date" placeholder="দিন/মাস/বছর">
                        <label>খারিজের তারিখ</label>
                    </div>
                <div class="floating-label md:col-span-2">
                    <textarea rows="3" x-model="applicant_info.kharij_details" placeholder=" "></textarea>
                    <label>খারিজের বিস্তারিত বিবরণ</label>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="button" @click="prevStep()" class="btn-secondary mr-4"> <- পূর্ববর্তী ধাপ</button>
            <button type="button" @click="saveAllData()" class="btn-success">সব তথ্য সংরক্ষণ করুন</button>
        </div>
    </div>

    <!-- Alert System -->
    <div x-show="alert.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed top-4 right-4 z-50 max-w-sm w-full"
         :class="alert.type === 'success' ? 'bg-green-500' : 'bg-red-500'">
        <div class="flex items-center p-4 text-white">
            <div class="flex-shrink-0">
                <svg x-show="alert.type === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <svg x-show="alert.type === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium" x-text="alert.message"></p>
            </div>
            <div class="ml-auto pl-3">
                <button @click="hideAlert()" class="text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div x-show="currentStep !== 'applicant'" class="mt-6">
        <button type="button" @click="prevStep()" x-show="currentStep !== 'info'" class="btn-secondary mr-4"> <- পূর্ববর্তী ধাপ</button>
        <button type="button" @click="saveStepData()" class="btn-primary">বর্তমান ধাপ সংরক্ষণ করুন</button>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('ownershipContinuity', () => ({
        // Basic data properties
        acquisition_record_basis: 'SA', // Default to SA, can be changed by parent form
        sa_info: {
            sa_plot_no: '',
            sa_khatian_no: '',
            sa_total_land_in_plot: '',
            sa_land_in_khatian: ''
        },
        rs_info: {
            rs_plot_no: '',
            rs_khatian_no: '',
            rs_total_land_in_plot: '',
            rs_land_in_khatian: '',
            dp_khatian: false
        },
        applicant_info: {
            applicant_name: '',
            kharij_case_no: '',
            kharij_plot_no: '',
            kharij_land_amount: '',
            kharij_date: '',
            kharij_details: ''
        },
        
        // Arrays
        sa_owners: [{'name': ''}],
        rs_owners: [{'name': ''}],
        deed_transfers: [],
        inheritance_records: [],
        rs_records: [],
        storySequence: [],
        completedSteps: [],
        currentStep: 'info',
        rs_record_disabled: false,
        
        // Alert system
        alert: {
            show: false,
            type: 'success',
            message: ''
        },
        
        init() {
            // Load existing data if available
            this.loadExistingData();
            
            // Ensure we have at least one item in each array
            if (this.sa_owners.length === 0) this.sa_owners = [{'name': ''}];
            if (this.rs_owners.length === 0) this.rs_owners = [{'name': ''}];
            if (this.deed_transfers.length === 0) this.deed_transfers = [];
            if (this.inheritance_records.length === 0) this.inheritance_records = [];
            if (this.rs_records.length === 0) this.rs_records = [];
            
            // Generate story sequence if empty
            if (this.storySequence.length === 0) {
                this.generateStorySequence();
            }
            
            // Update completed steps
            this.updateCompletedSteps();
            
            // Watch for changes in acquisition_record_basis
            this.watchAcquisitionRecordBasis();
        },
        
        // Simple method to load existing data
        loadExistingData() {
            // Load acquisition_record_basis from parent form
            this.loadAcquisitionRecordBasis();
            
            // Check for old form data (validation errors)
            const oldFormData = window.oldFormData || {};
            if (oldFormData.ownership_details && Object.keys(oldFormData.ownership_details).length > 0) {
                this.loadDataFromOldForm(oldFormData.ownership_details);
                return;
            }
            
            // Check for compensation data from parent form (edit mode)
            const form = this.$el.closest('form');
            if (form) {
                const compensationData = form.dataset.compensation;
                if (compensationData && compensationData !== 'null') {
                    try {
                        const data = JSON.parse(compensationData);
                        if (data.ownership_details) {
                            this.loadDataFromCompensation(data.ownership_details);
                        }
                        // Also load acquisition_record_basis from compensation data
                        if (data.acquisition_record_basis) {
                            this.acquisition_record_basis = data.acquisition_record_basis;
                        }
                    } catch (error) {
                        console.error('Error parsing compensation data:', error);
                    }
                }
            }
        },
        
        // Load acquisition_record_basis from parent form
        loadAcquisitionRecordBasis() {
            // Try to get acquisition_record_basis from the parent form
            const form = this.$el.closest('form');
            if (form) {
                const acquisitionRecordBasisField = form.querySelector('[name="acquisition_record_basis"]');
                if (acquisitionRecordBasisField) {
                    this.acquisition_record_basis = acquisitionRecordBasisField.value || 'SA';
                }
            }
        },
        
        // Watch for changes in acquisition_record_basis field
        watchAcquisitionRecordBasis() {
            const form = this.$el.closest('form');
            if (form) {
                const acquisitionRecordBasisField = form.querySelector('[name="acquisition_record_basis"]');
                if (acquisitionRecordBasisField) {
                    // Listen for change events
                    acquisitionRecordBasisField.addEventListener('change', (e) => {
                        this.acquisition_record_basis = e.target.value;
                        console.log('Acquisition record basis changed to:', this.acquisition_record_basis);
                    });
                    
                    // Also listen for input events for real-time updates
                    acquisitionRecordBasisField.addEventListener('input', (e) => {
                        this.acquisition_record_basis = e.target.value;
                    });
                }
            }
        },
        
        // Load data from old form (validation errors)
        loadDataFromOldForm(data) {
            if (data.sa_info) this.sa_info = { ...this.sa_info, ...data.sa_info };
            if (data.rs_info) this.rs_info = { ...this.rs_info, ...data.rs_info };
            if (data.applicant_info) this.applicant_info = { ...this.applicant_info, ...data.applicant_info };
            if (data.sa_owners) this.sa_owners = [...data.sa_owners];
            if (data.rs_owners) this.rs_owners = [...data.rs_owners];
            if (data.deed_transfers) this.deed_transfers = [...data.deed_transfers];
            if (data.inheritance_records) this.inheritance_records = [...data.inheritance_records];
            if (data.rs_records) this.rs_records = [...data.rs_records];
            if (data.currentStep) this.currentStep = data.currentStep;
            if (data.completedSteps) this.completedSteps = [...data.completedSteps];
            if (data.rs_record_disabled !== undefined) this.rs_record_disabled = data.rs_record_disabled;
            if (data.acquisition_record_basis) this.acquisition_record_basis = data.acquisition_record_basis;
            
            // Always regenerate story sequence from actual data instead of using stored story sequence
            // This ensures the correct information is displayed
            this.generateStorySequence();
            
            // Update completed steps after loading data
            this.updateCompletedSteps();
        },
        
        // Load data from compensation record (edit mode)
        loadDataFromCompensation(data) {
            if (data.sa_info) this.sa_info = { ...this.sa_info, ...data.sa_info };
            if (data.rs_info) this.rs_info = { ...this.rs_info, ...data.rs_info };
            if (data.applicant_info) this.applicant_info = { ...this.applicant_info, ...data.applicant_info };
            if (data.sa_owners) this.sa_owners = [...data.sa_owners];
            if (data.rs_owners) this.rs_owners = [...data.rs_owners];
            if (data.deed_transfers) this.deed_transfers = [...data.deed_transfers];
            if (data.inheritance_records) this.inheritance_records = [...data.inheritance_records];
            if (data.rs_records) this.rs_records = [...data.rs_records];
            if (data.currentStep) this.currentStep = data.currentStep;
            if (data.completedSteps) this.completedSteps = [...data.completedSteps];
            if (data.rs_record_disabled !== undefined) this.rs_record_disabled = data.rs_record_disabled;
            if (data.acquisition_record_basis) this.acquisition_record_basis = data.acquisition_record_basis;
            
            // Always regenerate story sequence from actual data instead of using stored story sequence
            // This ensures the correct information is displayed
            this.generateStorySequence();
            
            // Update completed steps after loading data
            this.updateCompletedSteps();
        },
        
        // Generate story sequence from existing data
        generateStorySequence() {
            this.storySequence = [];
            
            // Add deed transfers
            this.deed_transfers.forEach((deed, index) => {
                // Helper function to check if a value is meaningful
                const hasValue = (value) => value && value.toString().trim() !== '';
                
                const deedNumber = hasValue(deed.deed_number) ? deed.deed_number : 'অনির্ধারিত';
                const deedDate = hasValue(deed.deed_date) ? deed.deed_date : 'অনির্ধারিত';
                
                this.storySequence.push({
                    type: 'দলিলমূলে মালিকানা হস্তান্তর',
                    description: `দলিল নম্বর: ${deedNumber}, তারিখ: ${deedDate}`,
                    itemType: 'deed',
                    itemIndex: index,
                    sequenceIndex: index
                });
            });
            
            // Add inheritance records
            this.inheritance_records.forEach((inheritance, index) => {
                const hasValue = (value) => value && value.toString().trim() !== '';
                const previousOwner = hasValue(inheritance.previous_owner_name) ? inheritance.previous_owner_name : 'অনির্ধারিত';
                
                this.storySequence.push({
                    type: 'ওয়ারিশমূলে হস্তান্তর',
                    description: `পূর্ববর্তী মালিক: ${previousOwner}`,
                    itemType: 'inheritance',
                    itemIndex: index,
                    sequenceIndex: this.storySequence.length
                });
            });
            
            // Add RS records
            this.rs_records.forEach((rs, index) => {
                const hasValue = (value) => value && value.toString().trim() !== '';
                const plotNo = hasValue(rs.plot_no) ? rs.plot_no : 'অনির্ধারিত';
                
                this.storySequence.push({
                    type: 'আরএস রেকর্ড যোগ',
                    description: `দাগ নম্বর: ${plotNo}`,
                    itemType: 'rs',
                    itemIndex: index,
                    sequenceIndex: this.storySequence.length
                });
            });
        },
        
        // Simple method to update story sequence
        updateStorySequence() {
            this.generateStorySequence();
            this.updateCompletedSteps();
        },
        
        // Add new deed transfer
        addDeedTransfer() {
            this.deed_transfers.push({
                donor_names: [{'name': ''}],
                recipient_names: [{'name': ''}],
                deed_number: '',
                deed_date: '',
                sale_type: '',
                application_type: 'specific',
                application_specific_area: '',
                application_sell_area: '',
                application_other_areas: '',
                application_total_area: '',
                application_sell_area_other: '',
                possession_deed: 'yes',
                possession_application: 'yes',
                mentioned_areas: '',
                special_details: '',
                tax_info: ''
            });
            this.updateStorySequence();
        },
        
        // Remove deed transfer
        removeDeedTransfer(index) {
            this.deed_transfers.splice(index, 1);
            this.updateStorySequence();
        },
        
        // Add new inheritance record
        addInheritanceRecord() {
            this.inheritance_records.push({
                previous_owner_name: '',
                death_date: '',
                has_death_cert: 'yes',
                heirship_certificate_info: ''
            });
            this.updateStorySequence();
        },
        
        // Remove inheritance record
        removeInheritanceRecord(index) {
            this.inheritance_records.splice(index, 1);
            this.updateStorySequence();
        },
        
        // Add new RS record
        addRsRecord() {
            this.rs_records.push({
                owner_names: [{'name': ''}],
                plot_no: '',
                khatian_no: '',
                land_amount: '',
                dp_khatian: false
            });
            this.updateStorySequence();
        },
        
        // Remove RS record
        removeRsRecord(index) {
            this.rs_records.splice(index, 1);
            this.updateStorySequence();
        },
        
        // Add owner to arrays
        addOwner(array, index) {
            if (!array[index]) array[index] = [];
            array[index].push({'name': ''});
        },
        
        // Remove owner from arrays
        removeOwner(array, arrayIndex, ownerIndex) {
            if (array[arrayIndex] && array[arrayIndex].length > 1) {
                array[arrayIndex].splice(ownerIndex, 1);
            }
        },
        
        // Handle application type change
        handleApplicationTypeChange(deed) {
            if (deed.application_type === 'specific') {
                deed.application_other_areas = '';
                deed.application_total_area = '';
                deed.application_sell_area_other = '';
            }
        },
        
        // Validate application area fields
        validateApplicationAreaFields(deed) {
            if (deed.application_type === 'specific') {
                const specific = parseFloat(deed.application_specific_area) || 0;
                const sell = parseFloat(deed.application_sell_area) || 0;
                
                if (specific > 0 && sell > 0) {
                    deed.application_total_area = (specific + sell).toFixed(2);
                }
            }
        },
        
        // Get application area validation status
        getApplicationAreaValidation(deed) {
            if (!deed.application_type) {
                return { hasError: false, message: '' };
            }
            
            if (deed.application_type === 'specific') {
                if (!deed.application_specific_area || !deed.application_sell_area) {
                    return { 
                        hasError: true, 
                        message: 'সুনির্দিষ্ট দাগ এবং বিক্রয়কৃত জমির পরিমাণ প্রয়োজন' 
                    };
                }
            } else if (deed.application_type === 'multiple') {
                if (!deed.application_other_areas || !deed.application_total_area || !deed.application_sell_area_other) {
                    return { 
                        hasError: true, 
                        message: 'বিভিন্ন দাগ, মোট জমির পরিমাণ এবং বিক্রয়কৃত জমির পরিমাণ প্রয়োজন' 
                    };
                }
            }
            
            return { hasError: false, message: '' };
        },
        
        // Check if step is valid
        isStepValid(step) {
            switch (step) {
                case 'info':
                    return this.sa_info.sa_plot_no || this.rs_info.rs_plot_no;
                case 'transfers':
                    return this.deed_transfers.length > 0 || this.inheritance_records.length > 0 || this.rs_records.length > 0;
                case 'applicant':
                    return this.applicant_info.applicant_name || this.applicant_info.kharij_case_no;
                default:
                    return false;
            }
        },
        
        // Get step status
        getStepStatus(step) {
            if (this.currentStep === step) return 'current';
            if (this.isStepValid(step)) return 'completed';
            return 'pending';
        },
        
        // Navigate to step
        goToStep(step) {
            if (this.isStepValid(step) || step === 'info') {
                this.currentStep = step;
            }
        },
        
        // Get progress width for progress bar
        getProgressWidth() {
            const totalSteps = 3;
            const completedCount = this.completedSteps.length;
            return (completedCount / totalSteps) * 100;
        },
        
        // Get step classes for styling
        getStepClasses(step) {
            if (this.currentStep === step) {
                return 'bg-blue-500 text-white shadow-lg scale-110';
            } else if (this.isStepValid(step)) {
                return 'bg-green-500 text-white shadow-md cursor-pointer';
            } else {
                return 'bg-gray-300 text-gray-600 cursor-not-allowed';
            }
        },
        
        // Update completed steps based on current data
        updateCompletedSteps() {
            this.completedSteps = [];
            if (this.isStepValid('info')) this.completedSteps.push('info');
            if (this.isStepValid('transfers')) this.completedSteps.push('transfers');
            if (this.isStepValid('applicant')) this.completedSteps.push('applicant');
        },
        
        // Add SA owner
        addSaOwner() {
            this.sa_owners.push({'name': ''});
        },
        
        // Remove SA owner
        removeSaOwner(index) {
            if (this.sa_owners.length > 1) {
                this.sa_owners.splice(index, 1);
            }
        },
        
        // Add RS owner
        addRsOwner() {
            this.rs_owners.push({'name': ''});
        },
        
        // Remove RS owner
        removeRsOwner(index) {
            if (this.rs_owners.length > 1) {
                this.rs_owners.splice(index, 1);
            }
        },
        
        // Add deed donor
        addDeedDonor(deedIndex) {
            this.deed_transfers[deedIndex].donor_names.push({'name': ''});
        },
        
        // Remove deed donor
        removeDeedDonor(deedIndex, donorIndex) {
            if (this.deed_transfers[deedIndex].donor_names.length > 1) {
                this.deed_transfers[deedIndex].donor_names.splice(donorIndex, 1);
            }
        },
        
        // Add deed recipient
        addDeedRecipient(deedIndex) {
            this.deed_transfers[deedIndex].recipient_names.push({'name': ''});
        },
        
        // Remove deed recipient
        removeDeedRecipient(deedIndex, recipientIndex) {
            if (this.deed_transfers[deedIndex].recipient_names.length > 1) {
                this.deed_transfers[deedIndex].recipient_names.splice(recipientIndex, 1);
            }
        },
        
        // Add RS record owner
        addRsRecordOwner(rsIndex) {
            this.rs_records[rsIndex].owner_names.push({'name': ''});
        },
        
        // Remove RS record owner
        removeRsRecordOwner(rsIndex, ownerIndex) {
            if (this.rs_records[rsIndex].owner_names.length > 1) {
                this.rs_records[rsIndex].owner_names.splice(ownerIndex, 1);
            }
        },
        
        // Remove story item
        removeStoryItem(index) {
            const item = this.storySequence[index];
            
            if (item) {
                // Remove from the corresponding data array based on item type
                if (item.itemType === 'deed' && typeof item.itemIndex === 'number') {
                    // Remove deed transfer
                    if (this.deed_transfers[item.itemIndex]) {
                        this.deed_transfers.splice(item.itemIndex, 1);
                        console.log(`Removed deed transfer at index ${item.itemIndex}`);
                    }
                } else if (item.itemType === 'inheritance' && typeof item.itemIndex === 'number') {
                    // Remove inheritance record
                    if (this.inheritance_records[item.itemIndex]) {
                        this.inheritance_records.splice(item.itemIndex, 1);
                        console.log(`Removed inheritance record at index ${item.itemIndex}`);
                    }
                } else if (item.itemType === 'rs' && typeof item.itemIndex === 'number') {
                    // Remove RS record
                    if (this.rs_records[item.itemIndex]) {
                        this.rs_records.splice(item.itemIndex, 1);
                        console.log(`Removed RS record at index ${item.itemIndex}`);
                    }
                }
                
                // Remove from story sequence
                this.storySequence.splice(index, 1);
                
                // Regenerate story sequence to update indices
                this.generateStorySequence();
                
                // Update completed steps
                this.updateCompletedSteps();
                
                console.log('Story item removed and data arrays updated');
            }
        },
        
        // Scroll to story item
        scrollToStoryItem(item) {
            // Implementation for scrolling to specific form sections
            console.log('Scrolling to:', item);
        },
        
        // Navigation methods
        nextStep() {
            if (this.currentStep === 'info' && this.isStep1Valid()) {
                this.currentStep = 'transfers';
            } else if (this.currentStep === 'transfers') {
                this.currentStep = 'applicant';
            }
            this.updateCompletedSteps();
        },
        
        prevStep() {
            if (this.currentStep === 'applicant') {
                this.currentStep = 'transfers';
            } else if (this.currentStep === 'transfers') {
                this.currentStep = 'info';
            }
        },
        
        // Step validation
        isStep1Valid() {
            return this.isStepValid('info');
        },
        
        // Get current step text
        getCurrentStepText() {
            const stepTexts = {
                'info': 'ধাপ ১: SA/RS রেকর্ডের বর্ণনা',
                'transfers': 'ধাপ ২: হস্তান্তর ও রেকর্ড',
                'applicant': 'ধাপ ৩: আবেদনকারীর খারিজ ও খাজনা'
            };
            return stepTexts[this.currentStep] || '';
        },
        
        // Save step data
        saveStepData() {
            // Save current step data to localStorage or send to server
            localStorage.setItem('ownershipContinuityData', JSON.stringify({
                sa_info: this.sa_info,
                rs_info: this.rs_info,
                applicant_info: this.applicant_info,
                sa_owners: this.sa_owners,
                rs_owners: this.rs_owners,
                deed_transfers: this.deed_transfers,
                inheritance_records: this.inheritance_records,
                rs_records: this.rs_records,
                storySequence: this.storySequence,
                currentStep: this.currentStep,
                completedSteps: this.completedSteps,
                rs_record_disabled: this.rs_record_disabled
            }));
            
            this.showAlert('success', 'বর্তমান ধাপের তথ্য সংরক্ষণ করা হয়েছে');
        },
        
        // Save all data
        saveAllData() {
            // Save all data to localStorage or send to server
            localStorage.setItem('ownershipContinuityData', JSON.stringify({
                sa_info: this.sa_info,
                rs_info: this.rs_info,
                applicant_info: this.applicant_info,
                sa_owners: this.sa_owners,
                rs_owners: this.rs_owners,
                deed_transfers: this.deed_transfers,
                inheritance_records: this.inheritance_records,
                rs_records: this.rs_records,
                storySequence: this.storySequence,
                currentStep: this.currentStep,
                completedSteps: this.completedSteps,
                rs_record_disabled: this.rs_record_disabled
            }));
            
            this.showAlert('success', 'সব তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
        },
        
        // Alert system
        showAlert(type, message) {
            this.alert = { type, message, show: true };
            setTimeout(() => this.hideAlert(), 5000);
        },
        
        hideAlert() {
            this.alert.show = false;
        }
    }));
});
</script>

<style>
@media (max-width: 1024px) {
    .form-section { padding: 1rem !important; }
}
@media (max-width: 768px) {
    .form-section { padding: 0.75rem !important; }
    .form-section-title { font-size: 1.1rem; }
    .record-card, .sub-section { padding: 0.75rem !important; }
    .btn-success, .btn-danger { min-width: 40px; min-height: 40px; font-size: 1rem; }
    .stepper-bar, .stepper-bar-bg { height: 2px !important; }
    .stepper-step { width: 32px !important; height: 32px !important; font-size: 1rem !important; }
}
@media (max-width: 480px) {
    .form-section { padding: 0.5rem !important; }
    .form-section-title { font-size: 1rem; }
    .record-card, .sub-section { padding: 0.5rem !important; }
    .btn-success, .btn-danger { min-width: 36px; min-height: 36px; font-size: 0.95rem; }
    .stepper-step { width: 28px !important; height: 28px !important; font-size: 0.95rem !important; }
}
</style>