<?php

use Database\DatabaseHelper;
use Validate\ValidationHelper;
use Render\HTTPRenderer;
use Render\HTMLRenderer;
use Render\JSONRenderer;

return [
    'TextSnippetSharingService/editor' => function (): HTTPRenderer {
        $part = DatabaseHelper::getRandomComputerPart();
        return new JSONRenderer(['part' => $part]);
    },
    'TextSnippetSharingService/snippet?id=<hash>' => function (): HTTPRenderer {
        $id = ValidationHelper::integer($_GET['id'] ?? null);
        $part = DatabaseHelper::getComputerPartById($id);
        return new HTMLRenderer('component/part', ['part' => $part]);
    },
];
