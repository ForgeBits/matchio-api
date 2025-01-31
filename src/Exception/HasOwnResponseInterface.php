<?php

namespace App\Exception;

interface HasOwnResponseInterface
{
    public function getResponse(): array;
}