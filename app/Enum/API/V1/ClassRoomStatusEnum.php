<?php

namespace App\Enum\API\V1;

enum ClassRoomStatusEnum: string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case IN_PROGRESS = 'Class in progress';
    case CANCELLED = 'Cancelled';
}
