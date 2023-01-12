<?php

namespace Pleskachov\PhpPro\Shortener\ValueObject;

class UrlCodePair
{
   //Make immutable obj for get and further processing our code and url
    protected string $code;
    protected string $url;

    /**
     * @param string $code
     * @param string $url
     */
    public function __construct(string $code, string $url)
    {
        $this->code = $code;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }



}