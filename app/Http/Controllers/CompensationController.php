<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compensation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\BengaliDateTrait;
use Spatie\Browsershot\Browsershot;
use App\Services\PdfGeneratorService;

class CompensationController extends Controller
{
    use BengaliDateTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $search = $request->get('search');
        
        $compensations = Compensation::query()
            ->notDeleted() // Only show non-deleted compensations
            ->byStatus($status)
            ->when($search, function($query) use ($search) {
                return $query->search($search);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return view('compensation_list', compact('compensations', 'status', 'search'));
    }

    /**
     * Display the compensation register page.
     */
    public function register(Request $request)
    {
        // For register view we load all records and rely on client-side pagination/print via DataTables
        $compensations = Compensation::query()
            ->orderBy('id', 'desc')
            ->get();

        return view('compensation_register', compact('compensations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('compensation_form');
    }

    /**
     * Display the specified resource.
     */
    public function preview($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation_preview', compact('compensation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation_form', compact('compensation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateCompensationData($request);
        $validatedData = $this->processCompensationData($validatedData);
        
        // Add audit tracking
        $validatedData['created_by'] = Auth::id();
        $validatedData['updated_by'] = Auth::id();
        
        $compensation = Compensation::create($validatedData);

        return redirect()->route('compensation.preview', $compensation->id)
            ->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে জমা দেওয়া হয়েছে।');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $compensation = Compensation::findOrFail($id);
        
        // Debug: Log the received data
        Log::info('Compensation update request data:', [
            'id' => $id,
            'ownership_details' => $request->input('ownership_details'),
            'storySequence' => $request->input('ownership_details.storySequence'),
            'storySequence_type' => gettype($request->input('ownership_details.storySequence')),
            'storySequence_raw' => $request->input('ownership_details.storySequence')
        ]);
        
        $validatedData = $this->validateCompensationData($request);
        $validatedData = $this->processCompensationData($validatedData);
        
        // Add audit tracking
        $validatedData['updated_by'] = Auth::id();
        
        // Debug: Log the processed data
        Log::info('Processed compensation data:', [
            'ownership_details' => $validatedData['ownership_details'] ?? null,
            'storySequence' => $validatedData['ownership_details']['storySequence'] ?? null,
            'storySequence_type' => isset($validatedData['ownership_details']['storySequence']) ? gettype($validatedData['ownership_details']['storySequence']) : 'not_set'
        ]);

        // Ensure story sequence exists and is not empty
        if (isset($validatedData['ownership_details']) && 
            (!isset($validatedData['ownership_details']['storySequence']) || 
             empty($validatedData['ownership_details']['storySequence']))) {
            
            Log::info('Story sequence is missing or empty, regenerating from existing data...');
            $validatedData['ownership_details']['storySequence'] = $this->regenerateStorySequence($validatedData['ownership_details']);
            
            Log::info('Regenerated story sequence:', [
                'storySequence' => $validatedData['ownership_details']['storySequence']
            ]);
        }

        $compensation->update($validatedData);
        
        // Debug: Log the saved data
        $compensation->refresh();
        Log::info('Saved compensation data:', [
            'ownership_details' => $compensation->ownership_details,
            'storySequence' => $compensation->ownership_details['storySequence'] ?? null,
            'storySequence_type' => isset($compensation->ownership_details['storySequence']) ? gettype($compensation->ownership_details['storySequence']) : 'not_set'
        ]);

        return redirect()->route('compensation.preview', $compensation->id)
            ->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Soft delete the specified compensation (Super Admin only)
     */
    public function destroy(Request $request, $id)
    {
        // Check if user is super admin
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই। শুধুমাত্র সুপার অ্যাডমিন এই কাজটি করতে পারেন।');
        }

        $compensation = Compensation::findOrFail($id);
        
        // Validate deletion reason
        $request->validate([
            'deletion_reason' => 'required|string|max:500',
        ], [
            'deletion_reason.required' => 'ডিলিট করার কারণ প্রয়োজন',
            'deletion_reason.max' => 'কারণ ৫০০ অক্ষরের বেশি হতে পারে না',
        ]);

        // Store case number for success message (before deletion)
        $caseNumber = $compensation->case_number;
        
        // Soft delete with audit trail
        $compensation->softDelete($request->deletion_reason, Auth::id());

        return redirect()->route('compensation.index')
            ->with('success', "ক্ষতিপূরণ কেস #{$caseNumber} সফলভাবে ডিলিট করা হয়েছে।");
    }

    /**
     * Restore a soft deleted compensation (Super Admin only)
     */
    public function restore($id)
    {
        // Check if user is super admin
        if (!Auth::user()->is_super_user) {
            abort(403, 'অনুমতি নেই। শুধুমাত্র সুপার অ্যাডমিন এই কাজটি করতে পারেন।');
        }

        $compensation = Compensation::onlyDeleted()->findOrFail($id);
        $compensation->restore();

        return redirect()->route('compensation.index')
            ->with('success', "ক্ষতিপূরণ কেস #{$compensation->case_number} সফলভাবে পুনরুদ্ধার করা হয়েছে।");
    }

    /**
     * Get kanungo opinion for a compensation record
     */
    public function getKanungoOpinion($id)
    {
        $compensation = Compensation::findOrFail($id);
        
        return response()->json([
            'kanungo_opinion' => $compensation->kanungo_opinion
        ]);
    }

    /**
     * Update kanungo opinion for a compensation record
     */
    public function updateKanungoOpinion(Request $request, $id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            
            $validatedData = $request->validate([
                'kanungo_opinion' => 'required|array',
                'kanungo_opinion.has_ownership_continuity' => 'required|in:yes,no',
                'kanungo_opinion.opinion_details' => 'nullable|string',
            ]);
            
            $compensation->update([
                'kanungo_opinion' => $validatedData['kanungo_opinion']
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'কানুনগো/সার্ভেয়ারের মতামত সফলভাবে আপডেট করা হয়েছে।'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Kanungo opinion update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'কিছু সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order data for a compensation record
     */
    public function getOrder($id)
    {
        $compensation = Compensation::findOrFail($id);
        return response()->json([
            'order_signature_date' => $compensation->order_signature_date_bengali,
            'signing_officer_name' => $compensation->signing_officer_name
        ]);
    }

    /**
     * Update order data for a compensation record
     */
    public function updateOrder(Request $request, $id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            
            $validatedData = $request->validate([
                'order_signature_date' => 'required|string',
                'signing_officer_name' => 'required|string|max:255',
                'order_comment' => 'nullable|string',
            ]);
            
            // Process Bengali dates before saving
            $validatedData = $this->processBengaliDates($validatedData);
            
            // Validate the converted date
            if (!$validatedData['order_signature_date']) {
                return response()->json([
                    'success' => false,
                    'message' => 'কিছু সমস্যা হয়েছে: The order signature date field must be a valid date.'
                ], 422);
            }
            
            try {
                \Carbon\Carbon::parse($validatedData['order_signature_date']);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'কিছু সমস্যা হয়েছে: The order signature date field must be a valid date.'
                ], 422);
            }
            
            // Update only the order fields
            $compensation->update([
                'order_signature_date' => $validatedData['order_signature_date'],
                'signing_officer_name' => $validatedData['signing_officer_name'],
                'order_comment' => $validatedData['order_comment'],
                'status' => 'done'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'আদেশ সফলভাবে নিষ্পত্তিকৃত হয়েছে।'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Order update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'কিছু সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate compensation data
     */
    private function validateCompensationData(Request $request)
    {
        return $request->validate([
            // Basic Information
            'case_number' => 'required|string|max:255',
            'case_date' => 'required|string|max:255',
            'sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            
            // Applicants
            'applicants' => 'required|array|min:1',
            'applicants.*.name' => 'required|string|max:255',
            'applicants.*.father_name' => 'required|string|max:255',
            'applicants.*.address' => 'required|string|max:255',
            'applicants.*.nid' => 'required|string|max:20',
            'applicants.*.mobile' => 'required|string|max:15',
            
            // Award Information
            'la_case_no' => 'required|string|max:255',
            'award_type' => 'required|array|min:1',
            'award_type.*' => 'required|string|in:জমি,গাছপালা/ফসল,অবকাঠামো',
            'land_award_serial_no' => 'required_if:award_type.*,জমি|nullable|string|max:255',
            'tree_award_serial_no' => 'required_if:award_type.*,গাছপালা/ফসল|nullable|string|max:255',
            'infrastructure_award_serial_no' => 'required_if:award_type.*,অবকাঠামো|nullable|string|max:255',
            'acquisition_record_basis' => 'required|string|in:SA,RS',
            'plot_no' => 'required|string|max:255',
            'award_holder_names' => 'required|array|min:1',
            'award_holder_names.*.name' => 'required|string|max:255',
            'award_holder_names.*.father_name' => 'required|string|max:255',
            'award_holder_names.*.address' => 'required|string|max:255',
            
            // Land Category
            'land_category' => 'nullable|array',
            'land_category.*.category_name' => 'required|string|max:255',
            'land_category.*.total_land' => 'required|string|max:255',
            'land_category.*.total_compensation' => 'required|string|max:255',
            'land_category.*.applicant_land' => 'nullable|string|max:255',
            
            // Additional Information
            'objector_details' => 'nullable|string',
            'is_applicant_in_award' => 'required|boolean',
            'source_tax_percentage' => 'required|string|max:255',
            'tree_compensation' => 'nullable|string|max:255',
            'infrastructure_compensation' => 'nullable|string|max:255',
            'district' => 'required|string|max:255',
            'upazila' => 'required|string|max:255',
            'mouza_name' => 'required|string|max:255',
            'jl_no' => 'required|string|max:255',
            
            // Land Schedule
            'land_schedule_sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'land_schedule_rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'sa_khatian_no' => 'nullable|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            
            // Ownership Details (simplified validation)
            'ownership_details' => 'nullable|array',
            
            // Tax Information
            'tax_info' => 'nullable|array',
            'tax_info.paid_in_name' => 'nullable|string|max:255',
            'tax_info.english_year' => 'nullable|string|max:255',
            'tax_info.bangla_year' => 'nullable|string|max:255',
            'tax_info.holding_no' => 'nullable|string|max:255',
            'tax_info.paid_land_amount' => 'nullable|string|max:255',
            
            // Ownership Details Tax Info - removed to prevent stripping of other fields
            // 'ownership_details.deed_transfers.*.tax_info' => 'nullable|string',
            
            // Additional Documents
            'additional_documents_info' => 'nullable|array',
            'additional_documents_info.selected_types' => 'nullable|array',
            'additional_documents_info.details' => 'nullable|array',
            'additional_documents_info.details.*' => 'nullable|string',
            
            // Case Information
            'case_information' => 'nullable|string',
            
            // General Comments
            'general_comments' => 'nullable|string',
        ]);
    }

    /**
     * Process compensation data before saving
     */
    private function processCompensationData(array $data)
    {
        // Process Bengali dates
        $data = $this->processBengaliDates($data);
        
        // Process Bengali numbers - convert to English for calculations
        $data = $this->processBengaliNumbers($data);

        // Convert award_type string to array for database storage
        if (isset($data['award_type'])) {
            // Ensure award_type is always an array
            if (!is_array($data['award_type'])) {
                $data['award_type'] = [$data['award_type']];
            }
            // Filter out empty values
            $data['award_type'] = array_filter($data['award_type']);
        }

        // Process ownership details if present
        if (isset($data['ownership_details'])) {
            $data['ownership_details'] = $this->processOwnershipDetails($data['ownership_details']);
        }

        // Process additional documents validation
        if (isset($data['additional_documents_info']['selected_types']) && 
            !empty($data['additional_documents_info']['selected_types'])) {
            $this->validateAdditionalDocuments($data['additional_documents_info']);
        }

                return $data;
    }
    
    /**
     * Process Bengali numbers - convert to English for calculations
     */
    private function processBengaliNumbers(array $data)
    {
        // Process basic case information
        if (isset($data['case_number'])) {
            $data['case_number'] = $this->enDigits($data['case_number']);
        }
        if (isset($data['case_date'])) {
            $data['case_date'] = $this->enDigits($data['case_date']);
        }
        if (isset($data['la_case_no'])) {
            $data['la_case_no'] = $this->enDigits($data['la_case_no']);
        }
        if (isset($data['plot_no'])) {
            $data['plot_no'] = $this->enDigits($data['plot_no']);
        }
        if (isset($data['sa_plot_no'])) {
            $data['sa_plot_no'] = $this->enDigits($data['sa_plot_no']);
        }
        if (isset($data['rs_plot_no'])) {
            $data['rs_plot_no'] = $this->enDigits($data['rs_plot_no']);
        }
        if (isset($data['land_award_serial_no'])) {
            $data['land_award_serial_no'] = $this->enDigits($data['land_award_serial_no']);
        }
        if (isset($data['tree_award_serial_no'])) {
            $data['tree_award_serial_no'] = $this->enDigits($data['tree_award_serial_no']);
        }
        if (isset($data['infrastructure_award_serial_no'])) {
            $data['infrastructure_award_serial_no'] = $this->enDigits($data['infrastructure_award_serial_no']);
        }
        if (isset($data['district'])) {
            $data['district'] = $this->enDigits($data['district']);
        }
        if (isset($data['upazila'])) {
            $data['upazila'] = $this->enDigits($data['upazila']);
        }
        if (isset($data['jl_no'])) {
            $data['jl_no'] = $this->enDigits($data['jl_no']);
        }
        if (isset($data['sa_khatian_no'])) {
            $data['sa_khatian_no'] = $this->enDigits($data['sa_khatian_no']);
        }
        if (isset($data['rs_khatian_no'])) {
            $data['rs_khatian_no'] = $this->enDigits($data['rs_khatian_no']);
        }
        if (isset($data['land_schedule_sa_plot_no'])) {
            $data['land_schedule_sa_plot_no'] = $this->enDigits($data['land_schedule_sa_plot_no']);
        }
        if (isset($data['land_schedule_rs_plot_no'])) {
            $data['land_schedule_rs_plot_no'] = $this->enDigits($data['land_schedule_rs_plot_no']);
        }
        
        // Process applicants
        if (isset($data['applicants']) && is_array($data['applicants'])) {
            foreach ($data['applicants'] as &$applicant) {
                if (isset($applicant['nid'])) {
                    $applicant['nid'] = $this->enDigits($applicant['nid']);
                }
                if (isset($applicant['mobile'])) {
                    $applicant['mobile'] = $this->enDigits($applicant['mobile']);
                }
            }
        }
        
        // Process land category numbers
        if (isset($data['land_category']) && is_array($data['land_category'])) {
            foreach ($data['land_category'] as &$category) {
                if (isset($category['total_land'])) {
                    $category['total_land'] = $this->enDigits($category['total_land']);
                }
                if (isset($category['total_compensation'])) {
                    $category['total_compensation'] = $this->enDigits($category['total_compensation']);
                }
                if (isset($category['applicant_land'])) {
                    $category['applicant_land'] = $this->enDigits($category['applicant_land']);
                }
            }
        }
        
        // Process compensation amounts
        if (isset($data['tree_compensation'])) {
            $data['tree_compensation'] = $this->enDigits($data['tree_compensation']);
        }
        if (isset($data['infrastructure_compensation'])) {
            $data['infrastructure_compensation'] = $this->enDigits($data['infrastructure_compensation']);
        }
        if (isset($data['source_tax_percentage'])) {
            $data['source_tax_percentage'] = $this->enDigits($data['source_tax_percentage']);
        }
        
        // Process ownership details numbers
        if (isset($data['ownership_details']) && is_array($data['ownership_details'])) {
            // Process SA info
            if (isset($data['ownership_details']['sa_info']) && is_array($data['ownership_details']['sa_info'])) {
                if (isset($data['ownership_details']['sa_info']['sa_plot_no'])) {
                    $data['ownership_details']['sa_info']['sa_plot_no'] = $this->enDigits($data['ownership_details']['sa_info']['sa_plot_no']);
                }
                if (isset($data['ownership_details']['sa_info']['sa_khatian_no'])) {
                    $data['ownership_details']['sa_info']['sa_khatian_no'] = $this->enDigits($data['ownership_details']['sa_info']['sa_khatian_no']);
                }
                if (isset($data['ownership_details']['sa_info']['sa_total_land_in_plot'])) {
                    $data['ownership_details']['sa_info']['sa_total_land_in_plot'] = $this->enDigits($data['ownership_details']['sa_info']['sa_total_land_in_plot']);
                }
                if (isset($data['ownership_details']['sa_info']['sa_land_in_khatian'])) {
                    $data['ownership_details']['sa_info']['sa_land_in_khatian'] = $this->enDigits($data['ownership_details']['sa_info']['sa_land_in_khatian']);
                }
            }
            
            // Process RS info
            if (isset($data['ownership_details']['rs_info']) && is_array($data['ownership_details']['rs_info'])) {
                if (isset($data['ownership_details']['rs_info']['rs_plot_no'])) {
                    $data['ownership_details']['rs_info']['rs_plot_no'] = $this->enDigits($data['ownership_details']['rs_info']['rs_plot_no']);
                }
                if (isset($data['ownership_details']['rs_info']['rs_khatian_no'])) {
                    $data['ownership_details']['rs_info']['rs_khatian_no'] = $this->enDigits($data['ownership_details']['rs_info']['rs_khatian_no']);
                }
                if (isset($data['ownership_details']['rs_info']['rs_total_land_in_plot'])) {
                    $data['ownership_details']['rs_info']['rs_total_land_in_plot'] = $this->enDigits($data['ownership_details']['rs_info']['rs_total_land_in_plot']);
                }
                if (isset($data['ownership_details']['rs_info']['rs_land_in_khatian'])) {
                    $data['ownership_details']['rs_info']['rs_land_in_khatian'] = $this->enDigits($data['ownership_details']['rs_info']['rs_land_in_khatian']);
                }
            }
            
            // Process deed transfers
            if (isset($data['ownership_details']['deed_transfers']) && is_array($data['ownership_details']['deed_transfers'])) {
                foreach ($data['ownership_details']['deed_transfers'] as &$deed) {
                    if (isset($deed['deed_number'])) {
                        $deed['deed_number'] = $this->enDigits($deed['deed_number']);
                    }
                    if (isset($deed['deed_date'])) {
                        $deed['deed_date'] = $this->enDigits($deed['deed_date']);
                    }
                    if (isset($deed['application_sell_area'])) {
                        $deed['application_sell_area'] = $this->enDigits($deed['application_sell_area']);
                    }
                    if (isset($deed['application_total_area'])) {
                        $deed['application_total_area'] = $this->enDigits($deed['application_total_area']);
                    }
                    if (isset($deed['application_sell_area_other'])) {
                        $deed['application_sell_area_other'] = $this->enDigits($deed['application_sell_area_other']);
                    }
                }
            }
            
            // Process RS records
            if (isset($data['ownership_details']['rs_records']) && is_array($data['ownership_details']['rs_records'])) {
                foreach ($data['ownership_details']['rs_records'] as &$rs) {
                    if (isset($rs['plot_no'])) {
                        $rs['plot_no'] = $this->enDigits($rs['plot_no']);
                    }
                    if (isset($rs['khatian_no'])) {
                        $rs['khatian_no'] = $this->enDigits($rs['khatian_no']);
                    }
                    if (isset($rs['land_amount'])) {
                        $rs['land_amount'] = $this->enDigits($rs['land_amount']);
                    }
                    if (isset($rs['total_land_in_plot'])) {
                        $rs['total_land_in_plot'] = $this->enDigits($rs['total_land_in_plot']);
                    }
                    if (isset($rs['land_in_khatian'])) {
                        $rs['land_in_khatian'] = $this->enDigits($rs['land_in_khatian']);
                    }
                }
            }
            
            // Process applicant info
            if (isset($data['ownership_details']['applicant_info']['kharij_land_amount'])) {
                $data['ownership_details']['applicant_info']['kharij_land_amount'] = 
                    $this->enDigits($data['ownership_details']['applicant_info']['kharij_land_amount']);
            }
            
            // Process inheritance records
            if (isset($data['ownership_details']['inheritance_records']) && is_array($data['ownership_details']['inheritance_records'])) {
                foreach ($data['ownership_details']['inheritance_records'] as &$inheritance) {
                    if (isset($inheritance['land_amount'])) {
                        $inheritance['land_amount'] = $this->enDigits($inheritance['land_amount']);
                    }
                    if (isset($inheritance['total_land_in_plot'])) {
                        $inheritance['total_land_in_plot'] = $this->enDigits($inheritance['total_land_in_plot']);
                    }
                    if (isset($inheritance['land_in_khatian'])) {
                        $inheritance['land_in_khatian'] = $this->enDigits($inheritance['land_in_khatian']);
                    }
                }
            }
        }
        
        // Process tax info numbers
        if (isset($data['tax_info']) && is_array($data['tax_info'])) {
            if (isset($data['tax_info']['paid_in_name'])) {
                // paid_in_name is a name field, no number conversion needed
            }
            if (isset($data['tax_info']['holding_no'])) {
                $data['tax_info']['holding_no'] = $this->enDigits($data['tax_info']['holding_no']);
            }
            if (isset($data['tax_info']['paid_land_amount'])) {
                $data['tax_info']['paid_land_amount'] = $this->enDigits($data['tax_info']['paid_land_amount']);
            }
        }
        
        // Process mutation info numbers
        if (isset($data['mutation_info']) && is_array($data['mutation_info'])) {
            foreach ($data['mutation_info'] as &$mutation) {
                if (isset($mutation['land_amount'])) {
                    $mutation['land_amount'] = $this->enDigits($mutation['land_amount']);
                }
                if (isset($mutation['total_land_in_plot'])) {
                    $mutation['total_land_in_plot'] = $this->enDigits($mutation['total_land_in_plot']);
                }
                if (isset($mutation['land_in_khatian'])) {
                    $mutation['land_in_khatian'] = $this->enDigits($mutation['land_in_khatian']);
                }
            }
        }
        
        // Process final order numbers
        if (isset($data['final_order']) && is_array($data['final_order'])) {
            if (isset($data['final_order']['trees_crops']['amount'])) {
                $data['final_order']['trees_crops']['amount'] = $this->enDigits($data['final_order']['trees_crops']['amount']);
            }
            if (isset($data['final_order']['infrastructure']['amount'])) {
                $data['final_order']['infrastructure']['amount'] = $this->enDigits($data['final_order']['infrastructure']['amount']);
            }
        }
        
        // Process kanungo opinion numbers
        if (isset($data['kanungo_opinion']) && is_array($data['kanungo_opinion'])) {
            foreach ($data['kanungo_opinion'] as &$opinion) {
                if (isset($opinion['land_amount'])) {
                    $opinion['land_amount'] = $this->enDigits($opinion['land_amount']);
                }
                if (isset($opinion['total_land_in_plot'])) {
                    $opinion['total_land_in_plot'] = $this->enDigits($opinion['total_land_in_plot']);
                }
                if (isset($opinion['land_in_khatian'])) {
                    $opinion['land_in_khatian'] = $this->enDigits($opinion['land_in_khatian']);
                }
            }
        }
        
        return $data;
    }
    
    /**
     * Process ownership details
     */
    private function processOwnershipDetails(array $ownershipDetails)
    {
        // Debug: Log the incoming ownership details
        Log::info('Processing ownership details:', [
            'storySequence' => $ownershipDetails['storySequence'] ?? null,
            'storySequence_type' => isset($ownershipDetails['storySequence']) ? gettype($ownershipDetails['storySequence']) : 'not_set',
            'all_keys' => array_keys($ownershipDetails),
            'raw_ownership_details' => $ownershipDetails
        ]);
        
        // Process story sequence if it's a JSON string
        if (isset($ownershipDetails['storySequence']) && is_string($ownershipDetails['storySequence'])) {
            Log::info('Processing storySequence string:', [
                'value' => $ownershipDetails['storySequence'],
                'length' => strlen($ownershipDetails['storySequence'])
            ]);
            
            $storySequence = json_decode($ownershipDetails['storySequence'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['storySequence'] = $storySequence;
                Log::info('StorySequence JSON decoded successfully:', [
                    'decoded' => $storySequence,
                    'count' => count($storySequence)
                ]);
            } else {
                Log::error('StorySequence JSON decode failed:', [
                    'error' => json_last_error_msg(),
                    'raw_value' => $ownershipDetails['storySequence']
                ]);
                $ownershipDetails['storySequence'] = [];
            }
        } else {
            Log::info('StorySequence is not a string or not set:', [
                'value' => $ownershipDetails['storySequence'] ?? null,
                'type' => isset($ownershipDetails['storySequence']) ? gettype($ownershipDetails['storySequence']) : 'not_set'
            ]);
            
            // Try to find storySequence in the raw data
            Log::info('Searching for storySequence in raw data...');
            foreach ($ownershipDetails as $key => $value) {
                if (strpos($key, 'storySequence') !== false) {
                    Log::info("Found storySequence-like key: {$key} = " . (is_string($value) ? $value : json_encode($value)));
                }
            }
        }
        
        // Process completed steps if it's a JSON string
        if (isset($ownershipDetails['completedSteps']) && is_string($ownershipDetails['completedSteps'])) {
            $completedSteps = json_decode($ownershipDetails['completedSteps'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['completedSteps'] = $completedSteps;
            } else {
                $ownershipDetails['completedSteps'] = [];
            }
        }
        
        // Process deed_transfers if it's a JSON string
        if (isset($ownershipDetails['deed_transfers']) && is_string($ownershipDetails['deed_transfers'])) {
            $deedTransfers = json_decode($ownershipDetails['deed_transfers'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['deed_transfers'] = $deedTransfers;
                Log::info('Deed transfers JSON decoded successfully:', ['count' => count($deedTransfers)]);
            } else {
                Log::error('Deed transfers JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['deed_transfers'] = [];
            }
        }
        
        // Process inheritance_records if it's a JSON string
        if (isset($ownershipDetails['inheritance_records']) && is_string($ownershipDetails['inheritance_records'])) {
            $inheritanceRecords = json_decode($ownershipDetails['inheritance_records'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['inheritance_records'] = $inheritanceRecords;
                Log::info('Inheritance records JSON decoded successfully:', ['count' => count($inheritanceRecords)]);
            } else {
                Log::error('Inheritance records JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['inheritance_records'] = [];
            }
        }
        
        // Process rs_records if it's a JSON string
        if (isset($ownershipDetails['rs_records']) && is_string($ownershipDetails['rs_records'])) {
            $rsRecords = json_decode($ownershipDetails['rs_records'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['rs_records'] = $rsRecords;
                Log::info('RS records JSON decoded successfully:', ['count' => count($rsRecords)]);
            } else {
                Log::error('RS records JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['rs_records'] = [];
            }
        }
        
        // Process sa_owners if it's a JSON string
        if (isset($ownershipDetails['sa_owners']) && is_string($ownershipDetails['sa_owners'])) {
            $saOwners = json_decode($ownershipDetails['sa_owners'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['sa_owners'] = $saOwners;
                Log::info('SA owners JSON decoded successfully:', ['count' => count($saOwners)]);
            } else {
                Log::error('SA owners JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['sa_owners'] = [];
            }
        }
        
        // Process rs_owners if it's a JSON string
        if (isset($ownershipDetails['rs_owners']) && is_string($ownershipDetails['rs_owners'])) {
            $rsOwners = json_decode($ownershipDetails['rs_owners'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['rs_owners'] = $rsOwners;
                Log::info('RS owners JSON decoded successfully:', ['count' => count($rsOwners)]);
            } else {
                Log::error('RS owners JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['rs_owners'] = [];
            }
        }
        
        // Process sa_info if it's a JSON string
        if (isset($ownershipDetails['sa_info']) && is_string($ownershipDetails['sa_info'])) {
            $saInfo = json_decode($ownershipDetails['sa_info'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['sa_info'] = $saInfo;
                Log::info('SA info JSON decoded successfully');
            } else {
                Log::error('SA info JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['sa_info'] = [];
            }
        }
        
        // Process rs_info if it's a JSON string
        if (isset($ownershipDetails['rs_info']) && is_string($ownershipDetails['rs_info'])) {
            $rsInfo = json_decode($ownershipDetails['rs_info'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['rs_info'] = $rsInfo;
                Log::info('RS info JSON decoded successfully');
            } else {
                Log::error('RS info JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['rs_info'] = [];
            }
        }
        
        // Process applicant_info if it's a JSON string
        if (isset($ownershipDetails['applicant_info']) && is_string($ownershipDetails['applicant_info'])) {
            $applicantInfo = json_decode($ownershipDetails['applicant_info'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['applicant_info'] = $applicantInfo;
                Log::info('Applicant info JSON decoded successfully');
            } else {
                Log::error('Applicant info JSON decode failed:', ['error' => json_last_error_msg()]);
                $ownershipDetails['applicant_info'] = [];
            }
        }
        
        // Convert rs_record_disabled to boolean
        if (isset($ownershipDetails['rs_record_disabled'])) {
            $ownershipDetails['rs_record_disabled'] = in_array($ownershipDetails['rs_record_disabled'], ['on', '1', 'true'], true);
        }
        
        // Now process checkbox values after all JSON fields have been decoded
        
        // Convert checkbox values to boolean for rs_records
        if (isset($ownershipDetails['rs_records']) && is_array($ownershipDetails['rs_records'])) {
            foreach ($ownershipDetails['rs_records'] as &$rsRecord) {
                if (isset($rsRecord['dp_khatian'])) {
                    $rsRecord['dp_khatian'] = in_array($rsRecord['dp_khatian'], ['on', '1', 'true'], true);
                }
            }
        }
        
        // Convert rs_info dp_khatian checkbox value to boolean
        if (isset($ownershipDetails['rs_info']) && isset($ownershipDetails['rs_info']['dp_khatian'])) {
            $ownershipDetails['rs_info']['dp_khatian'] = in_array($ownershipDetails['rs_info']['dp_khatian'], ['on', '1', 'true'], true);
        }

        // Debug: Log the processed ownership details
        Log::info('Processed ownership details:', [
            'storySequence' => $ownershipDetails['storySequence'] ?? null,
            'storySequence_type' => isset($ownershipDetails['storySequence']) ? gettype($ownershipDetails['storySequence']) : 'not_set'
        ]);

        return $ownershipDetails;
    }

    /**
     * Regenerate story sequence from existing ownership details data
     */
    private function regenerateStorySequence(array $ownershipDetails): array
    {
        $storySequence = [];
        $sequenceIndex = 0;

        // Generate story sequence from deed transfers
        if (isset($ownershipDetails['deed_transfers']) && is_array($ownershipDetails['deed_transfers'])) {
            foreach ($ownershipDetails['deed_transfers'] as $index => $deed) {
                $storySequence[] = [
                    'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                    'description' => 'দলিল নম্বর: ' . ($deed['deed_number'] ?? 'N/A'),
                    'itemType' => 'deed',
                    'itemIndex' => $index,
                    'sequenceIndex' => $sequenceIndex++
                ];
            }
        }

        // Generate story sequence from inheritance records
        if (isset($ownershipDetails['inheritance_records']) && is_array($ownershipDetails['inheritance_records'])) {
            foreach ($ownershipDetails['inheritance_records'] as $index => $inheritance) {
                $storySequence[] = [
                    'type' => 'ওয়ারিশমূলে হস্তান্তর',
                    'description' => 'পূর্ববর্তী মালিক: ' . ($inheritance['previous_owner_name'] ?? 'N/A'),
                    'itemType' => 'inheritance',
                    'itemIndex' => $index,
                    'sequenceIndex' => $sequenceIndex++
                ];
            }
        }

        // Generate story sequence from RS records
        if (isset($ownershipDetails['rs_records']) && is_array($ownershipDetails['rs_records'])) {
            foreach ($ownershipDetails['rs_records'] as $index => $rsRecord) {
                $storySequence[] = [
                    'type' => 'আরএস রেকর্ড যোগ',
                    'description' => 'দাগ নম্বর: ' . ($rsRecord['plot_no'] ?? 'N/A'),
                    'itemType' => 'rs',
                    'itemIndex' => $index,
                    'sequenceIndex' => $sequenceIndex++
                ];
            }
        }

        Log::info('Regenerated story sequence with ' . count($storySequence) . ' items');
        return $storySequence;
    }

    /**
     * Validate additional documents
     */
    private function validateAdditionalDocuments(array $additionalDocumentsInfo)
    {
        foreach ($additionalDocumentsInfo['selected_types'] as $type) {
            if (empty($additionalDocumentsInfo['details'][$type] ?? null)) {
                Validator::make([], [])->after(function ($validator) use ($type) {
                    $validator->errors()->add('additional_documents_info.details.' . $type, __('The :type details field is required.', ['type' => $type]));
                })->validate();
            }
        }
    }

    /**
     * Present compensation case
     */
    public function present($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation.present', compact('compensation'));
    }

    /**
     * Preview presentation with actual data
     */
    public function presentPreview($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation.present_preview', compact('compensation'));
    }

    /**
     * Generate PDF for presentation using Browsershot
     */
    public function generatePresentPdf($id)
    {
        // Increase execution time limit for PDF generation
        set_time_limit(120); // 2 minutes
        ini_set('memory_limit', '256M'); // Increase memory limit
        
        $compensation = Compensation::findOrFail($id);
        
        try {
            // Generate PDF directly from HTML content for better performance
            $html = view('pdf.present_pdf', compact('compensation'))->render();
            
            $pdf = PdfGeneratorService::generateFromHtml($html, [
                'timeout' => 120,
                'margins' => [10, 10, 10, 10],
                'showBackground' => true,
                'waitUntilNetworkIdle' => true
            ]);
                
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Presentation PDF generation error: ' . $e->getMessage());
            
            // Fallback: Return HTML view instead of PDF
            return view('compensation.present_preview', compact('compensation'))
                ->with('error', 'PDF তৈরি করতে সমস্যা হয়েছে। HTML ভার্সন দেখানো হচ্ছে।');
        }

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="presentation_'.$compensation->id.'.pdf"',
        ]);
    }

    /**
     * Preview notice with actual data
     */
    public function noticePreview($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation.notice_preview', compact('compensation'));
    }

    /**
     * Generate PDF for notice using Browsershot
     */
    public function generateNoticePdf($id)
    {
        // Increase execution time limit for PDF generation
        set_time_limit(120); // 2 minutes
        ini_set('memory_limit', '256M'); // Increase memory limit
        
        $compensation = Compensation::findOrFail($id);
        
        try {
            // Generate PDF directly from HTML content for better performance
            $html = view('pdf.notice_pdf', compact('compensation'))->render();
            
            $pdf = PdfGeneratorService::generateFromHtml($html, [
                'timeout' => 120,
                'margins' => [10, 10, 10, 10],
                'showBackground' => true,
                'waitUntilNetworkIdle' => true
            ]);
                
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notice PDF generation error: ' . $e->getMessage());
            
            // Fallback: Return HTML view instead of PDF
            return view('compensation.notice_preview', compact('compensation'))
                ->with('error', 'PDF তৈরি করতে সমস্যা হয়েছে। HTML ভার্সন দেখানো হচ্ছে।');
        }

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="notice_'.$compensation->id.'.pdf"',
        ]);
    }

    /**
     * Generate PDF for final order using Browsershot
     */
    public function generateFinalOrderPdf($id)
    {
        // Increase execution time limit for PDF generation
        set_time_limit(120);
        ini_set('memory_limit', '256M');

        $compensation = Compensation::findOrFail($id);

        try {
            // Render the dedicated PDF view for final order
            $html = view('pdf.final_order_pdf', compact('compensation'))->render();

            $pdf = PdfGeneratorService::generateFromHtml($html, [
                'timeout' => 120,
                'margins' => [10, 10, 10, 10],
                'showBackground' => true,
                'waitUntilNetworkIdle' => true
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Final Order PDF generation error: ' . $e->getMessage());

            // Fallback: show HTML preview if PDF generation fails
            return view('compensation.final_order_preview', compact('compensation'))
                ->with('error', 'PDF তৈরি করতে সমস্যা হয়েছে। HTML ভার্সন দেখানো হচ্ছে।');
        }

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="final_order_'.$compensation->id.'.pdf"',
        ]);
    }

    /**
     * Print application and document analysis
     */
    public function analysis($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation.analysis', compact('compensation'));
    }

    /**
     * Store presentation data
     */
    public function storePresent(Request $request, $id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            
            $validatedData = $request->validate([
                'presentation_date' => 'required|string|max:255',
                'presentation_time' => 'required|string|max:255',
                'presentation_venue' => 'required|string|max:255',
                'presenting_officer' => 'required|string|max:255',
                'presentation_details' => 'nullable|string',
                'special_notes' => 'nullable|string',
            ]);
            
            // Store presentation data (you can add a presentations table later)
            // For now, we'll just redirect with success message
            return redirect()->route('compensation.present', $id)
                ->with('success', 'উপস্থাপনার তথ্য সফলভাবে সংরক্ষিত হয়েছে।');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'কিছু সমস্যা হয়েছে: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate PDF for analysis
     */
    public function analysisPdf($id)
    {
        $compensation = Compensation::findOrFail($id);
        // For now, redirect to analysis page
        // You can implement PDF generation later
        return redirect()->route('compensation.analysis', $id)
            ->with('info', 'PDF ডাউনলোড ফিচার শীঘ্রই যোগ করা হবে।');
    }

    /**
     * Generate PDF for compensation preview
     */
    public function generatePreviewPdf($id)
    {
        // Increase execution time limit for PDF generation
        set_time_limit(120); // 2 minutes
        ini_set('memory_limit', '256M'); // Increase memory limit
        
        $compensation = Compensation::findOrFail($id);
        
        try {
            // Generate PDF directly from HTML content for better performance
            $html = view('pdf.compensation_preview_pdf', compact('compensation'))->render();
            
            $pdf = PdfGeneratorService::generateFromHtml($html, [
                'timeout' => 120,
                'margins' => [10, 10, 10, 10],
                'showBackground' => true,
                'waitUntilNetworkIdle' => true
            ]);
                
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Compensation Preview PDF generation error: ' . $e->getMessage());
            
            // Fallback: Return HTML view instead of PDF
            return view('compensation_preview', compact('compensation'))
                ->with('error', 'PDF তৈরি করতে সমস্যা হয়েছে। HTML ভার্সন দেখানো হচ্ছে।');
        }

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="compensation_preview_'.$compensation->id.'.pdf"',
        ]);
    }

    /**
     * Generate Excel for analysis
     */
    public function analysisExcel($id)
    {
        $compensation = Compensation::findOrFail($id);
        // For now, redirect to analysis page
        // You can implement Excel generation later
        return redirect()->route('compensation.analysis', $id)
            ->with('info', 'এক্সেল ডাউনলোড ফিচার শীঘ্রই যোগ করা হবে।');
    }

    /**
     * Get final order data
     */
    public function getFinalOrder($id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'final_order' => $compensation->final_order
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Get final order error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'কিছু সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update final order data
     */
    public function updateFinalOrder(Request $request, $id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            
            // Debug: Log what we're receiving
            \Illuminate\Support\Facades\Log::info('Final order request data:', [
                'all_data' => $request->all(),
                'final_order_raw' => $request->input('final_order'),
                'final_order_type' => gettype($request->input('final_order')),
                'content_type' => $request->header('Content-Type')
            ]);
            
            // Get the final_order data - it might be sent as JSON string
            $finalOrderData = $request->input('final_order');
            
            // If it's a JSON string, decode it
            if (is_string($finalOrderData)) {
                $decoded = json_decode($finalOrderData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON data: ' . json_last_error_msg());
                }
                $finalOrderData = $decoded;
                \Illuminate\Support\Facades\Log::info('Decoded final order data:', [
                    'decoded' => $finalOrderData,
                    'decoded_type' => gettype($finalOrderData)
                ]);
            }
            
            // Validate the decoded data
            if (!is_array($finalOrderData)) {
                throw new \Exception('Final order data must be an array');
            }
            
            // Process the final order data
            $finalOrder = $finalOrderData;
            
            // Clean up empty records for land
            if (isset($finalOrder['land']['records']) && is_array($finalOrder['land']['records'])) {
                $finalOrder['land']['records'] = array_filter($finalOrder['land']['records'], function($record) {
                    return !empty($record['plot_no']) || !empty($record['area']);
                });
            }

            \Illuminate\Support\Facades\Log::info('About to update database with final order:', [
                'final_order_data' => $finalOrder,
                'compensation_id' => $id
            ]);

            // Update the compensation record
            $result = $compensation->update([
                'final_order' => $finalOrder
            ]);
            
            \Illuminate\Support\Facades\Log::info('Database update result:', [
                'update_result' => $result,
                'compensation_id' => $id
            ]);
            
            // Verify the update
            $compensation->refresh();
            \Illuminate\Support\Facades\Log::info('After update verification:', [
                'final_order_after_update' => $compensation->final_order,
                'compensation_id' => $id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'চূড়ান্ত আদেশ সফলভাবে সংরক্ষিত হয়েছে।'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Final order update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'কিছু সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show final order preview page
     */
    public function finalOrderPreview($id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            return view('compensation.final_order_preview', compact('compensation'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Final order preview error: ' . $e->getMessage());
            return redirect()->route('compensation.preview', $id)
                ->with('error', 'চূড়ান্ত আদেশ প্রিভিউ দেখানো সম্ভব নয়: ' . $e->getMessage());
        }
    }
}