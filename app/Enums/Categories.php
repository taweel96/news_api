<?php

namespace App\Enums;

enum Categories: string
{
    case GENERAL = 'general';
    case SPORTS = 'sports';
    case BUSINESS = 'business';
    case FINANCE = 'finance';
    case CULTURE = 'culture';
    case ART = 'art';
    case TRAVEL = 'travel';
    case TECHNOLOGY = 'technology';
    case SCIENCE = 'science';
    case POLITICS = 'politics';
    case WORLD = 'world';



    public static function map(string $category): self {
        $category = str_replace(' ', '_', strtolower($category));
        return match ($category){
            'football', 'volleyball', 'basketball', 'sports', 'sport', 'golf', 'hooky', 'tennis', 'tennis_ball' => self::SPORTS,
            'it', 'tech', 'software', 'software_engineering', 'developer', 'technology', => self::TECHNOLOGY,
            'finance', 'currency', 'stocks'  => self::FINANCE,
            'art', 'cinema', 'theater', 'movie', 'movies', 'series', 'tv_show' => self::ART,
            'chemistry', 'physics', 'math', 'mathematics', 'science', 'scientific' => self::SCIENCE,
            'culture' => self::CULTURE,
            'travel' => self::TRAVEL,
            'political', 'politics' => self::POLITICS,
            'world' => self::WORLD,
            default => self::GENERAL,
        };
    }
}
