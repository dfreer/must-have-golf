<?php

namespace App\Enums;

enum SourceContextType: string
{
    case YouTube_Channel = 'youtube-channel';
    case SubReddit = 'subreddit';
    case Website = 'website';
    case ECommerce = 'ecommerce';
    case Forum = 'forum';
}
