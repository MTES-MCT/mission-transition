<?php

namespace App\Enum;

enum Status: String
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
}
