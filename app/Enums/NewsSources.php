<?php

namespace App\Enums;

enum NewsSources: string
{
    case NEWS_API = 'news_api';

    case GUARDIAN_API = 'guardian_api';

    case BBC_API = 'bbc_api';
}
