<?php

namespace App\Enums;

enum FailedQuestion: string
{
    case NonCompliant = 'Non-Compliant';
    case Cat1ResubmitRemediation = 'Cat1 Resubmit Remediation';
    case NCResubmitRemediation = 'NC Resubmit Remediation';
    case Cat1ResubmitAppeal = 'Cat1 Resubmit Appeal';
    case NCResubmitAppeal = 'NC Resubmit Appeal';
    case FailNCRemediation = 'Fail NC Remediation';
    case FailNCAppeal = 'Fail NC Appeal';

    // case Cat1ReinspectRemediation = 'Cat1 Reinspect Remediation';
    // case NCReinspectRemediation = 'NC Reinspect Remediation';

    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }
}
