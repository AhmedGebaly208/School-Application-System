<?php

namespace Modules\Users\Enums;
enum StaffStatus: string
{
    //active, on_leave, resigned, terminated
    case ACTIVE = 'active';
    case ON_LEAVE = 'on_leave';
    case RESIGNED = 'resigned';
    case TERMINATED = 'terminated';
}
