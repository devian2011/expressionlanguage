<?php
/**
 * Created by PhpStorm.
 * User: romanov
 * Date: 15.02.2019
 * Time: 14:18
 */

namespace Devian\ExpressionLanguage\Resolvers\Functions\stlfunctions;


class StlString
{
    /**
     * @return array
     */
    public static function getFunctions()
    {
        return [
            'concat' => function () {
                $args = func_get_args();
                $delimiter = array_shift($args);
                return implode($delimiter, $args);
            }
        ];
    }

}