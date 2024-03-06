<?php

namespace Services;

use Exceptions\InternalServerException;
use Exceptions\InvalidUmlException;
use Models\PlantUMLDiagramGenerator;
use Settings\Settings;

class EditorService
{
    public function __construct()
    {
    }

    public function getEditorPageName(): string
    {
        return 'editor';
    }

    public function generateDiagram(string $uml, string $extension): string
    {
        try {
            $diagramGenerator = new PlantUMLDiagramGenerator();
            $imagaFilePath = $diagramGenerator->generateDiagram($uml, $extension);
            return $imagaFilePath;
        } catch (InvalidUmlException) {
            // 操作性を確保するため、UMLの構文が誤っている場合は例エラーではなく専用の画像ファイルを返す。
            $invalidUmlErrorImageFilePath = Settings::env('UML_ERROR_IMAGE_FILE_PATH');
            $invalidUmlErrorImageFileName = basename($invalidUmlErrorImageFilePath);
            $tmpDirPath = Settings::env('TMP_FILE_LOCATION');
            $tmpInvalidUmlErrorImageFilePath = $tmpDirPath . DIRECTORY_SEPARATOR . $invalidUmlErrorImageFileName;
            if (!copy($invalidUmlErrorImageFilePath, $tmpInvalidUmlErrorImageFilePath)) {
                throw new InternalServerException('Failed to copy UML syntax error image.');
            }
            return $tmpInvalidUmlErrorImageFilePath;
        }
    }
}
