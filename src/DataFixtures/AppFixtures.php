<?php

namespace App\DataFixtures;

use App\Entity\Store\Brand;
use App\Entity\Store\Color;
use App\Entity\Store\Image;
use App\Entity\Store\Product;
use App\Entity\User;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadImages();
        $this->loadBrands();
        $this->loadColors();
        $this->loadProducts();
        $this->loadComments();

        $this->manager->flush();
    }
    private function loadImages(): void
    {
        for ($i = 1; $i < 15; $i++) {
            $image = (new Image())
                ->setUrl('shoe-'.$i.'.jpg')
                ->setAlt('image '.$i);

            $this->manager->persist($image);
            $this->addReference('image'.$i, $image);
        }
    }

    private function loadBrands(): void
    {
        $brands = [
            'Adidas',
            'Nike',
            'Puma',
            'Asics',
        ];

        foreach ($brands as $key => $name) {
            $brand = (new Brand())->setName($name);

            $this->manager->persist($brand);
            $this->addReference('brand'.$key, $brand);
        }
    }

    public function utilisateurs(UserPasswordEncoderInterface $encoder): void
    {
        for($i=0;$i<15;$i++){
        $user = new User();
        $plainPassword = 'mexicanito'.$i;
        $encoded = $encoder->encodePassword($user,$plainPassword);
        $user->setPassword($encoded);
        $user->setUsername('David'.$i);
        }

    }
    

    private function loadColors(): void
    {
        $colors = [
            'Blanc',
            'Noir',
            'Bleu',
            'Jaune',
            'Rouge',
            'Beige',
            'Gris',
        ];

        foreach ($colors as $key => $name) {
            $color = (new Color())->setName($name);

            $this->manager->persist($color);
            $this->addReference('color'.$key, $color);
        }
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i < 15; $i++) {
            $product = (new Product())
                ->setName('Product '.$i)
                ->setSlug('product-'.$i)
                ->setDescription('Produit de description '.$i)
                ->setLongDescription('Longue description du produit '.$i)
                ->setPrice(mt_rand(10, 100))
                ->setImage($this->getReference('image'.$i))
                ->setBrand($this->getReference('brand'.random_int(0, 3)))
            ;

            for ($j = 0; $j < random_int(1, 3); $j++) {
                $product->addColor($this->getReference('color'.random_int(0, 6)));
            }

            $this->manager->persist($product);
        }
    }

    private function loadComments():void
    {
        for ($i=1; $i < 15 ; $i++){
            $comment = (new Comment())
                    ->setIdProduit(random_int(1,14))
                    ->setPseudo('user: '.$i)
                    ->setMessage("nuevo mensaje numero ".$i)
                    ;
                    $this->manager->persist($comment);
        }
    }
}