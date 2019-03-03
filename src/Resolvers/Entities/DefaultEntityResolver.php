<?php

namespace Devian\ExpressionLanguage\Resolvers\Entities;

use Devian\ExpressionLanguage\Exceptions\EntityAlreadyExistsException;
use Devian\ExpressionLanguage\Exceptions\RuntimeErrorException;

/**
 * Class DefaultVariableResolver
 * @package Devian\ExpressionLanguage
 */
class DefaultEntityResolver implements EntityResolverInterface
{

    private $entities = [];

    /**
     * @param $code
     * @param $entity
     * @throws EntityAlreadyExistsException
     */
    public function registerEntity($code, $entity)
    {
        if (isset($this->entities[$code])) {
            throw new EntityAlreadyExistsException("Entity with code {$code}, already exists");
        }
        $this->entities[$code] = $entity;
    }

    /**
     * @param array $entities
     * @throws EntityAlreadyExistsException
     */
    public function registerEntities(array $entities)
    {
        foreach ($entities as $code => $entity) {
            if (isset($this->entities[$code])) {
                throw new EntityAlreadyExistsException("Entity with code {$code}, already exists");
            }
            $this->entities[$code] = $entity;
        }
    }

    /**
     * @param string $code
     *
     * return mixed
     * @throws RuntimeErrorException
     */
    public function getValue($code)
    {
        if (isset($this->entities[$code])) {
            return $this->entities[$code];
        }
        $path = explode('.', $code);
        $base = array_shift($path);
        if (!isset($this->entities[$base])) {
            throw new RuntimeErrorException("Unknown entity with base code {$base}");
        }

        $entity = $this->entities[$base];
        foreach ($path as $position => $point) {
            if (is_object($entity)) {
                $entity = $this->getObjectProperty($entity, $point, $position, $code);
            } elseif (is_array($entity)) {
                $entity = $this->getArrayProperty($entity, $point, $position, $code);
            } else {
                throw new RuntimeErrorException("Unsupported format for using nested path at {$base} by code {$code}");
            }
        }

        return $entity;
    }

    /**
     * @param \object $entity
     * @param string $property
     * @param int $position Передаём для более правильного отображения ошибки
     * @param string $code Передаём для более правильного отображения ошибки
     * @return mixed
     * @throws RuntimeErrorException
     * @throws \Exception
     */
    private function getObjectProperty($entity, $property, $position, $code)
    {
        $ref = new \ReflectionClass($entity);
        if($ref->hasProperty($property)){
            $prop = $ref->getProperty($property);
            if($prop->isPublic()){
                $prop->getValue($entity);
            }else{
                $getter = 'get' . ucfirst($property);
                if (method_exists($entity, $getter)) {
                    return call_user_func([$entity, $getter]);
                }
            }
        }

        throw new RuntimeErrorException("Unknown object property {$property} for code {$code}, position - {$position}");
    }

    /**
     * @param array $entity
     * @param string $property
     * @param int $position Передаём для более правильного отображения ошибки
     * @param string $code Передаём для более правильного отображения ошибки
     * @return mixed
     * @throws RuntimeErrorException
     */
    private function getArrayProperty($entity, $property, $position, $code)
    {
        if (isset($entity[$property])) {
            return $entity[$property];
        }

        throw new RuntimeErrorException("Unknown array property {$property} for code {$code}, position - {$position}");
    }

}
