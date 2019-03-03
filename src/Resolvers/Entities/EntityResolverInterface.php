<?php
namespace Devian\ExpressionLanguage\Resolvers\Entities;

/**
 * Interface VariableResolverInterface
 * @package Devian\ExpressionLanguage
 */
interface EntityResolverInterface
{

    public function getValue($code);

}
