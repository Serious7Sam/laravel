<?php

namespace Tests\Unit\Entity;

use Illuminate\Database\Eloquent\Model;

trait EntityTestCaseTrait
{
    /**
     * @param Model $entity
     * @param array $properties
     */
    public function assertPropertyAccessors(Model $entity, array $properties)
    {
        foreach ($properties as $name => $value) {
            $setter = 'set' . ucfirst($name);
            $getter = 'get' . ucfirst($name);
            $isGetter = 'is' . ucfirst($name);

            if (method_exists($entity, $setter)) {
                $entity->{$setter}($value);
            } else {
                $reflectionClass = new \ReflectionClass($entity);
                $reflectionProperty = $reflectionClass->getProperty('attributes');
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($entity, [$name => $value]);
            }

            if (method_exists($entity, $getter)) {
                \PHPUnit_Framework_TestCase::assertEquals($value, $entity->{$getter}());
            } else {
                \PHPUnit_Framework_TestCase::assertEquals($value, $entity->{$isGetter}());
            }
        }
    }
}
