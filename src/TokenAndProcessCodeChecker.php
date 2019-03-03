<?php

namespace Devian\ExpressionLanguage;

/**
 * Class TokenAndProcessCodeChecker
 * @package AppBundle\Core\ExpressionLanguage
 */
class TokenAndProcessCodeChecker
{


    /**
     * @param $code
     * @return bool
     */
    public static function isMultiplyOrDivision($code)
    {
        return $code === TokenRegistry::T_MULTIPLY || $code === TokenRegistry::T_SPLIT;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isPlusOrMinus($code)
    {
        return $code === TokenRegistry::T_PLUS || $code === TokenRegistry::T_MINUS;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isComparison($code)
    {
        return in_array($code, [
            TokenRegistry::T_GREATER_EQ,
            TokenRegistry::T_GREATER_THEN,
            TokenRegistry::T_LESS_EQ,
            TokenRegistry::T_LESS_THEN
        ]);
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isEqualOrNot($code)
    {
        return $code === TokenRegistry::T_EQUAL || $code === TokenRegistry::T_NOT_EQUAL;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isLogicAnd($code)
    {
        return $code === TokenRegistry::T_AND;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isLogicOr($code)
    {
        return $code === TokenRegistry::T_OR;
    }


    /**
     * @param $code
     * @return bool
     */
    public static function isScalar($code)
    {
        return in_array($code, [TokenRegistry::T_INT, TokenRegistry::T_FLOAT, TokenRegistry::T_STRING]);
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isVariable($code)
    {
        return $code === TokenRegistry::T_VARIABLE;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isOpenBracket($code)
    {
        return $code === TokenRegistry::T_OPEN_BRACKET;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function isQuot($code)
    {
        return $code === TokenRegistry::T_QUOT;
    }

}
