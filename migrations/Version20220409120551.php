<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409120551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_groups (ID_USERS_GPS INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, ID_USER INT DEFAULT NULL, ID_GROUP INT DEFAULT NULL, INDEX IDX_953F224DF8371B55 (ID_USER), INDEX IDX_953F224D42DA9C8F (ID_GROUP), PRIMARY KEY(ID_USERS_GPS)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224DF8371B55 FOREIGN KEY (ID_USER) REFERENCES users (ID_USER)');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224D42DA9C8F FOREIGN KEY (ID_GROUP) REFERENCES groups (ID_GROUP)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_groups');
    }
}
