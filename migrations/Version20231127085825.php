<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127085825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, subcategory_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(2500) NOT NULL, image VARCHAR(255) DEFAULT NULL, prix INT NOT NULL, promo INT DEFAULT NULL, stock INT NOT NULL, INDEX IDX_59A699F512469DE2 (category_id), INDEX IDX_59A699F55DC6FE57 (subcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subcategory (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_DDCA44812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F55DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id)');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F512469DE2');
        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F55DC6FE57');
        $this->addSql('ALTER TABLE subcategory DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE subcategory');
    }
}
