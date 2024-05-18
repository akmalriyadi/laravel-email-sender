<?php

namespace App\Models;

use AkmalRiyadi\LaravelBackendGenerator\Traits\BaseScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, BaseScope, SoftDeletes;
    protected $fillable = [
        'title',
        'file',
        'real_name',
        'type'
    ];
}
