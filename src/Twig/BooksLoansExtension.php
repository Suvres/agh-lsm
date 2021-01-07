<?php

namespace App\Twig;

use App\Service\BooksLoansService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BooksLoansExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
          new TwigFilter('is_in_loans', [BooksLoansService::class, 'isInLoans'])
        ];
    }
}
