<?php

namespace Pleskachov\PhpPro\Shortener;

use Pleskachov\PhpPro\Shortener\Exceptions\DataNotFoundException;
use Pleskachov\PhpPro\Shortener\Interfaces\ICodeRepository;
use Pleskachov\PhpPro\Shortener\ValueObject\UrlCodePair;

class FileRepository implements ICodeRepository
{
    protected string $fileDb;
    protected array $db = [];


    public function __destruct()
    {
        $this->writeFile(json_encode($this->db));
    }

    public function __construct(string $fileDb)
    {
        $this->fileDb = $fileDb;
        $this->getDBFromStorage();
    }

    public function saveEntity(UrlCodePair $urlCodePair): bool
    {
        $this->db[$urlCodePair->getCode()] = $urlCodePair->getUrl();
        return true;
    }

    public function codeIsset(string $code): bool
    {
        return isset($this->db[$code]);
    }

    /**
     * @param string $code
     * @return string
     * @throws DataNotFoundException
     */
    public function getUrlByCode(string $code): string
    {
        if (!$this->codeIsset($code)) {
            throw new DataNotFoundException();
        }
        return $this->db[$code];
    }

    /**
     * @param string $url
     * @return string
     * @throws DataNotFoundException
     */
    public function getCodeByUrl(string $url): string
    {
        if (!$code = array_search($url ,$this->db)) {
            throw new DataNotFoundException();
        }
        return $code;
    }

    protected function writeFile(string $content): void
    {
        $file = fopen($this->fileDb, 'w+');
        fwrite($file, $content);
        fclose($file);
    }

    protected function getDBFromStorage()
    {
        if (file_exists($this->fileDb)) {
            $content = file_get_contents($this->fileDb);
            $this->db = (array)json_decode($content, 'true');
        }
    }





}