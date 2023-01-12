<?php

class UrlValidator2
{
    public string $url;

    /**
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function urlValidator()
    {
        if (filter_var($this->url, FILTER_VALIDATE_URL)) {
            echo("$this->url is a valid URL");
        } else {
            echo("$this->url is not a valid URL");
        }
    }

}

$url = "https://www.w3schools.com";

$urlValidator2 = new UrlValidator2($url);
$urlValidator2->urlValidator();