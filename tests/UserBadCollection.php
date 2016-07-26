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

use ArrayObject;

class UserBadCollection
{
    protected $id;

    protected $name;

    protected $articles;

    public function setArticles(ArrayObject $articles)
    {
        $this->articles = $articles;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
