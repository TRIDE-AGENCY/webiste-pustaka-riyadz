<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'description',
        'requirements',
        'attachments',
        'attached_documents',
        'submission_method',
    ];

    protected $casts = [
        'requirements' => 'array',
        'attachments' => 'array',
        'attached_documents' => 'array',
        'submission_method' => 'array',
    ];
}
