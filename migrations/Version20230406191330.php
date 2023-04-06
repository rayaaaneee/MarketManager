<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406191330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collaborator (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, shopping_list_id INT NOT NULL, INDEX IDX_606D487CA76ED395 (user_id), INDEX IDX_606D487C23245BF9 (shopping_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487C23245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id)');
        $this->addSql('ALTER TABLE shopping_list CHANGE end_date end_date DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX name ON user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487CA76ED395');
        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487C23245BF9');
        $this->addSql('DROP TABLE collaborator');
        $this->addSql('CREATE UNIQUE INDEX name ON user (name, surname)');
        $this->addSql('ALTER TABLE shopping_list CHANGE end_date end_date DATE DEFAULT NULL');
    }
}
