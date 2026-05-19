<?php

namespace App\Enums;

enum WorkStepEnum: string
{
    case STEP_01 = '01';
    case STEP_02 = '02';
    case STEP_03 = '03';

    public static function labels(): array
    {
        return [
            self::STEP_01->value => 'Step 01',
            self::STEP_02->value => 'Step 02',
            self::STEP_03->value => 'Step 03',
        ];
    }
}
