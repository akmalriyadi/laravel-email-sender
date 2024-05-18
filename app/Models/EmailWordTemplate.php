<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailWordTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'template_word_id',
        'email_id',
        'val'
    ];

    public function template_word()
    {
        return $this->belongsTo(TemplateWord::class, 'template_word_id', 'id');
    }
}
