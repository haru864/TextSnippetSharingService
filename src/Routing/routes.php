<?php

use Controllers\EditorController;
use Controllers\StaticFileController;
use Http\HttpRequest;
use Services\EditorService;
use Services\StaticFileService;
use Settings\Settings;

$httpRequest = new HttpRequest();
$editorService = new EditorService();
$staticFileService = new StaticFileService();
$editorController = new EditorController($editorService, $httpRequest);
$staticFileController = new StaticFileController($staticFileService, $httpRequest);

$URL_DIR_PATTERN_GET_EDITOR = Settings::env("URL_DIR_PATTERN_GET_EDITOR");
$URL_DIR_PATTERN_GET_SNIPPET = Settings::env("URL_DIR_PATTERN_GET_SNIPPET");
$URL_DIR_PATTERN_STATIC_FILE = Settings::env("URL_DIR_PATTERN_STATIC_FILE");

return [
    $URL_DIR_PATTERN_GET_EDITOR => $editorController,
    $URL_DIR_PATTERN_GET_SNIPPET => $editorController,
    $URL_DIR_PATTERN_STATIC_FILE => $staticFileController
];
