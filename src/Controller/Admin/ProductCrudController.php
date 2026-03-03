<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Controller\Admin\ProductImageCrudController;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;




class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextareaField::new('description'),
            BooleanField::new('isActive'),
            BooleanField::new('stock'),
            AssociationField::new('category')
                ->setFormTypeOption('choice_label', 'nameCategory'),        


            CollectionField::new('productImages')
                ->useEntryCrudForm(ProductImageCrudController::class)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('isActive')
            ->add('stock')
            ->add(EntityFilter::new('category'));


    
    }
}