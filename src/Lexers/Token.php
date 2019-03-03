<?php

namespace Devian\ExpressionLanguage\Lexers;

/**
 * Class Token
 * @package AppBundle\Core\ExpressionLanguage\Lexers
 */
class Token
{

    private $position;

    private $code;

    private $value;

    /**
     * Token constructor.
     * @param string $code
     * @param string $value
     * @param int $position
     */
    public function __construct(string $code, string $value, int $position)
    {
        $this->code = $code;
        $this->value = $value;
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


}
