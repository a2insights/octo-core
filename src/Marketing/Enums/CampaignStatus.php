<?php

namespace Octo\Marketing\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self DRAFT()
 * @method static self SCHEDULED()
 * @method static self ACTIVE()
 * @method static self CANCELLED()
 * @method static self PAUSED()
 * @method static self PENDING()
 * @method static self ENDED()
 * @method static self FINISHED()
 */
final class CampaignStatus extends Enum
{
    public static function colors(): array
    {
        return [
            'secondary' => self::DRAFT()->value,
            'primary' => self::SCHEDULED()->value,
            'success' => self::ACTIVE()->value,
            'danger' => self::CANCELLED()->value,
            'warning' => self::PAUSED()->value,
            'info' => self::PENDING()->value,
            'info' => self::ENDED()->value,
        ];
    }

    public static function descriptions(): array
    {
        return [
            self::DRAFT()->value => 'Draft',
            self::SCHEDULED()->value => 'Scheduled',
            self::ACTIVE()->value => 'Active',
            self::CANCELLED()->value => 'Cancelled',
            self::PAUSED()->value => 'Paused',
            self::PENDING()->value => 'Pending',
            self::ENDED()->value => 'Ended',
        ];
    }

    public static function toArray(): array
    {
        return [
            self::DRAFT()->value => 'Draft',
            self::SCHEDULED()->value => 'Scheduled',
            self::ACTIVE()->value => 'Active',
            self::CANCELLED()->value => 'Cancelled',
            self::PAUSED()->value => 'Paused',
            self::PENDING()->value => 'Pending',
            self::ENDED()->value => 'Ended',
        ];
    }
}
