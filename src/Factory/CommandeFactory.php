<?php

namespace App\Factory;

use App\Entity\Commande;
use App\Entity\OrderItems;
use App\Entity\Catalogue;

/**
 * Class OrderFactory
 * @package App\Factory
 */
class CommandeFactory
{
    /**
     * Creates an order.
     *
     * @return Commande
     */
    public function create(): Commande
    {
        $commande = new Commande();
        $commande
            ->setStatut(Commande::STATUT_CART);
            //->setCreatedAt(new \DateTime())
            //->setUpdatedAt(new \DateTime());

        return $commande;
    }

    /**
     * Creates an item for a product.
     *
     * @param Catalogue $produit
     *
     * @return OrderItems
     */
    public function createItem(Catalogue $produit): OrderItems
    {
        $orderItem = new OrderItems();
        $orderItem->setProduit($produit);
        $orderItem->setQuantity(1);

        return $orderItem;
    }
}