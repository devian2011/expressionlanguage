<?php
namespace Devian\ExpressionLanguage\Resolvers\Functions\operations;

use \Devian\ExpressionLanguage\TokenRegistry;

/**
 * Class Equality
 * @package Devian\ExpressionLanguage\Resolvers\Functions\operations
 */
class Equality
{

    public static function getOperations()
    {
        return [
            TokenRegistry::T_NOT_EQUAL => function ($first, $second) {
                return $first != $second;
            },
            TokenRegistry::T_EQUAL => function ($first, $second) {
                return $first == $second;
            },
            TokenRegistry::T_GREATER_THEN => function ($first, $second) {
                return $first > $second;
            },
            TokenRegistry::T_GREATER_EQ => function ($first, $second) {
                return $first >= $second;
            },
            TokenRegistry::T_LESS_THEN => function ($first, $second) {
                return $first < $second;
            },
            TokenRegistry::T_LESS_EQ => function ($first, $second) {
                return $first <= $second;
            },
        ];
    }

}

