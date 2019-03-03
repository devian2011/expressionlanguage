<?php

namespace Devian\ExpressionLanguage\Resolvers\Functions\operations;

use Devian\ExpressionLanguage\TokenRegistry;

class Logic
{

    public static function getOperations()
    {
        return [

            TokenRegistry::T_AND => function ($first, $second) {
                return $first && $second;
            },
            TokenRegistry::T_OR => function ($first, $second) {
                return $first || $second;
            }

        ];
    }

}
