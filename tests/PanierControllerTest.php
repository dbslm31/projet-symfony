<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PanierControllerTest extends WebTestCase
{
public function testAjouterAuPanier(): void
{
$client = static::createClient();

// Faites une requête pour ajouter un produit au panier
$client->request('GET', '/panier/ajouter/1'); // Assurez-vous d'ajuster l'ID du produit en conséquence

// Vérifiez si la réponse est réussie (code 200)
$this->assertResponseIsSuccessful();

// Vérifiez si la redirection vers la page du produit est correcte
$this->assertResponseRedirects('/page_du_produit/1'); // Assurez-vous d'ajuster l'ID du produit en conséquence
}

public function testVoirPanier(): void
{
$client = static::createClient();

// Faites une requête pour voir le panier
$client->request('GET', '/panier');

// Vérifiez si la réponse est réussie (code 200)
$this->assertResponseIsSuccessful();

// Vérifiez si le contenu de la page est correct
$this->assertSelectorTextContains('h1', 'Votre Panier');
}
}
