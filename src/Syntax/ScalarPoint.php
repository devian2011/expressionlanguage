<?php

namespace Devian\ExpressionLanguage\Syntax;

/**
 * Class ScalarPoint
 * @package AppBundle\Core\ExpressionLanguage\Syntax
 */
class ScalarPoint extends Point
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @inheritDoc
     */
    public function __construct(string $code, $value)
    {
        $this->value = $value;
        parent::__construct($code);
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

}
