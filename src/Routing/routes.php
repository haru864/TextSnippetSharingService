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
    'TextSnippetSharingService/snippet' => function (): HTTPRenderer {
        $id = ValidationHelper::string($_GET['id'] ?? null);
        $part = DatabaseHelper::getSnippetById($id);
        return new HTMLRenderer('component/part', ['part' => $part]);
    },
];
