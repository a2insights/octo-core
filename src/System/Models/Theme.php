<?php

namespace Octo\System\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Octo\System\Database\Factories\ThemeFactory;

class Theme extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'author',
        'version',
        'active',
    ];

    /**
    * The factory associated with the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    public static function newFactory()
    {
        return ThemeFactory::new();
    }

    /**
     * Check if the theme is vcs
     *
     * @var bool
     */
    public function isVcs(): bool
    {
        return $this->repository_url !== null;
    }
}
