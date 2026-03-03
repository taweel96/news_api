<?php

namespace App\Interfaces;

interface ParseApiResponseInterface
{
    public function parse(array $articles): array;
}
