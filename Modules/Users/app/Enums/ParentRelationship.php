<?php

namespace Modules\Users\Enums;
enum ParentRelationship: string
{
    case FATHER = 'father';
    case MOTHER = 'mother';
    case GUARDIAN = 'guardian';
    case OTHER = 'other';
}
