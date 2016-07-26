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

class Article
{
    protected $title;

    protected $content;

    protected $author;

    protected $tags = [];

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }
}
