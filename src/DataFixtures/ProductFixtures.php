<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Tests\Common\DataFixtures\TestFixtures\UserFixture;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 150; $i ++){
            
            $product = new Product();
            $product->setTitle("Mon produit n°" .$i);
            $product->setDescription("Description de mon produit n°$i");
            
            $product->setOwner($this->getReference(('user'.rand(0,59))));
            $manager->persist($product);
        }

        $manager->flush();
    }
    
    public function getDependencies() :array 
    {
        return [
            UserFixture::class
    ];
    }
}
