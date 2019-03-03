<?php

namespace Devian\ExpressionLanguage\Syntax;

use Devian\ExpressionLanguage\Exceptions\ParseErrorException;
use Devian\ExpressionLanguage\Lexers\Token;
use Devian\ExpressionLanguage\TokenAndProcessCodeChecker;
use Devian\ExpressionLanguage\TokenRegistry;

/**
 * Class Syntaxer
 * @package AppBundle\Core\ExpressionLanguage\Syntax
 */
class Syntaxer
{
    /**
     * @var TokenIterator
     */
    private $iterator;

    /**
     * @param array $tokens
     * @throws \Exception
     */
    public function getSyntaxTree(array $tokens): Point
    {
        $this->iterator = new TokenIterator($tokens);
        $result = $this->buildTreePoint();
        if (!$this->iterator->isEnd()) {
            throw new ParseErrorException("Part of string has not been parsed");
        }

        return $result;
    }

    /**
     * @param Point $parent
     * @param Token[] $tokens
     * @param int $tokenIndex
     * @throws \Exception
     */
    public function buildTreePoint(): Point
    {
        return $this->parse();
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function parse(): Point
    {
        return $this->orBuild();
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function orBuild(): Point
    {
        $result = $this->andBuild();
        while (TokenAndProcessCodeChecker::isLogicOr($this->iterator->getCurrent()->getCode())) {
            $code = $this->iterator->getCurrent()->getCode();
            $this->iterator->next();
            $next = $this->andBuild();
            $result = new OperationPoint($code, $result, $next);
        }
        return $result;
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function andBuild(): Point
    {
        $result = $this->equalNotEqualBuild();
        while (TokenAndProcessCodeChecker::isLogicAnd($this->iterator->getCurrent()->getCode())) {
            $code = $this->iterator->getCurrent()->getCode();
            $this->iterator->next();
            $next = $this->equalNotEqualBuild();
            $result = new OperationPoint($code, $result, $next);
        }
        return $result;
    }


    /**
     * @return Point
     * @throws \Exception
     */
    private function equalNotEqualBuild(): Point
    {
        $result = $this->gtLtBuild();
        while (TokenAndProcessCodeChecker::isEqualOrNot($this->iterator->getCurrent()->getCode())) {
            $code = $this->iterator->getCurrent()->getCode();
            $this->iterator->next();
            $next = $this->gtLtBuild();
            $result = new OperationPoint($code, $result, $next);
        }
        return $result;
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function gtLtBuild(): Point
    {
        $result = $this->plusMinusBuild();
        while (TokenAndProcessCodeChecker::isComparison($this->iterator->getCurrent()->getCode())) {
            $code = $this->iterator->getCurrent()->getCode();
            $this->iterator->next();
            $next = $this->plusMinusBuild();
            $result = new OperationPoint($code, $result, $next);
        }
        return $result;
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function plusMinusBuild(): Point
    {
        $result = $this->mulSplitBuild();
        while (TokenAndProcessCodeChecker::isPlusOrMinus($this->iterator->getCurrent()->getCode())) {
            $code = $this->iterator->getCurrent()->getCode();
            $this->iterator->next();
            $next = $this->mulSplitBuild();
            $result = new OperationPoint($code, $result, $next);
        }
        return $result;
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function mulSplitBuild(): Point
    {
        $result = $this->groupBuild();
        while (TokenAndProcessCodeChecker::isMultiplyOrDivision($this->iterator->getCurrent()->getCode())) {
            $code = $this->iterator->getCurrent()->getCode();
            $this->iterator->next();
            $next = $this->groupBuild();
            $result = new OperationPoint($code, $result, $next);
        }
        return $result;
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function groupBuild(): Point
    {
        if (TokenAndProcessCodeChecker::isOpenBracket($this->iterator->getCurrent()->getCode())) {
            $this->iterator->next();
            $result = $this->orBuild();
            if (!$this->iterator->isEnd()) {
                $this->iterator->next();
            }

            return $result;
        }
        $currentToken = $this->iterator->getCurrent();
        if (TokenAndProcessCodeChecker::isScalar($currentToken->getCode())) {
            $result = new ScalarPoint($currentToken->getCode(), $currentToken->getValue());
            if (!$this->iterator->isEnd()) {
                $this->iterator->next();
            }
            return $result;
        } else {
            if (TokenAndProcessCodeChecker::isVariable($currentToken->getCode())) {
                $nextToken = $this->iterator->getNextToken();
                if (!empty($nextToken) && TokenAndProcessCodeChecker::isOpenBracket($nextToken->getCode())) {
                    return $this->functionBuild();
                } else {
                    $result = new ScalarPoint($currentToken->getCode(), $currentToken->getValue());
                    if (!$this->iterator->isEnd()) {
                        $this->iterator->next();
                    }
                    return $result;
                }
            }
        }

        throw new ParseErrorException("Unknown token exception {$currentToken->getCode()}");
    }

    /**
     * @return Point
     * @throws \Exception
     */
    private function functionBuild(): Point
    {
        $point = new FunctionPoint($this->iterator->getCurrent()->getCode());
        $point->setFnName($this->iterator->getCurrent()->getValue());
        //Прешли на открывающую скобку
        $this->iterator->next();
        $this->iterator->next();
        $point->setParams($this->quotForFunctionBuild());
        //Перешли c закрывающей скобки
        if (!$this->iterator->isEnd()) {
            $this->iterator->next();
        }

        return $point;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function quotForFunctionBuild(): array
    {
        $result = [];
        $result[] = $this->orBuild();
        while (TokenAndProcessCodeChecker::isQuot($this->iterator->getCurrent()->getCode())) {
            $this->iterator->next();
            $result[] = $this->orBuild();
        }

        return $result;
    }

}
