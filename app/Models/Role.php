<?php

namespace App\Models;

enum Role: string
{

    case ADMIN = 'admin';

    case USER = 'user';

    case OWNER = 'owner';
}
