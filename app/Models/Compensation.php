<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BengaliDateTrait;

class Compensation extends Model
{
    use HasFactory, BengaliDateTrait;

    protected $table = 'compensations';

    protected $fillable = [
        'case_number', 'case_date', 'sa_plot_no', 'rs_plot_no',
        'applicants', 'la_case_no', 'award_type',
        'land_award_serial_no', 'tree_award_serial_no', 'infrastructure_award_serial_no',
        'acquisition_record_basis', 'plot_no', 'award_holder_names',
        'objector_details', 'is_applicant_in_award', 
        'source_tax_percentage', 'tree_compensation',
        'infrastructure_compensation',
        'land_category', 'district', 'upazila', 'mouza_name', 'jl_no', 'sa_khatian_no', 
        'land_schedule_sa_plot_no', 'rs_khatian_no', 'land_schedule_rs_plot_no', 
        'ownership_details', 'mutation_info', 'tax_info', 
        'additional_documents_info', 'kanungo_opinion',
        'order_signature_date', 'signing_officer_name', 'order_comment', 'case_information', 'general_comments', 'status', 'final_order',
        'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'deletion_reason'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'applicants' => 'array',
        'award_type' => 'array',
        'award_holder_names' => 'array',
        'land_category' => 'array',
        'is_applicant_in_award' => 'boolean',
        'ownership_details' => 'array',
        'mutation_info' => 'array',
        'tax_info' => 'array',
        'additional_documents_info' => 'array',
        'kanungo_opinion' => 'array',
        'final_order' => 'array',
        'deleted_at' => 'datetime',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    /**
     * Get case_date in Bengali format
     */
    public function getCaseDateBengaliAttribute()
    {
        return $this->convertToBengaliDate($this->case_date);
    }

    /**
     * Get order_signature_date in Bengali format
     */
    public function getOrderSignatureDateBengaliAttribute()
    {
        return $this->convertToBengaliDate($this->order_signature_date);
    }

    /**
     * Format application area string based on type
     */
    public function formatApplicationAreaString($deed)
    {
        if (!isset($deed['application_type']) || !$deed['application_type']) {
            // Handle backward compatibility for old data
            if (isset($deed['application_specific_area']) && $deed['application_specific_area']) {
                $specificArea = $deed['application_specific_area'] ?? '';
                $sellArea = $deed['application_sell_area'] ?? '';
                return "আবেদনকৃত {$specificArea} দাগে সুনির্দিষ্টভাবে {$this->bnDigits($sellArea)} একর বিক্রয়";
            } elseif (isset($deed['application_other_areas']) && $deed['application_other_areas']) {
                $otherAreas = $deed['application_other_areas'] ?? '';
                $totalArea = $deed['application_total_area'] ?? '';
                $sellAreaOther = $deed['application_sell_area_other'] ?? '';
                return "আবেদনকৃত {$otherAreas} দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট {$this->bnDigits($totalArea)} একরের কাতে {$this->bnDigits($sellAreaOther)} একর বিক্রয়";
            }
            return '';
        }

        if ($deed['application_type'] === 'specific') {
            $specificArea = $deed['application_specific_area'] ?? '';
            $sellArea = $deed['application_sell_area'] ?? '';
            return "আবেদনকৃত {$specificArea} দাগে সুনির্দিষ্টভাবে {$this->bnDigits($sellArea)} একর বিক্রয়";
        } elseif ($deed['application_type'] === 'multiple') {
            $otherAreas = $deed['application_other_areas'] ?? '';
            $totalArea = $deed['application_total_area'] ?? '';
            $sellAreaOther = $deed['application_sell_area_other'] ?? '';
            return "আবেদনকৃত {$otherAreas} দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট {$this->bnDigits($totalArea)} একরের কাতে {$this->bnDigits($sellAreaOther)} একর বিক্রয়";
        }

        return '';
    }

    /**
     * Get compensation data with Bengali numbers for display
     */
    public function toBengaliDisplayArray()
    {
        $data = $this->toArray();
        
        // Convert numeric fields to Bengali for display
        $numericFields = [
            'case_number', 'la_case_no', 'plot_no', 'sa_plot_no', 'rs_plot_no',
            'land_award_serial_no', 'tree_award_serial_no', 'infrastructure_award_serial_no',
            'jl_no', 'sa_khatian_no', 'rs_khatian_no',
            'source_tax_percentage', 'tree_compensation', 'infrastructure_compensation',
            'land_schedule_sa_plot_no', 'land_schedule_rs_plot_no'
        ];
        
        foreach ($numericFields as $field) {
            if (isset($data[$field]) && $data[$field] !== null) {
                $data[$field] = $this->bnDigits($data[$field]);
            }
        }
        
        // Convert applicants numeric fields
        if (isset($data['applicants']) && is_array($data['applicants'])) {
            foreach ($data['applicants'] as &$applicant) {
                if (isset($applicant['nid'])) {
                    $applicant['nid'] = $this->bnDigits($applicant['nid']);
                }
                if (isset($applicant['mobile'])) {
                    $applicant['mobile'] = $this->bnDigits($applicant['mobile']);
                }
            }
        }
        
        // Convert land category numeric fields
        if (isset($data['land_category']) && is_array($data['land_category'])) {
            foreach ($data['land_category'] as &$category) {
                if (isset($category['total_land'])) {
                    $category['total_land'] = $this->bnDigits($category['total_land']);
                }
                if (isset($category['total_compensation'])) {
                    $category['total_compensation'] = $this->bnDigits($category['total_compensation']);
                }
                if (isset($category['applicant_land'])) {
                    $category['applicant_land'] = $this->bnDigits($category['applicant_land']);
                }
            }
        }
        
        // Convert ownership details numeric fields
        if (isset($data['ownership_details']) && is_array($data['ownership_details'])) {
            // SA info
            if (isset($data['ownership_details']['sa_info']) && is_array($data['ownership_details']['sa_info'])) {
                $saFields = ['sa_plot_no', 'sa_khatian_no', 'sa_total_land_in_plot', 'sa_land_in_khatian'];
                foreach ($saFields as $field) {
                    if (isset($data['ownership_details']['sa_info'][$field])) {
                        $data['ownership_details']['sa_info'][$field] = $this->bnDigits($data['ownership_details']['sa_info'][$field]);
                    }
                }
            }
            
            // RS info
            if (isset($data['ownership_details']['rs_info']) && is_array($data['ownership_details']['rs_info'])) {
                $rsFields = ['rs_plot_no', 'rs_khatian_no', 'rs_total_land_in_plot', 'rs_land_in_khatian'];
                foreach ($rsFields as $field) {
                    if (isset($data['ownership_details']['rs_info'][$field])) {
                        $data['ownership_details']['rs_info'][$field] = $this->bnDigits($data['ownership_details']['rs_info'][$field]);
                    }
                }
            }
            
            // Deed transfers
            if (isset($data['ownership_details']['deed_transfers']) && is_array($data['ownership_details']['deed_transfers'])) {
                foreach ($data['ownership_details']['deed_transfers'] as &$deed) {
                    $deedFields = ['deed_number', 'application_sell_area', 'application_total_area', 'application_sell_area_other'];
                    foreach ($deedFields as $field) {
                        if (isset($deed[$field])) {
                            $deed[$field] = $this->bnDigits($deed[$field]);
                        }
                    }
                }
            }
            
            // RS records
            if (isset($data['ownership_details']['rs_records']) && is_array($data['ownership_details']['rs_records'])) {
                foreach ($data['ownership_details']['rs_records'] as &$rs) {
                    $rsFields = ['plot_no', 'khatian_no', 'land_amount', 'total_land_in_plot', 'land_in_khatian'];
                    foreach ($rsFields as $field) {
                        if (isset($rs[$field])) {
                            $rs[$field] = $this->bnDigits($rs[$field]);
                        }
                    }
                }
            }
            
            // Inheritance records
            if (isset($data['ownership_details']['inheritance_records']) && is_array($data['ownership_details']['inheritance_records'])) {
                foreach ($data['ownership_details']['inheritance_records'] as &$inheritance) {
                    $inheritanceFields = ['land_amount', 'total_land_in_plot', 'land_in_khatian'];
                    foreach ($inheritanceFields as $field) {
                        if (isset($inheritance[$field])) {
                            $inheritance[$field] = $this->bnDigits($inheritance[$field]);
                        }
                    }
                }
            }
            
            // Applicant info
            if (isset($data['ownership_details']['applicant_info']['kharij_land_amount'])) {
                $data['ownership_details']['applicant_info']['kharij_land_amount'] = 
                    $this->bnDigits($data['ownership_details']['applicant_info']['kharij_land_amount']);
            }
        }
        
        // Convert tax info numeric fields
        if (isset($data['tax_info']) && is_array($data['tax_info'])) {
            $taxFields = ['holding_no', 'paid_land_amount'];
            foreach ($taxFields as $field) {
                if (isset($data['tax_info'][$field])) {
                    $data['tax_info'][$field] = $this->bnDigits($data['tax_info'][$field]);
                }
            }
        }
        
        // Convert mutation info numeric fields
        if (isset($data['mutation_info']) && is_array($data['mutation_info'])) {
            foreach ($data['mutation_info'] as &$mutation) {
                $mutationFields = ['land_amount', 'total_land_in_plot', 'land_in_khatian'];
                foreach ($mutationFields as $field) {
                    if (isset($mutation[$field])) {
                        $mutation[$field] = $this->bnDigits($mutation[$field]);
                    }
                }
            }
        }
        
        // Convert final order numeric fields
        if (isset($data['final_order']) && is_array($data['final_order'])) {
            if (isset($data['final_order']['trees_crops']['amount'])) {
                $data['final_order']['trees_crops']['amount'] = $this->bnDigits($data['final_order']['trees_crops']['amount']);
            }
            if (isset($data['final_order']['infrastructure']['amount'])) {
                $data['final_order']['infrastructure']['amount'] = $this->bnDigits($data['final_order']['infrastructure']['amount']);
            }
        }
        
        // Convert kanungo opinion numeric fields
        if (isset($data['kanungo_opinion']) && is_array($data['kanungo_opinion'])) {
            foreach ($data['kanungo_opinion'] as &$opinion) {
                $opinionFields = ['land_amount', 'total_land_in_plot', 'land_in_khatian'];
                foreach ($opinionFields as $field) {
                    if (isset($opinion[$field])) {
                        $opinion[$field] = $this->bnDigits($opinion[$field]);
                    }
                }
            }
        }
        
        return $data;
    }
    
    /**
     * Get a specific field value in Bengali
     */
    public function getBengaliValue($field)
    {
        if (isset($this->attributes[$field])) {
            return $this->bnDigits($this->attributes[$field]);
        }
        return null;
    }
    
    /**
     * Get nested field value in Bengali (e.g., ownership_details.sa_info.sa_plot_no)
     */
    public function getBengaliNestedValue($path)
    {
        $parts = explode('.', $path);
        $current = $this;
        
        foreach ($parts as $part) {
            if (is_object($current) && !isset($current->$part)) {
                return null;
            } elseif (is_array($current) && !isset($current[$part])) {
                return null;
            }
            
            if (is_object($current)) {
                $current = $current->$part;
            } else {
                $current = $current[$part];
            }
        }
        
        if (is_string($current) || is_numeric($current)) {
            return $this->bnDigits($current);
        }
        
        return $current;
    }

    /**
     * Get the total land amount from land category
     */
    public function getTotalLandAmountAttribute()
    {
        if (!$this->land_category || !is_array($this->land_category)) {
            return 0;
        }

        return collect($this->land_category)->sum(function ($category) {
            return floatval($category['total_land'] ?? 0);
        });
    }

    /**
     * Get the total compensation amount from land category
     */
    public function getTotalCompensationAmountAttribute()
    {
        if (!$this->land_category || !is_array($this->land_category)) {
            return 0;
        }

        return collect($this->land_category)->sum(function ($category) {
            return floatval($category['total_compensation'] ?? 0);
        });
    }

    /**
     * Get the applicant's acquired land amount
     */
    public function getApplicantAcquiredLandAttribute()
    {
        if (!$this->land_category || !is_array($this->land_category)) {
            return 0;
        }

        return collect($this->land_category)->sum(function ($category) {
            return floatval($category['applicant_land'] ?? 0);
        });
    }

    /**
     * Get the plot number - use actual database field if exists, otherwise compute based on acquisition record basis
     */
    public function getPlotNoAttribute($value)
    {
        // If the actual plot_no field has a value, use it
        if (!empty($value)) {
            return $value;
        }
        
        // Otherwise, fall back to the computed logic for backward compatibility
        if ($this->acquisition_record_basis === 'SA') {
            return $this->land_schedule_sa_plot_no;
        } elseif ($this->acquisition_record_basis === 'RS') {
            return $this->land_schedule_rs_plot_no;
        }
        return $this->jl_no;
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to search in compensation records
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('la_case_no', 'like', "%{$search}%")
              ->orWhere('case_number', 'like', "%{$search}%")
              ->orWhere('mouza_name', 'like', "%{$search}%")
              ->orWhere('jl_no', 'like', "%{$search}%")
              ->orWhere('sa_khatian_no', 'like', "%{$search}%")
              ->orWhere('rs_khatian_no', 'like', "%{$search}%")
              ->orWhere('plot_no', 'like', "%{$search}%")
              ->orWhere('land_schedule_sa_plot_no', 'like', "%{$search}%")
              ->orWhere('land_schedule_rs_plot_no', 'like', "%{$search}%")
              ->orWhereRaw("JSON_SEARCH(applicants, 'one', ?, null, '$[*].name')", ["%{$search}%"])
              ->orWhereRaw("JSON_SEARCH(applicants, 'one', ?, null, '$[*].nid')", ["%{$search}%"]);
        });
    }

    /**
     * Get the user who created this compensation
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this compensation
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted this compensation
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Scope to get only non-deleted compensations
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope to get only deleted compensations
     */
    public function scopeOnlyDeleted($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    /**
     * Check if compensation is deleted
     */
    public function isDeleted(): bool
    {
        return !is_null($this->deleted_at);
    }

    /**
     * Soft delete the compensation
     */
    public function softDelete($reason = null, $deletedBy = null)
    {
        $this->update([
            'deleted_at' => now(),
            'deleted_by' => $deletedBy,
            'deletion_reason' => $reason,
        ]);
    }

    /**
     * Restore the soft deleted compensation
     */
    public function restore()
    {
        $this->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'deletion_reason' => null,
        ]);
    }
}