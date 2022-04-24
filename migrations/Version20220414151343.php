<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414151343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_groups');
        $this->addSql('ALTER TABLE comments CHANGE LIKES LIKES INT DEFAULT 0, CHANGE DISLIKES DISLIKES INT DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_groups (ID_USERS_GPS INT AUTO_INCREMENT NOT NULL, status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ID_GROUP INT DEFAULT NULL, ID_USER INT DEFAULT NULL, INDEX fk_ID_GROUP (ID_GROUP), INDEX fk_ID_USER (ID_USER), PRIMARY KEY(ID_USERS_GPS)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comments CHANGE LIKES LIKES INT DEFAULT NULL, CHANGE DISLIKES DISLIKES INT DEFAULT NULL');
    }
}
