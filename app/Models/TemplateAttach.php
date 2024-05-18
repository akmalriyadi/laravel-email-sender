<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateAttach extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_id',
        'template_id'
    ];
}
