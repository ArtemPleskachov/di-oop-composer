<?php

namespace Pleskachov\PhpPro\Shortener\Interfaces;

use Pleskachov\PhpPro\Shortener\ValueObject\UrlCodePair;

interface ICodeRepository
{
    /**
     * @param UrlCodePair $urlCodePair
     * @return bool
     */
    public function saveEntity(UrlCodePair $urlCodePair) : bool;

    /**
     * @param string $code
     * @return bool
     */
    public function codeIsset(string $code): bool;

    /**
     * @param string $code
     * @return string
     */
    public function getUrlByCode(string $code): string;

    /**
     * @param string $url
     * @return string
     */
    public function getCodeByUrl(string $url): string;
}