<?php

namespace Octo\Marketing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Octo\Marketing\Database\Factories\CampaignContactFactory;
use Octo\Marketing\Enums\CampaignContactStatus;

class CampaignContact extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'notified_at',
        'data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'status' => CampaignContactStatus::class,
    ];

    protected $attributes = [
        'status' => 'PENDING',
    ];

    /**
     * The factory associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return CampaignContactFactory::new();
    }

    public function isPending()
    {
        return $this->status == CampaignContactStatus::PENDING();
    }

    public function isCanceled()
    {
        return $this->status == CampaignContactStatus::CANCELED();
    }

    public function isNotified()
    {
        return $this->status == CampaignContactStatus::NOTIFIED();
    }

    public function isFailed()
    {
        return $this->status == CampaignContactStatus::FAILED();
    }
}
