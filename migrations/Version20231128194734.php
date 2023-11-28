<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128194734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_items (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, INDEX IDX_62809DB0F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB0F347EFB FOREIGN KEY (produit_id) REFERENCES catalogue (id)');
        $this->addSql('ALTER TABLE commande DROP produits');
        $this->addSql('ALTER TABLE panier DROP produits');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB0F347EFB');
        $this->addSql('DROP TABLE order_items');
        $this->addSql('ALTER TABLE panier ADD produits VARCHAR(9999) NOT NULL');
        $this->addSql('ALTER TABLE commande ADD produits VARCHAR(9999) NOT NULL');
    }
}
