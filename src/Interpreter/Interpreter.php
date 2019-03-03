<?php

namespace Devian\ExpressionLanguage\Interpreter;

use Devian\ExpressionLanguage\Exceptions\RuntimeErrorException;
use Devian\ExpressionLanguage\Resolvers\Entities\EntityResolverInterface;
use Devian\ExpressionLanguage\Resolvers\Functions\FunctionsAndOperations;
use Devian\ExpressionLanguage\Syntax\FunctionPoint;
use Devian\ExpressionLanguage\Syntax\OperationPoint;
use Devian\ExpressionLanguage\Syntax\Point;
use Devian\ExpressionLanguage\Syntax\ScalarPoint;
use Devian\ExpressionLanguage\TokenAndProcessCodeChecker;

/**
 * Class Interpreter
 * @package Devian\ExpressionLanguage\Interpreter
 */
class Interpreter
{

    /**
     * @var Point
     */
    private $syntaxTree;

    /**
     * @var FunctionsAndOperations
     */
    private $functionsAndOperations;

    /**
     * @var EntityResolverInterface
     */
    private $entityResolvers;

    /**
     * Interpreter constructor.
     * @param Point $point
     */
    public function __construct(Point $syntaxTree, FunctionsAndOperations $functionsAndOperations, EntityResolverInterface $resolver)
    {
        $this->syntaxTree = $syntaxTree;
        $this->functionsAndOperations = $functionsAndOperations;
        $this->entityResolvers = $resolver;
    }

    /**
     * @return mixed|void
     * @throws RuntimeErrorException
     */
    public function execute()
    {
        return $this->pointSwitcher($this->syntaxTree);
    }

    /**
     * @param Point $point
     * @return mixed
     * @throws RuntimeErrorException
     * @throws \Exception
     */
    private function pointSwitcher(Point $point)
    {
        if ($point instanceof OperationPoint) {
            return $this->executeOperation($point);
        }
        if ($point instanceof ScalarPoint) {
            return $this->executeScalar($point);
        }
        if ($point instanceof FunctionPoint) {
            return $this->executeFunction($point);
        }

        throw new RuntimeErrorException("Unknown AST point {$point->getCode()}");
    }

    /**
     * @param OperationPoint $point
     * @return mixed
     * @throws \Exception
     */
    private function executeOperation(OperationPoint $point)
    {
        $first = $this->pointSwitcher($point->getLeft());
        $second = $this->pointSwitcher($point->getRight());
        $operation = $this->functionsAndOperations->getFunction($point->getCode());
        return call_user_func($operation, $first, $second);
    }

    /**
     * @param ScalarPoint $point
     * @return mixed
     */
    private function executeScalar(ScalarPoint $point)
    {
        if (TokenAndProcessCodeChecker::isVariable($point->getCode())) {
            return $this->entityResolvers->getValue($point->getValue());
        } else {
            return $point->getValue();
        }
    }

    /**
     * @param FunctionPoint $point
     * @throws \Exception
     */
    private function executeFunction(FunctionPoint $point)
    {
        $function = $this->functionsAndOperations->getFunction($point->getFnName());
        $paramValues = [];
        foreach ($point->getParams() as $param) {
            $paramValues[] = $this->pointSwitcher($param);
        }

        return call_user_func_array($function, $paramValues);
    }

}
