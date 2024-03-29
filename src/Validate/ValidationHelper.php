<?php

namespace Validate;

use Exceptions\InvalidContentTypeException;
use Exceptions\InvalidRequestParameterException;
use Exceptions\InvalidRequestMethodException;

class ValidationHelper
{
    public static function getAvailableLanguages(): array
    {
        return [
            'plaintext',
            'cpp',
            'csharp',
            'dart',
            'go',
            'java',
            'javascript',
            'kotlin',
            'objective-c',
            'perl',
            'php',
            'python',
            'r',
            'ruby',
            'rust',
            'scala',
            'swift',
            'typescript'
        ];
    }

    public static function validateRegisterSnippetRerquest(): void
    {
        $expectedContentType = 'application/x-www-form-urlencoded';
        if ($_SERVER['CONTENT_TYPE'] !== $expectedContentType) {
            throw new InvalidContentTypeException("Content-Type must be '{$expectedContentType}'.");
        }
        $requiredParams = ['snippet', 'language', 'term_minute'];
        foreach ($requiredParams as $requiredParam) {
            if (!isset($_POST[$requiredParam])) {
                throw new InvalidRequestParameterException("Request parameter must contain " . implode(", ", $requiredParams));
            }
        }
        $snippetColumnMaxSize = 65535;
        if (strlen($_POST['snippet']) > $snippetColumnMaxSize) {
            throw new InvalidRequestParameterException("Snippet is too large. (Must be less than 65,535 bytes)");
        }
        $availableLanguages = ValidationHelper::getAvailableLanguages();
        if (!in_array($_POST['language'], $availableLanguages)) {
            throw new InvalidRequestParameterException(
                "Invalid language.<br>Available languages are here.<br>" . PHP_EOL . implode("<br>", $availableLanguages)
            );
        }
        $availableTermMinute = [10, 60, 1440];
        if (!in_array($_POST['term_minute'], $availableTermMinute)) {
            throw new InvalidRequestParameterException(
                "Invalid term_minute.<br>Select one of the following for the time limit (minutes).<br>" . PHP_EOL . implode("<br>", $availableTermMinute)
            );
        }
    }

    public static function validateGetStaticFileRequest(): void
    {
        $allowedMethod = "GET";
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod !== $allowedMethod) {
            throw new InvalidRequestMethodException("Valid method is {$allowedMethod}, but {$requestMethod} given.");
        }
    }
}
