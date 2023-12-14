<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231209133054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_items ADD panier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB0F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('CREATE INDEX IDX_62809DB0F77D927C ON order_items (panier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB0F77D927C');
        $this->addSql('DROP INDEX IDX_62809DB0F77D927C ON order_items');
        $this->addSql('ALTER TABLE order_items DROP panier_id');
    }
}
