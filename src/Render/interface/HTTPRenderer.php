<?php

namespace Render;

interface HTTPRenderer
{
    public function getFields(): array;
    public function getContent(): string;
}
