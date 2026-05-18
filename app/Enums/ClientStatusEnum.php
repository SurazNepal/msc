<?php

namespace App\Enums;

enum ClientStatusEnum: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';

    public static function labels(): array
    {
        return [
            self::PUBLISHED->value => 'Published',
            self::DRAFT->value     => 'Draft',
        ];
    }

    public static function colors(): array
    {
        return [
            self::PUBLISHED->value => 'bg-green-100 text-green-800 dark:bg-green-950/40 dark:text-green-400',
            self::DRAFT->value     => 'bg-gray-100 text-gray-700 dark:bg-zinc-700 dark:text-zinc-300',
        ];
    }
}
