<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $c = [
            1 => [
                'nom'=>'Colon Catane',
                'slug' => 'colon catane'
            ],
            2 => [
                'nom'=>'Mikado',
                'slug' => 'mikado'
            ],
            3 => [
                'nom'=>'Loup Garou',
                'slug' => 'loup garou'
            ]
        ];

        foreach ($c as $k =>$value){
            $article = new Article();
            $article->setName($value['nom']);
            $article->setSlug($value['nom']);
            $manager->persist($article);
    }
        $manager->flush();
    }
}