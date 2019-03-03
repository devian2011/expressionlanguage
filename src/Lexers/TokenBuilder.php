<?php

namespace Devian\ExpressionLanguage\Lexers;

use Devian\ExpressionLanguage\Exceptions\ParseErrorException;
use Devian\ExpressionLanguage\TokenRegistry;

/**
 * Class TokenBuilder
 * @package AppBundle\Core\ExpressionLanguage\Lexers
 */
class TokenBuilder
{
    /**
     * @param $position
     * @param $sign
     * @return Token
     * @throws \Exception
     */
    public static function getTokenBySign(int $position, string $sign)
    {
        switch ($sign) {
            case '(':
                return new Token(TokenRegistry::T_OPEN_BRACKET, '(', $position);
            case ')':
                return new Token(TokenRegistry::T_CLOSE_BRACKET, ')', $position);
            case '*':
                return new Token(TokenRegistry::T_MULTIPLY, '*', $position);
            case '/':
                return new Token(TokenRegistry::T_SPLIT, '/', $position);
            case '+':
                return new Token(TokenRegistry::T_PLUS, '+', $position);
            case '-':
                return new Token(TokenRegistry::T_MINUS, '-', $position);
            case '>':
                return new Token(TokenRegistry::T_GREATER_THEN, '>', $position);
            case '<':
                return new Token(TokenRegistry::T_LESS_THEN, '<', $position);
            case '==':
                return new Token(TokenRegistry::T_EQUAL, '==', $position);
            case '!=':
                return new Token(TokenRegistry::T_NOT_EQUAL, '!=', $position);
            case '>=':
                return new Token(TokenRegistry::T_GREATER_EQ, '>=', $position);
            case '<=':
                return new Token(TokenRegistry::T_LESS_EQ, '<=', $position);
            case ',':
                return new Token(TokenRegistry::T_QUOT, ',', $position);
            case '&&':
                return new Token(TokenRegistry::T_AND, '&&', $position);
            case '||':
                return new Token(TokenRegistry::T_OR, '||', $position);
        }

        if (preg_match('#^[0-9]+$#', $sign)) {
            return new Token(TokenRegistry::T_INT, $sign, $position);
        } elseif (preg_match('#[0-9]+\.[0-9]+#', $sign)) {
            return new Token(TokenRegistry::T_FLOAT, $sign, $position);
        } elseif (preg_match('#^[A-z\.]+$#', $sign)) {
            return new Token(TokenRegistry::T_VARIABLE, $sign, $position);
        } elseif (preg_match('#^".+"$#', $sign)) {
            $sign = strtr($sign, ['"' => '']);
            return new Token(TokenRegistry::T_STRING, $sign, $position);
        } else {
            throw new ParseErrorException("Unknown sign type for {$sign}");
        }

    }

}
