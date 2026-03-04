<?php

namespace App\DTO;

class ProductDto
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?bool $isActive = null,
        public ?bool $stock = null,
        public ?array $images = null,
    ) {
    }
}