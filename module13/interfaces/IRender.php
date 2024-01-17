<?php

namespace Interfaces\IRender;

interface IRender
{
    public function render(TelegraphText $telegraphText): ?string;
}