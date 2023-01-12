<?php

namespace Pleskachov\PhpPro\Shortener;

use Pleskachov\PhpPro\Shortener\Exceptions\DataNotFoundException;
use Pleskachov\PhpPro\Shortener\Interfaces\ICodeRepository;
use Pleskachov\PhpPro\Shortener\Interfaces\IUrlValidator;
use InvalidArgumentException;
use Pleskachov\PhpPro\Shortener\ValueObject\UrlCodePair;

class UrlConverter implements Interfaces\IUrlDecoder, Interfaces\IUrlEncoder
{
    const CODE_LENGTH = 8;
    const CODE_CHAIRS = '0123456789abcdefghijklmnoprstuywxyz';

    protected IUrlValidator $validator;
    protected ICodeRepository $repository;
    protected int $codeLength;

    /**
     * @param IUrlValidator $validator
     * @param ICodeRepository $repository
     * @param int $codeLength
     */
    public function __construct(IUrlValidator $validator, ICodeRepository $repository, int $codeLength)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->codeLength = $codeLength;
    }

    /**
     * @inheritDoc
     */
    public function decode(string $code): string
    {
        try {
            $code = $this->repository->getUrlByCode($code);
        } catch (DataNotFoundException $e) {
            throw new \InvalidArgumentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious(),
            );
        }
        return $code;
    }

    public function encode(string $url): string
    {
        $this->validateUrl($url);
        try {
            $code = $this->repository->getCodeByUrl($url);
        } catch (DataNotFoundException $e) {
            $code = $this->generateAndSaveCode($url);
        }
        return $code;
    }

    protected function generateAndSaveCode(string $url): string
    {
        $code = $this->generateUniqueCode();
        $this->repository->saveEntity(new UrlCodePair($code, $url));
        return $code;
    }

    protected function generateUniqueCode(): string
    {
        $date = new \DateTime();
        $str = static::CODE_CHAIRS . mb_strtoupper(static::CODE_CHAIRS) . $date->getTimestamp();
        return substr(str_shuffle($str), 0, $this->codeLength);
    }

    protected function validateUrl(string $url): bool
    {
        try {
            $result = $this->validator->validateUrl($url);
        }
        catch (DataNotFoundException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
        return $result;
    }

}