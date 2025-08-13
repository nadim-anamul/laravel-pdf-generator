<script defer>
    document.addEventListener('alpine:init', () => {
        window.compensationForm = () => ({
            applicants: [],
            is_sa_owner: 'yes',
            is_rs_owner: 'yes',
            ownership_type: 'deed',
            is_heir_applicant: 'yes',
            deed_transfers: [],
            inheritance_details: {},

            distribution_records: [],
            no_claim_type: 'donor',
            field_investigation_info: '',
            submitted_docs: [],
            inheritance_records: [],
            acquisition_record_basis: '',
            selected_doc_types: [],
            additional_documents_details: {},
            award_type: [],
            award_holder_names: [{ name: '', father_name: '', address: '' }],
            land_category: [{ 
                category_name: '', 
                total_land: '', 
                total_compensation: '', 
                applicant_land: '' 
            }],
            sa_owners: [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }],
            rs_owners: [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }],
            
            init() {
                // Get compensation data from data attribute if editing
                const compensationData = this.$el.dataset.compensation;
                // Helper to get old() values from window if available
                const old = window.oldFormData || {};
                
                // Check if old data has meaningful content
                const hasOldData = old.applicants && old.applicants.length > 0 && old.applicants[0].name;
                const hasCompensationData = compensationData && compensationData !== 'null';
                
                if (hasOldData) {
                    // Handle validation errors - use old form data
                    this.applicants = old.applicants || [{ name: '', father_name: '', address: '', nid: '', mobile: '' }];
                    this.is_sa_owner = old.ownership_details?.is_applicant_sa_owner || 'yes';
                    this.is_rs_owner = old.ownership_details?.is_applicant_rs_owner || 'yes';
                    this.sa_owners = old.ownership_details?.sa_owners || [{ name: '' }];
                    this.rs_owners = old.ownership_details?.rs_owners || [{ name: '' }];
                    this.ownership_type = old.ownership_details?.ownership_type || 'deed';
                    this.deed_transfers = old.ownership_details?.deed_transfers || [{ 
                        donor_name: '', recipient_name: '', deed_number: '', deed_date: '', 
                        sale_type: '', plot_no: '', sold_land_amount: '', total_sotangsho: '', 
                        total_shotok: '', possession_mentioned: 'yes', possession_plot_no: '', 
                        possession_description: '', mutation_case_no: '', mutation_plot_no: '', 
                        mutation_land_amount: '' 
                    }];
                    this.inheritance_records = old.ownership_details?.inheritance_records || [{
                        is_heir_applicant: 'yes',
                        has_death_cert: 'yes',
                        heirship_certificate_info: '',
                        previous_owner_name: '',
                        death_date: '',
                    }];

                    this.distribution_records = old.additional_documents_info?.distribution_records || [];
                    this.no_claim_type = old.additional_documents_info?.no_claim_type || 'donor';
                    this.field_investigation_info = old.additional_documents_info?.field_investigation_info || '';
                    this.submitted_docs = old.additional_documents_info?.submitted_docs || [];
                    this.acquisition_record_basis = old.acquisition_record_basis || '';
                    this.selected_doc_types = old.additional_documents_info?.selected_types || [];
                    this.additional_documents_details = old.additional_documents_info?.details || {};
                    this.award_type = Array.isArray(old.award_type) ? old.award_type : [''];
                    this.award_holder_names = old.award_holder_names || [{ name: '', father_name: '', address: '' }];
                    this.land_category = old.land_category || [{ 
                        category_name: '', 
                        total_land: '', 
                        total_compensation: '', 
                        applicant_land: '' 
                    }];
                } else if (hasCompensationData) {
                    // Handle edit mode - use compensation data
                    const data = JSON.parse(compensationData);
                    
                    this.applicants = data.applicants || [{ name: '', father_name: '', address: '', nid: '', mobile: '' }];
                    this.is_sa_owner = data.is_applicant_sa_owner ? 'yes' : 'no';
                    this.is_rs_owner = data.ownership_details?.is_applicant_rs_owner ?? 'yes';
                    this.sa_owners = data.ownership_details?.sa_owners || [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }];
                    this.rs_owners = data.ownership_details?.rs_owners || [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }];
                    this.ownership_type = data.ownership_details?.ownership_type || 'deed';
                    this.deed_transfers = data.ownership_details?.deed_transfers || [{ 
                        donor_name: '', recipient_name: '', deed_number: '', deed_date: '', 
                        sale_type: '', plot_no: '', sold_land_amount: '', total_sotangsho: '', 
                        total_shotok: '', possession_mentioned: 'yes', possession_plot_no: '', 
                        possession_description: '', mutation_case_no: '', mutation_plot_no: '', 
                        mutation_land_amount: '' 
                    }];
                    this.inheritance_records = data.ownership_details?.inheritance_records || [{
                        is_heir_applicant: 'yes',
                        has_death_cert: 'yes',
                        heirship_certificate_info: '',
                        previous_owner_name: '',
                        death_date: '',
                    }];

                    this.distribution_records = data.additional_documents_info?.distribution_records || [];
                    this.no_claim_type = data.additional_documents_info?.no_claim_type || 'donor';
                    this.field_investigation_info = data.additional_documents_info?.field_investigation_info || '';
                    this.submitted_docs = data.additional_documents_info?.submitted_docs || [];
                    this.acquisition_record_basis = data.acquisition_record_basis || '';
                    this.selected_doc_types = (data.additional_documents_info?.selected_types) || [];
                    this.additional_documents_details = (data.additional_documents_info?.details) || {};
                    this.award_type = Array.isArray(data.award_type) ? data.award_type : [''];
                    this.award_holder_names = data.award_holder_names || [{ name: '', father_name: '', address: '' }];
                    this.land_category = data.land_category || [{ 
                        category_name: '', 
                        total_land: '', 
                        total_compensation: '', 
                        applicant_land: '' 
                    }];
                } else {
                    // Handle new form - use default values
                    this.applicants = [{ name: '', father_name: '', address: '', nid: '', mobile: '' }];
                    this.sa_owners = [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }];
                    this.rs_owners = [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }];
                    this.deed_transfers = [{ 
                        donor_name: '', recipient_name: '', deed_number: '', deed_date: '', 
                        sale_type: '', plot_no: '', sold_land_amount: '', total_sotangsho: '', 
                        total_shotok: '', possession_mentioned: 'yes', possession_plot_no: '', 
                        possession_description: '', mutation_case_no: '', mutation_plot_no: '', 
                        mutation_land_amount: '' 
                    }];
                    this.inheritance_records = [{
                        is_heir_applicant: 'yes',
                        has_death_cert: 'yes',
                        heirship_certificate_info: '',
                        previous_owner_name: '',
                        death_date: '',
                    }];

                    this.distribution_records = [{ details: '' }];
                    this.inheritance_details = {
                        is_heir_applicant: 'yes',
                        has_death_cert: 'yes',
                        heirship_certificate_info: ''
                    };
                    this.acquisition_record_basis = (document.querySelector('[name=acquisition_record_basis]')?.value) || '';
                    this.selected_doc_types = (Array.from(document.querySelectorAll('[name="additional_documents_info[selected_types][]"]:checked')).map(e => e.value)) || [];
                    this.additional_documents_details = {};
                    (Array.from(document.querySelectorAll('[name^="additional_documents_info[details]"]'))).forEach(el => {
                        const match = el.name.match(/additional_documents_info\[details\]\[(.*)\]/);
                        if (match) {
                            this.additional_documents_details[match[1]] = el.value;
                        }
                    });
                    this.sa_owners = [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }];
                    this.rs_owners = [{ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' }];
                    this.is_sa_owner = (document.querySelector('[name="ownership_details[is_applicant_sa_owner]"]:checked')?.value) || 'yes';
                    this.is_rs_owner = (document.querySelector('[name="ownership_details[is_applicant_rs_owner]"]:checked')?.value) || 'yes';
                    this.award_type = [''];
                    this.award_holder_names = [{ name: '', father_name: '', address: '' }];
                    this.land_category = [{ 
                        category_name: '', 
                        total_land: '', 
                        total_compensation: '', 
                        applicant_land: '' 
                    }];
                }
                
                // Force reactivity update after initialization
                this.$nextTick(() => {
                    // Trigger a dummy update to force Alpine.js to re-evaluate conditionals
                    const currentAwardType = this.award_type;
                    this.award_type = [''];
                    this.$nextTick(() => {
                        this.award_type = currentAwardType;
                    });
                });
            },
            
            addApplicant() {
                this.applicants.push({ name: '', father_name: '', address: '', nid: '', mobile: '' });
            },
            removeApplicant(index) {
                this.applicants.splice(index, 1);
            },
            addDeedTransfer() {
                this.deed_transfers.push({ 
                    donor_name: '', recipient_name: '', deed_number: '', deed_date: '', 
                    sale_type: '', plot_no: '', sold_land_amount: '', total_sotangsho: '', 
                    total_shotok: '', possession_mentioned: 'yes', possession_plot_no: '', 
                    possession_description: '', mutation_case_no: '', mutation_plot_no: '', 
                    mutation_land_amount: '' 
                });
            },
            removeDeedTransfer(index) {
                this.deed_transfers.splice(index, 1);
            },
            addInheritanceRecord() {
                this.inheritance_records.push({
                    is_heir_applicant: 'yes',
                    has_death_cert: 'yes',
                    heirship_certificate_info: '',
                    previous_owner_name: '',
                    death_date: '',
                });
            },
            removeInheritanceRecord(index) {
                this.inheritance_records.splice(index, 1);
            },

            addDistributionRecord() {
                this.distribution_records.push({ details: '' });
            },
            removeDistributionRecord(index) {
                this.distribution_records.splice(index, 1);
            },
            addSaOwner() {
                this.sa_owners.push({ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' });
            },
            removeSaOwner(index) {
                this.sa_owners.splice(index, 1);
            },
            addRsOwner() {
                this.rs_owners.push({ name: '', plot_no: '', previous_owner_name: '', khatian_no: '', total_land_in_plot: '', land_in_khatian: '' });
            },
            removeRsOwner(index) {
                this.rs_owners.splice(index, 1);
            },
            addLandCategory() {
                this.land_category.push({ 
                    category_name: '', 
                    total_land: '', 
                    total_compensation: '', 
                    applicant_land: '' 
                });
            },
            removeLandCategory(index) {
                this.land_category.splice(index, 1);
            },
            
            // Number validation function for Bengali/English numerals
            validateNumberInput(value) {
                if (!value) return true;
                // Allow Bengali numerals (০-৯), English numerals (0-9), and decimal point
                const pattern = /^[০-৯0-9\.]+$/;
                return pattern.test(value);
            },
            
            // Convert input to valid number format
            formatNumberInput(value) {
                if (!value) return '';
                // Remove any invalid characters
                return value.replace(/[^০-৯0-9\.]/g, '');
            }
        });
    });
</script> 