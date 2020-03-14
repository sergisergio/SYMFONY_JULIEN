<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MakeTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // Add filter
            // - filter name = "myFilter" Ex: {{ var|myFilter }}
            // - filter action = "toUnderBold()"
            new TwigFilter('myFilter', [$this, 'toUnderBold']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            // Add function
            // - filter name = "{{ myFunction(var) }}"
            // - filter action = "$this->toUnderBold()"
            new TwigFunction('myFunction', [$this, 'toUnderBold']),

            // Add function
            // - filter name = "{{ ruleOfThree(var) }}"
            // - filter action = "$this->ruleOfThree()"
            new TwigFunction('ruleOfThree', [$this, 'ruleOfThree']),
        ];
    }

    // Action "$this->toUnderBold()"
    public function toUnderBold($value)
    {
        return '<b><u>' . $value . '</u></b>';
    }

    // Action "$this->ruleOfThree()"
    public function ruleOfThree($a, $b, $c)
    {
        return $a * $b / $c;
    }
}
