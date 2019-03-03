<?php

namespace Devian\ExpressionLanguage;

/**
 * Class TokenRegistry
 * @package AppBundle\Core\ExpressionLanguage
 */
class TokenRegistry
{

    //Constants and variables tokens
    public const T_INT = 'number';
    public const T_FLOAT = 'float';
    public const T_STRING = 'string';
    public const T_VARIABLE = 'variable';

    public const T_QUOT = 'quot';

    //Logic token constants
    public const T_GREATER_THEN = 'gt';
    public const T_GREATER_EQ = 'gte';
    public const T_LESS_THEN = 'lt';
    public const T_LESS_EQ = 'lte';
    public const T_EQUAL = 'equal';
    public const T_NOT_EQUAL = 'not_equal';

    //Math functions
    public const T_PLUS = 'plus';
    public const T_MINUS = 'minus';
    public const T_MULTIPLY = 'multiply';
    public const T_SPLIT = 'split';


    public const T_AND = 'logic_and';
    public const T_OR = 'logic_or';

    public const T_OPEN_BRACKET = 'open_bracket';
    public const T_CLOSE_BRACKET = 'close_bracket';

}
