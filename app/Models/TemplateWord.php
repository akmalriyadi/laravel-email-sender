<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateWord extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_id',
        'title',
        'val_title'
    ];
}
