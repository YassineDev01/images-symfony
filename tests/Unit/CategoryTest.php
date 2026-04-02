<?php

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCategory()
    {
        $category = new Category();
        $nomCategory = 'TestC';

        $category->setNameCategory($nomCategory);

        self::assertSame($nomCategory, $category->getNameCategory());
    }

    public function testDate()
    {
        $category = new Category();

        $date = new \DateTimeImmutable();

        $category->setUpdatedAt($date);

        self::assertSame($date , $category->getUpdatedAt());

       
    }

    public function testImageName()
{
    $category = new Category();
    $imageName = 'image.jpg';

    $category->setImageName($imageName);

    self::assertSame($imageName, $category->getImageName());
}


}