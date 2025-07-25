<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensation extends Model
{
    use HasFactory;

    protected $table = 'compensations';

    protected $fillable = [
        'case_number', 'case_date', 'sa_plot_no', 'rs_plot_no',
        'applicants', 'la_case_no', 'award_type', 'award_serial_no',
        'acquisition_record_basis', 'plot_no', 'award_holder_name',
        'objector_details', 'is_applicant_in_award', 'total_acquired_land',
        'total_compensation', 'applicant_acquired_land', 'mouza_name',
        'jl_no', 'sa_khatian_no', 'former_plot_no', 'rs_khatian_no',
        'current_plot_no', 'is_applicant_sa_owner', 'ownership_details', 'mutation_info', 'tax_info', 'additional_documents_info', 'kanungo_opinion',
        'sa_owners', 'rs_owners'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'applicants' => 'array',
        'award_type' => 'array',
        'is_applicant_in_award' => 'boolean',
        'ownership_details' => 'array',
        'mutation_info' => 'array',
        'tax_info' => 'array',
        'additional_documents_info' => 'array',
        'kanungo_opinion' => 'array',
        'sa_owners' => 'array',
        'rs_owners' => 'array',
    ];
}