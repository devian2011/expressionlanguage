<?php

namespace Devian\ExpressionLanguage\Syntax;

/**
 * Class FunctionPoint
 * @package AppBundle\Core\ExpressionLanguage\Syntax
 */
class FunctionPoint extends Point
{
    /**
     * @var string
     */
    private $fnName;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @return mixed
     */
    public function getFnName()
    {
        return $this->fnName;
    }

    /**
     * @param mixed $fnName
     */
    public function setFnName($fnName): void
    {
        $this->fnName = $fnName;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void
    {
        $this->params = $params;
    }

}
