<?php

namespace Devian\ExpressionLanguage\Lexers;

/**
 * Class Lexer
 * @package AppBundle\Core\Lexer
 */
class Lexer
{

    protected const REGEX_OPTIONS = [
        'open_bracket' => '(\()',
        'close_bracket' => '(\))',
        'options' => '([A-Za-z\.]+)',
        'math' => '([+\-\*\/])',
        'logic' => '([&\|><=\!]{1,2})',
        'float_constant' => '([0-9]+\.[0-9]+)',
        'int_constant' => '([0-9]+)',
        'string_constant' => '(\".+?\")',
        'quot' => '(\,)'
    ];

    /**
     * @param string $expression
     * @return array
     * @throws \Exception
     */
    public function parse(string $expression): array
    {
        $regex = '#' . implode('|', self::REGEX_OPTIONS) . '#';
        $matches = [];
        $result = [];
        if (preg_match_all($regex, $expression, $matches) !== false) {
            foreach ($matches[0] as $key => $token) {
                $result[$key] = TokenBuilder::getTokenBySign($key, $token);
            }
        }

        return $result;
    }

}
