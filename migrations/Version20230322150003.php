<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322150003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD country VARCHAR(50) NOT NULL, ADD zipcode VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE delivery ADD address2 VARCHAR(255) DEFAULT NULL, ADD name VARCHAR(50) NOT NULL, ADD lastname VARCHAR(50) NOT NULL, ADD email VARCHAR(180) DEFAULT NULL, ADD tel VARCHAR(30) NOT NULL, ADD country VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP country, DROP zipcode');
        $this->addSql('ALTER TABLE delivery DROP address2, DROP name, DROP lastname, DROP email, DROP tel, DROP country');
    }
}
