<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329192252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_in_list ADD id_article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article_in_list ADD CONSTRAINT FK_83A183CBD71E064B FOREIGN KEY (id_article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_83A183CBD71E064B ON article_in_list (id_article_id)');
        $this->addSql('ALTER TABLE shopping_list CHANGE id_user_id id_user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_in_list DROP FOREIGN KEY FK_83A183CBD71E064B');
        $this->addSql('DROP INDEX IDX_83A183CBD71E064B ON article_in_list');
        $this->addSql('ALTER TABLE article_in_list DROP id_article_id');
        $this->addSql('ALTER TABLE shopping_list CHANGE id_user_id id_user_id INT NOT NULL');
    }
}
