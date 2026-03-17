<?php

namespace App\Mapping;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\UrlHelper;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ProductMapping
{
   public function __construct(
        private readonly UploaderHelper $uploaderHelper,
        private readonly UrlHelper $urlHelper,
        ) {
    }
public function mapProductToDTO(Product $product): array
    {
        
        $images = [];

        foreach ($product->getProductImages() as $image) {
             $path = $this->uploaderHelper->asset($image, 'imageFile') ;
             if ($path){
                $images[]= $this->urlHelper->getAbsoluteUrl($path);

             }
           
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