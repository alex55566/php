<?php

namespace Entities\User;

abstract class User
{
    protected string $id;
    protected string $name;
    protected string $role;

    abstract public function getTextsToEdit(): void;
}