<?php

namespace Octo\Marketing\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DRAFT()
 * @method static self ACTIVE()
 * @method static self CANCELED()
 * @method static self PAUSED()
 * @method static self PENDING()
 * @method static self FINISHED()
 */
final class CampaignStatus extends Enum
{
    public static function colors(): array
    {
        return [
            'primary' => self::DRAFT()->value,
            'success' => self::ACTIVE()->value,
            'danger' => self::CANCELED()->value,
            'warning' => self::PAUSED()->value,
            'primary' => self::PENDING()->value,
            'success' => self::FINISHED()->value,
        ];
    }

    public static function descriptions(): array
    {
        return [
            self::DRAFT()->value => 'Draft',
            self::ACTIVE()->value => 'Active',
            self::CANCELED()->value => 'Canceled',
            self::PAUSED()->value => 'Paused',
            self::PENDING()->value => 'Pending',
            self::FINISHED()->value => 'Finished',
        ];
    }

    public static function toArray(): array
    {
        return [
            self::DRAFT()->value => 'Draft',
            self::ACTIVE()->value => 'Active',
            self::CANCELED()->value => 'Canceled',
            self::PAUSED()->value => 'Paused',
            self::PENDING()->value => 'Pending',
            self::FINISHED()->value => 'Finished',
        ];
    }
}
