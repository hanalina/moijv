<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i< 60; $i++){
            $user = new User();
            $user ->setUsername('user'.$i);
            $user ->setPassword(password_hash('user', PASSWORD_BCRYPT));
            $user ->setEmail('user' .$i. '@fake.fr');
            $user ->setRegisterDate(new \DateTime('-'.$i.' days'));
            $user->setRoles('ROLE_USER');
            
            $this->addReference('user'.$i, $user);
            // $manager persist demande à doctrine de preparer l'insertion de 
            // l'entité en base de données -> INSERT INTO
            $manager ->persist($user);
        }
        
        $admin = new User();
        $admin->setUsername('root');
        $admin->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $admin->setEmail('admin@mail.fr');
        $admin->setRegisterDate(new \DateTime('now'));
        $admin->setRoles('ROLE_ADMIN|ROLE_USER');
        
        $manager->persist($admin);
        // flush() valide les requetes SQL et les execute
        $manager->flush();
    }
}
