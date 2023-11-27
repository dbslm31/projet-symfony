<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127083013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE catalogue ADD category_id INT NOT NULL, ADD subcategory_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F55DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id)');
        $this->addSql('CREATE INDEX IDX_59A699F512469DE2 ON catalogue (category_id)');
        $this->addSql('CREATE INDEX IDX_59A699F55DC6FE57 ON catalogue (subcategory_id)');
        $this->addSql('ALTER TABLE commande ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)');
        $this->addSql('ALTER TABLE panier ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF219EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF219EB6921 ON panier (client_id)');
        $this->addSql('ALTER TABLE subcategory ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_DDCA44812469DE2 ON subcategory (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F512469DE2');
        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F55DC6FE57');
        $this->addSql('DROP INDEX IDX_59A699F512469DE2 ON catalogue');
        $this->addSql('DROP INDEX IDX_59A699F55DC6FE57 ON catalogue');
        $this->addSql('ALTER TABLE catalogue DROP category_id, DROP subcategory_id');
        $this->addSql('ALTER TABLE subcategory DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('DROP INDEX IDX_DDCA44812469DE2 ON subcategory');
        $this->addSql('ALTER TABLE subcategory DROP category_id');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('DROP INDEX IDX_6EEAA67D19EB6921 ON commande');
        $this->addSql('ALTER TABLE commande DROP client_id');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF219EB6921');
        $this->addSql('DROP INDEX UNIQ_24CC0DF219EB6921 ON panier');
        $this->addSql('ALTER TABLE panier DROP client_id');
    }
}
