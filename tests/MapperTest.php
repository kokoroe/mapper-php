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
namespace Kokoroe\Component\Mapper\Test;

use Kokoroe\Component\Mapper\Mapper;
use PHPUnit_Framework_TestCase;
use DateTime;

class MapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The class Kokoroe\Component\Mapper\Test\UserBadSetter does not have a setter for id property.
     */
    public function testHydrateWithBadSetter()
    {
        Mapper::hydrate([
            'id' => 1,
            'name' => 'Axel'
        ], UserBadSetter::class);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The class ArrayObject does not have add() method.
     */
    public function testHydrateWithBadCollection()
    {
        Mapper::hydrate([
            'id' => 1,
            'name' => 'Axel',
            'articles' => [
                [
                    'title' => 'foo'
                ]
            ]
        ], UserBadCollection::class);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The method Kokoroe\Component\Mapper\Test\UserBadSetterWithoutParam::setId() does not have a parameter.
     */
    public function testHydrateWithBadSetterWithoutParam()
    {
        Mapper::hydrate([
            'id' => 1,
            'name' => 'Axel'
        ], UserBadSetterWithoutParam::class);
    }

    public function testHydrate()
    {
        $createAt = new DateTime('now');

        $user = Mapper::hydrate([
            'id' => 1,
            'name' => 'Axel',
            'create_at' => $createAt,
            'articles' => [
                [
                    'title' => 'test',
                    'content' => 'foo',
                    'author' => [
                        'id' => 1,
                        'name' => 'Axel'
                    ],
                    'tags' => ['test', 'mapping'],
                    'tag' => 'foo'
                ],
                [
                    'title' => 'test 2',
                    'content' => 'foo 2',
                    'author' => [
                        'id' => 1,
                        'name' => 'Axel'
                    ],
                    'tags' => ['test', 'mapping'],
                    'tag' => 'foo'
                ]
            ]
        ], User::class);

        $this->assertInstanceOf('Kokoroe\Component\Mapper\Test\User', $user);

        $this->assertEquals(1, $user->getId());
        $this->assertInstanceOf('DateTime', $user->getCreateAt());
        $this->assertEquals($createAt, $user->getCreateAt());
    }
}
