<?php

namespace Controllers;

use Controllers\Interface\ControllerInterface;
use Exceptions\InvalidRequestMethodException;
use Services\EditorService;
use Http\HttpRequest;
use Render\interface\HTTPRenderer;
use Render\HTMLRenderer;
use Render\ImageRenderer;
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
        if ($requestMethod === 'GET') {
            return $this->getEditorPage();
        } else if ($requestMethod === 'POST') {
            return $this->getSnippetUrl();
        } else {
            throw new InvalidRequestMethodException("'GET' or 'POST' are allowed.");
        }
    }

    private function getEditorPage(): HTMLRenderer
    {
        $editorFileBasename = $this->editorService->getEditorPageName();
        return new HTMLRenderer(200, $editorFileBasename, []);
    }

    private function getSnippetUrl(): PlainTextRenderer
    {
        
    }
}
