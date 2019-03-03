<?php

namespace Devian\ExpressionLanguage\Resolvers\Functions\stlfunctions;

/**
 * Class Math
 * @package Devian\ExpressionLanguage\Resolvers\Functions\stlfunctions
 */
class StlMath
{

    public static function getFunctions()
    {
        return [
            'count' => function ($forCount) {
                return sizeof($forCount);
            }
        ];
    }

}
