<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Role;

class UserFixtures extends Fixture
{
public function load(ObjectManager $manager)
{
// Créez un rôle
$role = new Role();
$role->setName('ROLE_ADMIN');
$manager->persist($role);

// Créez un utilisateur
$user = new User();
$user->setNom('John Doe');
$user->setMail('john@example.com');
$user->setMdp('password');
$user->setRole($role);

$manager->persist($user);
$manager->flush();
}
}
