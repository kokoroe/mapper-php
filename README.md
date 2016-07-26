# Mapper PHP

[![Build Status](https://img.shields.io/travis/kokoroe/mapper-php/master.svg)](https://travis-ci.org/kokoroe/mapper-php)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/b8262202-4509-47e2-9d3c-3190b30d8527.svg)](https://insight.sensiolabs.com/projects/b8262202-4509-47e2-9d3c-3190b30d8527)
[![Coveralls](https://img.shields.io/coveralls/kokoroe/kokoroe-sdk-php.svg)](https://coveralls.io/github/kokoroe/mapper-php)
[![HHVM](https://img.shields.io/hhvm/kokoroe/mapper-php.svg)](https://travis-ci.org/kokoroe/mapper-php)
[![Packagist](https://img.shields.io/packagist/v/kokoroe/mapper.svg)](https://packagist.org/packages/kokoroe/mapper)

## Install

Add `kokoroe/mapper` to your `composer.json`:

    % php composer.phar require kokoroe/mapper:~1.0

## Usage

~~~php
<?php

require __DIR__ . '/vendor/autoload.php';

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
}

class User
{
    protected $id;

    protected $name;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}


$article = Mapper::hydrate([
    'title' => 'test',
    'content' => 'foo',
    'author' => [
        'id' => 1,
        'name' => 'Axel'
    ],
    'tags' => ['test', 'mapping']
], Article::class);

var_dump($article);
~~~

## License

mapper-php is licensed under [the MIT license](LICENSE.md).


