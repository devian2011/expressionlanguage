<?php

namespace Devian\ExpressionLanguage\Syntax;

use Devian\ExpressionLanguage\Lexers\Token;

/**
 * Class SyntaxPoint
 * @package AppBundle\Core\ExpressionLanguage\Syntax
 */
class OperationPoint extends Point
{
    /**
     * @var Point
     */
    private $left;

    /**
     * @var Point
     */
    private $right;


    public function __construct(string $code, Point $left, Point $right)
    {
        parent::__construct($code);
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * @return Point
     */
    public function getLeft(): Point
    {
        return $this->left;
    }

    /**
     * @param Point $left
     */
    public function setLeft(Point $left): void
    {
        $this->left = $left;
    }

    /**
     * @return Point
     */
    public function getRight(): Point
    {
        return $this->right;
    }

    /**
     * @param Point $right
     */
    public function setRight(Point $right): void
    {
        $this->right = $right;
    }



}
