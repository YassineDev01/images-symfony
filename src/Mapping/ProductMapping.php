<?php

namespace App\Mapping;

use App\Entity\Product;

class ProductMapping
{
    public function mapProductToDTO(Product $product): array
    {
        $images = [];

        foreach ($product->getProductImages() as $image) {
            $images[] = '/uploads/product_images/' . $image->getImageName();
        }

        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'isActive' => $product->isActive(),
            'stock' => $product->isStock(),
            'images' => $images
        ];
    }
}