<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'form_type',
        'title',
        'description',
        'icon',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Constants for form types
    const FORM_TYPES = [
        'user_information' => 'User Information Form',
        'providable_information' => 'Providable Information Form',
        'quotation' => 'Quotation Form',
    ];

    // Accessors
    public function getFormTypeTextAttribute()
    {
        return self::FORM_TYPES[$this->form_type] ?? ucfirst(str_replace('_', ' ', $this->form_type));
    }
}

