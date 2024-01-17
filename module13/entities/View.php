<?php

namespace Entities\View;

include_once './interfaces/IRender.php';

use Interfaces\IRender as IR;

abstract class View implements IR\IRender
{
    protected array $variables = [];
    protected string $templateName;

    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    public function loadTemplateContent(): ?string
    {
        $filePath = sprintf('templates/%s', $this->templateName);
        if (file_exists($filePath)) {
            return file_get_contents($filePath);

        }
        return null;
    }

    public function addVariablesToTemplate(array $variables): void
    {
        $this->variables = $variables;
    }
}