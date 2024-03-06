<?php

namespace Render;

use Render\Interface\HTTPRenderer;

class PlainTextRenderer implements HTTPRenderer
{
    private int $statusCode = 200;
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function isStringContent(): bool
    {
        return true;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getFields(): array
    {
        return [
            'Content-Type' => 'text/plain',
        ];
    }

    public function getContent(): string
    {
        return $this->text;
    }
}
