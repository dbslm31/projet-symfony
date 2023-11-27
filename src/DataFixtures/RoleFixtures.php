<?php

// src/DataFixtures/RoleFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Role;

class RoleFixtures extends Fixture
{
public function load(ObjectManager $manager)
{
// Créez un rôle "admin"
$adminRole = new Role();
$adminRole->setNom('ROLE_ADMIN');
$adminRole->setPoids(1);
$manager->persist($adminRole);

// Créez un rôle "client"
$clientRole = new Role();
$clientRole->setNom('ROLE_CLIENT');
$clientRole->setPoids(2);
$manager->persist($clientRole);

$manager->flush();
}
}
