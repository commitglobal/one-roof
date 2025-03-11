<?php

declare(strict_types=1);

namespace App\Contracts;

interface TranslatablePage
{
    public function setLocale(string $locale): void;
}
