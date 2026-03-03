<?php

namespace App\Controller\Admin;

use App\Entity\ProductImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('imageName')
                ->setBasePath('/uploads/products')
                ->setUploadDir('public/uploads/products')
                ->setRequired($pageName === 'new'),

            // Champ caché pour Vich (important)
            TextField::new('imageFile')
                ->onlyOnForms(),
        ];
    }
}