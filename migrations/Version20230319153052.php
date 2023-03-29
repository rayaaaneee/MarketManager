<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319153052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_in_list ADD id_shopping_list_id INT NOT NULL, DROP id_shopping_list, DROP id_article, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE brand brand VARCHAR(255) DEFAULT NULL, CHANGE unity_price unity_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE article_in_list ADD CONSTRAINT FK_83A183CBC0AE0E28 FOREIGN KEY (id_shopping_list_id) REFERENCES shopping_list (id)');
        $this->addSql('CREATE INDEX IDX_83A183CBC0AE0E28 ON article_in_list (id_shopping_list_id)');
        $this->addSql('ALTER TABLE shopping_list CHANGE id_user id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A45979F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3DC1A45979F37AE5 ON shopping_list (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_list DROP FOREIGN KEY FK_3DC1A45979F37AE5');
        $this->addSql('DROP INDEX IDX_3DC1A45979F37AE5 ON shopping_list');
        $this->addSql('ALTER TABLE shopping_list CHANGE id_user_id id_user INT NOT NULL');
        $this->addSql('ALTER TABLE article_in_list DROP FOREIGN KEY FK_83A183CBC0AE0E28');
        $this->addSql('DROP INDEX IDX_83A183CBC0AE0E28 ON article_in_list');
        $this->addSql('ALTER TABLE article_in_list ADD id_article INT NOT NULL, CHANGE unity_price unity_price INT NOT NULL, CHANGE name name TEXT DEFAULT NULL, CHANGE brand brand TEXT DEFAULT NULL, CHANGE id_shopping_list_id id_shopping_list INT NOT NULL');
    }
}
