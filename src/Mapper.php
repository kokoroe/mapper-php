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
     * @param  bool   $ignore    Ignore fail to mapping key
     * @return Object
     */
    public static function hydrate(array $data, $className, $ignore = false)
    {
        $class = new ReflectionClass($className);

        $object = $class->newInstance();

        foreach ($data as $key => $value) {
            $methodName = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if (is_null($value)) {
                continue;
            }

            if ($class->hasMethod('set' . $methodName)) {
                $method = 'set' . $methodName;
            } else if ($class->hasMethod('add' . $methodName)) {
                $method = 'add' . $methodName;
            } else if (is_numeric($key) && $class->hasMethod('add')) {
                $method = 'add';
            } else {
                if ($ignore) {
                    continue;
                }

                if (is_numeric($key)) {
                    throw new RuntimeException(sprintf(
                        'The class %s does not have add() method.',
                        $className
                    ));
                }

                throw new RuntimeException(sprintf(
                    'The class %s does not have a setter for %s property.',
                    $className,
                    lcfirst($methodName)
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
