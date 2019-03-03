<?php

namespace Devian\ExpressionLanguage;

use Devian\ExpressionLanguage\Interpreter\Interpreter;
use Devian\ExpressionLanguage\Lexers\Lexer;
use Devian\ExpressionLanguage\Resolvers\Entities\EntityResolverInterface;
use Devian\ExpressionLanguage\Resolvers\Functions\FunctionsAndOperations;
use Devian\ExpressionLanguage\Syntax\Syntaxer;

/**
 * Class ExpressionLanguage
 * @package AppBundle\Core\ExpressionLanguage
 */
class ExpressionLanguage
{
    /**
     * @var Lexer
     */
    private $lexer;

    /**
     * @var Syntaxer
     */
    private $syntax;

    /**
     * @var EntityResolverInterface
     */
    private $variableResolver;

    /**
     * @var FunctionsAndOperations
     */
    private $functionHolder;

    /**
     * ExpressionLanguage constructor.
     * @param EntityResolverInterface $resolver
     * @throws \Exception
     */
    public function __construct(EntityResolverInterface $resolver)
    {
        $this->lexer = new Lexer();
        $this->syntax = new Syntaxer();
        $this->variableResolver = $resolver;
        $this->functionHolder = new FunctionsAndOperations();
    }

    /**
     * @param $name
     * @param callable $function
     * @throws \Exception
     */
    public function addFunction($name, callable $function)
    {
        $this->functionHolder->addFunctionOrOperation($name, $function);
    }

    /**
     * @param string $expression
     * @throws \Exception
     */
    public function execute(string $expression)
    {
        $syntaxTree = $this->parse($expression);
        $interpreter = new Interpreter($syntaxTree, $this->functionHolder, $this->variableResolver);

        return $interpreter->execute();
    }

    /**
     * @param $expression
     * @return Syntax\Point
     * @throws \Exception
     */
    public function parse($expression)
    {
        $parsedTokens = $this->lexer->parse($expression);
        return $this->syntax->getSyntaxTree($parsedTokens);
    }

}
