<?php

namespace App\Interfaces;

interface UpdateLocalNewsDatasetInterface
{
    public function update(array $articles): void;
}
