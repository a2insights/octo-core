<?php

namespace A2Insights\FilamentSaas\Tenant\Actions\FilamentCompanies;

use A2Insights\FilamentSaas\Tenant\Company;
use Wallo\FilamentCompanies\Contracts\DeletesCompanies;

class DeleteCompany implements DeletesCompanies
{
    /**
     * Delete the given company.
     */
    public function delete(Company $company): void
    {
        $company->purge();
    }
}
