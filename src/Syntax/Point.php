<?php

namespace Devian\ExpressionLanguage\Syntax;

/**
 * Class Point
 * @package AppBundle\Core\ExpressionLanguage\Syntax
 */
abstract class Point
{

    /**
     * @var string
     */
    protected $code;

    /**
     * Point constructor.
     * @param Point $parent
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }


}
