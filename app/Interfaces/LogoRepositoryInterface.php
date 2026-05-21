<?php

namespace App\Interfaces;

interface LogoRepositoryInterface
{
    public function getLogoSettings();
    public function updateLogo(array $data);
}
