<?php

use Database\DatabaseHelper;
use Validate\ValidationHelper;
use Render\interface\HTTPRenderer;
use Render\HTMLRenderer;
use Render\JSONRenderer;

return [
    'TextSnippetSharingService/editor' => function (): HTTPRenderer {
        return new HTMLRenderer('editor', []);
    },
    'TextSnippetSharingService/register' => function (): HTTPRenderer {
        $snippet = ValidationHelper::string($_POST['snippet'] ?? null);
        $language = ValidationHelper::string($_POST['language'] ?? null);
        $hash_value = hash('sha256', $snippet);
        DatabaseHelper::insertSnippet($hash_value, $snippet, $language);
        $url = "http://localhost:8000/TextSnippetSharingService/display?hash={$hash_value}";
        return new JSONRenderer(['url' => $url]);
    },
    'TextSnippetSharingService/display' => function (): HTTPRenderer {
        $id = ValidationHelper::string($_GET['hash'] ?? null);
        $part = DatabaseHelper::getSnippetById($id);
        return new HTMLRenderer('component/part', ['part' => $part]);
    },
];
