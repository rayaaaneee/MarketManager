<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406235957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collaboration_request (id INT AUTO_INCREMENT NOT NULL, shopping_list_id INT NOT NULL, receiver_id INT NOT NULL, INDEX IDX_6CCAF4EE23245BF9 (shopping_list_id), INDEX IDX_6CCAF4EECD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collaboration_request ADD CONSTRAINT FK_6CCAF4EE23245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id)');
        $this->addSql('ALTER TABLE collaboration_request ADD CONSTRAINT FK_6CCAF4EECD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX user_id ON collaborator');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collaboration_request DROP FOREIGN KEY FK_6CCAF4EE23245BF9');
        $this->addSql('ALTER TABLE collaboration_request DROP FOREIGN KEY FK_6CCAF4EECD53EDB6');
        $this->addSql('DROP TABLE collaboration_request');
        $this->addSql('CREATE UNIQUE INDEX user_id ON collaborator (user_id, shopping_list_id)');
    }
}
