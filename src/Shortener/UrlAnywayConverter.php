<?php

namespace Pleskachov\PhpPro\Shortener;


use Pleskachov\PhpPro\Shortener\UrlConverter;

class UrlAnywayConverter extends UrlConverter
{
    /**
     * @param string $url
     * @return string
     */

    public function encode(string $url): string
    {
        $this->validateUrl($url);
        return $this->generateAndSaveCode($url);
    }
}