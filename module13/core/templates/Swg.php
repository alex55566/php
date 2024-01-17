<?php

namespace Templates\Swig;
class Swig extends View
{
    public function render(TelegraphText $telegraphText): ?string
    {
        $content = $this->loadTemplateContent();

        if (!is_null($content)) {
            foreach ($this->variables as $key) {
                $content = str_replace('{{ ' . $key . ' }}', $telegraphText->$key, $content);
            }

            return $content;
        }

        return null;
    }
}