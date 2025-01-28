<?php

namespace app\Models;

enum AddressType: string
{
    case INDIVIDUAL = 'individual';
    case LEGAL = 'legal';
}
