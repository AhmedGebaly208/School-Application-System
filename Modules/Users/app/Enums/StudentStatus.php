<?php

namespace Modules\Users\Enums;

enum StudentStatus: string
{
    //active, graduated, transferred, expelled
    case ACTIVE = 'active';
    case GRADUATED = 'graduated';
    case TRANSFERRED = 'transferred';
    case EXPELLED = 'expelled';
}
