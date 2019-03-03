<?php

namespace Devian\ExpressionLanguage\Resolvers\Functions\operations;

use Devian\ExpressionLanguage\TokenRegistry;

class Math
{

    public static function getOperations()
    {
        return [
            TokenRegistry::T_PLUS => function ($first, $second) {
                return $first + $second;
            },
            TokenRegistry::T_MINUS => function ($first, $second) {
                return $first - $second;
            },
            TokenRegistry::T_MULTIPLY => function ($first, $second) {
                return $first * $second;
            },
            TokenRegistry::T_SPLIT => function ($first, $second) {
                return $first / $second;
            }
        ];
    }

}
