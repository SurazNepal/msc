<?php

namespace App\Enums;

enum WorkStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    public static function labels(): array
    {
        return [
            self::DRAFT->value     => 'Draft',
            self::PUBLISHED->value => 'Published',
        ];
    }

    public static function colors(): array
    {
        return [
            self::DRAFT->value     => 'bg-orange-100 text-orange-800 dark:bg-orange-800/30 dark:text-zinc-400',
            self::PUBLISHED->value => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        ];
    }
}
