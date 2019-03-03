<?php

namespace Devian\ExpressionLanguage\Syntax;

use Devian\ExpressionLanguage\Exceptions\ParseErrorException;
use Devian\ExpressionLanguage\Lexers\Token;

/**
 * Class TokenInterpreter
 * @package AppBundle\Core\ExpressionLanguage\Syntax
 */
class TokenIterator
{

    /**
     * @var int
     */
    private $tokenEnd;

    /**
     * @var Token[]|array
     */
    private $tokens;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var bool
     */
    private $end = false;

    /**
     * TokenInterpreter constructor.
     * @param Token[] $tokens
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
        $this->tokenEnd = sizeof($tokens) - 1;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return Token|mixed
     * @throws \Exception
     */
    public function getCurrent()
    {
        if (isset($this->tokens[$this->position])) {
            return $this->tokens[$this->position];
        }
        throw new ParseErrorException("End of line exception");
    }

    /**
     * Сдвигает указатель вперед
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Получает следующий токен не сдвигая указатель
     *
     * @return Token|mixed|null
     */
    public function getNextToken()
    {
        if (!empty($this->tokens[$this->position + 1])) {
            return $this->tokens[$this->position + 1];
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isEnd()
    {
        return $this->position === $this->tokenEnd;
    }

}
