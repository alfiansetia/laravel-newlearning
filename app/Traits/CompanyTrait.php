<?php

namespace App\Traits;

use App\Models\Company;

trait CompanyTrait
{
    protected $company;
    protected $user;

    private function getCompany()
    {
        return $this->company ?? Company::first();
    }

    private function getUser()
    {
        return $this->user ?? auth()->user();
    }
}
