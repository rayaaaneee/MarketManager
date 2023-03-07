<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307093203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD type INT NOT NULL');
        $this->addSql('ALTER TABLE shopping_list DROP FOREIGN KEY shopping_list_ibfk_1');
        $this->addSql('ALTER TABLE shopping_list DROP FOREIGN KEY shopping_list_ibfk_2');
        $this->addSql('DROP INDEX id_article ON shopping_list');
        $this->addSql('DROP INDEX id_user ON shopping_list');
        $this->addSql('ALTER TABLE shopping_list ADD total_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user ADD surname VARCHAR(100) NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP stock, DROP unity_price, DROP type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE article DROP type');
        $this->addSql('ALTER TABLE shopping_list DROP total_price');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT shopping_list_ibfk_1 FOREIGN KEY (id_article) REFERENCES article (id)');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT shopping_list_ibfk_2 FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id_article ON shopping_list (id_article)');
        $this->addSql('CREATE INDEX id_user ON shopping_list (id_user)');
        $this->addSql('ALTER TABLE user ADD stock INT NOT NULL, ADD unity_price INT NOT NULL, ADD type INT NOT NULL, DROP surname, DROP password');
    }
}
