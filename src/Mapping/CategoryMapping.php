<?php
namespace App\Mapping;
use App\Entity\Category;

class CategoryMapping
{
    public function mapCategoryToDTO(Category $category): array
    {
        return [
            'id' => $category->getId(),
            'name' => $category->getNameCategory(),
            'description' => $category->getDescriptionCategory(),
        ];
    }
}
