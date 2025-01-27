<?php

namespace App\Handler;

interface HandlerInterface
{
    public function handle(...$args): array;
}