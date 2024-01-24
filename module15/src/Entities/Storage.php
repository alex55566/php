<?php

namespace App\Entities;

abstract class Storage
{
    abstract public function create(object $payload): string;

    abstract public function read(string $slug): ?TelegraphText;

    abstract public function update(string $slug, object $payload): void;

    abstract public function delete(string $slug): void;

    abstract public function list(): array;
}