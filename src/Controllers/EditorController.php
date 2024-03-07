<?php

namespace Controllers;

use Controllers\Interface\ControllerInterface;
use Exceptions\InvalidRequestMethodException;
use Services\EditorService;
use Http\HttpRequest;
use Render\interface\HTTPRenderer;
use Render\HTMLRenderer;
use Render\PlainTextRenderer;
use Validate\ValidationHelper;

class EditorController implements ControllerInterface
{
    private EditorService $editorService;
    private HttpRequest $httpRequest;

    public function __construct(EditorService $editorService, HttpRequest $httpRequest)
    {
        $this->editorService = $editorService;
        $this->httpRequest = $httpRequest;
    }

    public function assignProcess(): HTTPRenderer
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'GET' && $this->httpRequest->getTopDir() === '') {
            return $this->getEditorPage();
        } else if ($requestMethod === 'GET' && $this->httpRequest->getTopDir() !== '') {
            return $this->getSnippetPage();
        } else if ($requestMethod === 'POST') {
            return $this->registerSnippet();
        } else {
            throw new InvalidRequestMethodException("Invalid request method: 'GET' or 'POST' are allowed.");
        }
    }

    private function getEditorPage(): HTMLRenderer
    {
        $editorFileBasename = $this->editorService->getEditorPageName();
        $languages = ValidationHelper::getAvailableLanguages();
        return new HTMLRenderer(200, $editorFileBasename, ['languages' => $languages]);
    }

    private function registerSnippet(): PlainTextRenderer
    {
        $url = $this->editorService->registerSnippet($this->httpRequest);
        return new PlainTextRenderer($url);
    }

    private function getSnippetPage()
    {
        include(__DIR__ . '/../Batch/DeleteExpiredRecords.php');
        $snippetFileBasename = $this->editorService->getSnippetPageName();
        $snippet = $this->editorService->getSnippetFromDatabase($this->httpRequest->getTopDir());
        $language = $this->editorService->getLanguageFromDatabase($this->httpRequest->getTopDir());
        return new HTMLRenderer(200, $snippetFileBasename, ['snippet' => $snippet, 'language' => $language]);
    }
}
