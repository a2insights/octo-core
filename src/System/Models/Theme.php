<?php

namespace Octo\System\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'description',
        'author',
        'version',
        'active',
    ];
}
