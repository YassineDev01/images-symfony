<?php

namespace App\Tests\Unit;

use App\Entity\Product;
use App\Entity\ProductImage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

class ProductTest extends TestCase
{
    /**
     * Exo 1 : Test du setter et getter du nom du Product
     */
    public function testSetName(): void
    {
        // Arrange : création d’un Product et définition d’un nom
        $Product = new Product();
        $nameProduct = 'Product ';

        // Act : on définit le nom
        $Product->setName($nameProduct);

        // Assert : on vérifie que le nom est bien enregistré
        self::assertSame($nameProduct, $Product->getName());
    }

    /**
     * Exo 2 : Test du champ booléen isActive
     */
    public function testIsActive(): void
    {
        // Création d’un Product
        $Product = new Product();

        // On désactive le Product
        $Product->setIsActive(false);

        // Vérifie que isActive retourne bien false
        self::assertFalse($Product->isActive());
    }

    /**
     * Exo 3 : Test que la description peut être null
     */
    public function testDescriptionNullable(): void
    {
        $Product = new Product();

        // On met la description à null
        $Product->setDescription(null);

        // Vérifie que la valeur est bien null
        self::assertNull($Product->getDescription());
    }

    /**
     * Exo 4 : Test du nom de fichier de l'image
     */
    public function testImageName(): void
    {
        $image = new ProductImage();

        // Définition du nom de l'image
        $image->setImageName('photo.jpg');

        // Vérifie que le nom est correctement enregistré
        self::assertSame('photo.jpg', $image->getImageName());
    }

    /**
     * Exo 5 : Test de la relation entre Image et Product
     */
    public function testImageProductRelation(): void
    {
        $image = new ProductImage();
        $Product = new Product();

        // On associe un Product à l’image
        $image->setProduct($Product);

        // Vérifie que la relation est bien définie
        self::assertSame($Product, $image->getProduct());
    }

    /**
     * Exo 6 : Test que setImageFile met à jour la date updatedAt
     */
    public function testSetImageFileUpdatesDate(): void
    {
        $image = new ProductImage();

        // Création d’un fichier temporaire simulant une image
        $tmpFile = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tmpFile, 'fake');

        // Création d’un objet File Symfony
        $file = new File($tmpFile);

        // Vérifie qu’au départ updatedAt est null
        self::assertNull($image->getUpdatedAt());

        // On assigne un fichier à l’image
        $image->setImageFile($file);

        // Vérifie que le fichier est bien enregistré
        self::assertSame($file, $image->getImageFile());

        // Vérifie que la date updatedAt a été mise à jour automatiquement
        self::assertInstanceOf(\DateTimeImmutable::class, $image->getUpdatedAt());

        // Suppression du fichier temporaire pour éviter les fichiers inutiles
        unlink($tmpFile);
    }
}