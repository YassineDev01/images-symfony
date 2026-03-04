<?php

namespace App\DTO;
class CategoryDto
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?bool $isActive = null,
    ) {
    }
}