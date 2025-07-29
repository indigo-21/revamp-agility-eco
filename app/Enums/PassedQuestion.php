<?php

namespace App\Enums;

enum PassedQuestion: string
{
    case Cat1ReinspectRemediation = 'Cat1 Reinspect Remediation';
    case NCReinspectRemediation = 'NC Reinspect Remediation';
    case Cat1ReinspectAppeal = 'Cat1 Reinspect Appeal';
    case NCReinspectAppeal = 'NC Reinspect Appeal';
    case PassRemediation = 'Pass Remediation Overturned';
    case PassAppeal = 'Pass Appeal Overturned';

    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }

}
