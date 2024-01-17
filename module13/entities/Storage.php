<?php

namespace Entities\Storage;

include_once 'TelegraphText.php';

use Entities\TelegraphText as TT;

abstract class Storage
{
    abstract public function create(object $payload): string;

    abstract public function read(string $slug): ?TT\TelegraphText;

    abstract public function update(string $slug, object $payload): void;

    abstract public function delete(string $slug): void;

    abstract public function list(): array;
}