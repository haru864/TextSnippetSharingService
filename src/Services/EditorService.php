<?php

namespace Services;

use Database\DatabaseHelper;
use Exceptions\InternalServerException;
use Exceptions\InvalidRequestURIException;
use Http\HttpRequest;
use Settings\Settings;
use Validate\ValidationHelper;

class EditorService
{
    public function getEditorPageName(): string
    {
        return 'editor';
    }

    public function getSnippetPageName(): string
    {
        return 'snippet';
    }

    public function registerSnippet(HttpRequest $httpRequest): string
    {
        ValidationHelper::validateRegisterSnippetRerquest();
        $snippet = $httpRequest->getTextParam('snippet');
        $language = $httpRequest->getTextParam('language');
        $termMinute = $httpRequest->getTextParam('term_minute');
        $hashValue = $this->generateUniqueHashWithLimit($snippet . $language);
        DatabaseHelper::insertSnippet($hashValue, $snippet, $language, $termMinute);
        $baseURL = Settings::env("BASE_URL");
        $url = "{$baseURL}/{$hashValue}";
        return $url;
    }

    public function getSnippetFromDatabase(string $hashValue): string
    {
        $registeredSnippet = DatabaseHelper::getSnippet($hashValue);
        if (is_null($registeredSnippet)) {
            return new InvalidRequestURIException('The snippet associated with the specified URL does not exist.');
        }
        return $registeredSnippet;
    }

    public function getLanguageFromDatabase(string $hashValue): string
    {
        $registeredLanguage = DatabaseHelper::getLanguage($hashValue);
        if (is_null($registeredLanguage)) {
            return new InvalidRequestURIException('The snippet associated with the specified URL does not exist.');
        }
        return $registeredLanguage;
    }

    private function generateUniqueHashWithLimit(string $data, $limit = 100): string
    {
        $hash = hash('sha256', $data);
        $counter = 0;
        while ($counter < $limit) {
            $registeredSnippet = DatabaseHelper::getSnippet($hash);
            if (is_null($registeredSnippet)) {
                return $hash;
            }
            $counter++;
            $hash = hash('sha256', $data . $counter);
        }
        throw new InternalServerException('Failed to generate unique hash value.');
    }
}
