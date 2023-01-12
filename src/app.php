<?php

use GuzzleHttp\Client;
use Pleskachov\PhpPro\Shortener\FileRepository;
use Pleskachov\PhpPro\Shortener\Helpers\UrlValidator;
use Pleskachov\PhpPro\Shortener\UrlConverter;

require_once "vendor/autoload.php";

$config = [
  'dbFile' => __DIR__ . '/../storage/db.json',
  'codeLength' => 10,
];

$fileRepository = new FileRepository($config['dbFile']);
$urlValidator = new UrlValidator(new Client());
$converter = new UrlConverter($urlValidator, $fileRepository, $config['codeLength']);

$url = 'https://www.w3schools.com';
$code = $converter->encode($url);
$urlDecode = $converter->decode($code);

echo $code . PHP_EOL;
echo $urlDecode . PHP_EOL;


exit;
