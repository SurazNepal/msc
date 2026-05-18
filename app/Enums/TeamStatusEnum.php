<?php

namespace App\Enums;

enum TeamStatusEnum : string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    public static function labels(): array{
        return [
            self::DRAFT->value => __('Draft'),
            self::PUBLISHED->value => __('Published'),
        ];
    }

    public static function Colors(): array{
        return [
            self::DRAFT->value =>'bg-orange-100 text-orange-800',
            self::PUBLISHED->value =>'bg-green-100 text-green-800',
        ];
    }
}
