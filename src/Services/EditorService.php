<?php

namespace Services;

use Database\DatabaseHelper;
use Exceptions\InternalServerException;
use Http\HttpRequest;
use Settings\Settings;
use Validate\ValidationHelper;

class EditorService
{
    public function getEditorPageName(): string
    {
        return 'editor';
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

    private function generateUniqueHashWithLimit(string $data, $limit = 100): string
    {
        $hash = hash('sha256', $data);
        $counter = 0;
        while ($counter < $limit) {
            $registeredColumns = DatabaseHelper::getSnippetAndLanguageByHashValue($hash);
            if (is_null($registeredColumns)) {
                return $hash;
            }
            $counter++;
            $hash = hash('sha256', $data . $counter);
        }
        throw new InternalServerException('Failed to generate unique hash value.');
    }
}
