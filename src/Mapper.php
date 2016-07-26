<?php
/*
 * This file is part of the mapper-php.
 *
 * (c) I Know U Will SAS <open@kokoroe.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @namespace
 */
namespace Kokoroe\Component\Mapper;

use ReflectionClass;
use InvalidArgumentException;
use RuntimeException;

/**
 * Mapper
 */
class Mapper
{
    /**
     * Hydrate object with array
     *
     * @param  array  $data
     * @param  string $className The class name
     * @return Object
     */
    public static function hydrate(array $data, $className)
    {
        $class = new ReflectionClass($className);

        $object = $class->newInstance();

        foreach ($data as $key => $value) {
            if ($class->hasMethod('set' . $key)) {
                $method = 'set' . $key;
            } else if ($class->hasMethod('add' . $key)) {
                $method = 'add' . $key;
            } else if (is_numeric($key) && $class->hasMethod('add')) {
                $method = 'add';
            } else {
                if (is_numeric($key)) {
                    throw new RuntimeException(sprintf(
                        'The class %s does not have add() method.',
                        $className
                    ));
                }

                throw new RuntimeException(sprintf(
                    'The class %s does not have a setter for %s property.',
                    $className,
                    $key
                ));
            }

            $parameters = $class->getMethod($method)->getParameters();

            if (!isset($parameters[0])) {
                throw new RuntimeException(sprintf(
                    'The method %s::%s() does not have a parameter.',
                    $className,
                    $method
                ));
            }

            $parameterType = $parameters[0]->getClass();

            if (!empty($parameterType) && is_array($value)) {
                $value = self::hydrate($value, $parameterType->name);
            }

            $object->{$method}($value);
        }

        return $object;
    }
}
