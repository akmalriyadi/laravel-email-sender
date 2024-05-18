<?php

namespace App\Models;

use AkmalRiyadi\LaravelBackendGenerator\Traits\BaseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSender extends Model
{
    use HasFactory, BaseScope, SoftDeletes;

    protected $fillable = [
        'template_id',
        'to',
        'subject',
        'status'
    ];

    public function email_words()
    {
        return $this->hasMany(EmailWordTemplate::class, 'email_id', 'id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }
}
