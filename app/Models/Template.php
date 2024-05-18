<?php

namespace App\Models;

use AkmalRiyadi\LaravelBackendGenerator\Traits\BaseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory, BaseScope;
    protected $fillable = [
        'title',
        'body'
    ];

    public function body_words()
    {
        return $this->hasMany(TemplateWord::class, 'template_id', 'id');
    }
    public function document_pivots()
    {
        return $this->hasMany(TemplateAttach::class, 'template_id', 'id');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'template_attaches', 'template_id', 'document_id');
    }
}
