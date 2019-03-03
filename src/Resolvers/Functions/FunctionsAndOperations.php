<?php

namespace Devian\ExpressionLanguage\Resolvers\Functions;

use Devian\ExpressionLanguage\Exceptions\RuntimeErrorException;
use Devian\ExpressionLanguage\Resolvers\Functions\operations\Equality;
use Devian\ExpressionLanguage\Resolvers\Functions\operations\Logic;
use Devian\ExpressionLanguage\Resolvers\Functions\operations\Math;
use Devian\ExpressionLanguage\Resolvers\Functions\stlfunctions\StlMath;
use Devian\ExpressionLanguage\Resolvers\Functions\stlfunctions\StlString;

/**
 * Class FunctionsAndOperations
 * @package Devian\ExpressionLanguage\Resolvers\Functions
 */
class FunctionsAndOperations
{

    /**
     * @var callable[]
     */
    private $functionsAndOperations = [];

    /**
     * FunctionsAndOperations constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->loadBaseOperationsAndFunctions();
    }

    /**
     * @throws \Exception
     */
    private function loadBaseOperationsAndFunctions()
    {
        $equality = Equality::getOperations();
        $math = Math::getOperations();
        $logic = Logic::getOperations();
        $stlMath = StlMath::getFunctions();
        $stlString = StlString::getFunctions();

        $allFunctions = array_merge($equality, $math, $logic, $stlMath, $stlString);
        foreach ($allFunctions as $key => $value) {
            $this->addFunctionOrOperation($key, $value);
        }
    }

    /**
     * @param string $name
     * @param callable $function
     * @throws \Exception
     */
    public function addFunctionOrOperation($name, callable $function)
    {

        if (isset($this->functionsAndOperations[$name])) {
            throw new RuntimeErrorException("Function or operation with name: {$name} already exists");
        }
        $this->functionsAndOperations[$name] = $function;
    }

    /**
     * @param $name
     * @return callable
     * @throws \Exception
     */
    public function getFunction($name)
    {
        if (!isset($this->functionsAndOperations[$name])) {
            throw new RuntimeErrorException("Unknown operation or function {$name}");
        }
        return $this->functionsAndOperations[$name];
    }

}
