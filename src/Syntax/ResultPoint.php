<?php

namespace Devian\ExpressionLanguage\Syntax;

/**
 * Class ResultPoint
 * @package AppBundle\Core\ExpressionLanguage\Syntax
 */
class ResultPoint extends Point
{
    /**
     * @var Point[]
     */
    private $points = [];

    /**
     * @param OperationPoint $operationPoint
     */
    public function addPoint(Point $operationPoint)
    {
        $this->points[] = $operationPoint;
    }

    /**
     * @param Point[] $points
     */
    public function setPoints(array $points): void
    {
        $this->points = $points;
    }

}
