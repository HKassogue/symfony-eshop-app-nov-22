<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223222248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrier (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10251A8A50');
        $this->addSql('DROP INDEX IDX_3781EC10251A8A50 ON delivery');
        $this->addSql('ALTER TABLE delivery ADD address2 VARCHAR(255) DEFAULT NULL, ADD tel VARCHAR(255) NOT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD country VARCHAR(255) DEFAULT NULL, CHANGE order__id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_3781EC10A76ED395 ON delivery (user_id)');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL, ADD carrier_name VARCHAR(255) NOT NULL, ADD carrier_price DOUBLE PRECISION NOT NULL, ADD delivery LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C14584665A');
        $this->addSql('DROP INDEX IDX_845CA2C14584665A ON order_details');
        $this->addSql('ALTER TABLE order_details ADD total DOUBLE PRECISION NOT NULL, DROP product_id');
        $this->addSql('ALTER TABLE product DROP details');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE carrier');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10A76ED395');
        $this->addSql('DROP INDEX IDX_3781EC10A76ED395 ON delivery');
        $this->addSql('ALTER TABLE delivery DROP address2, DROP tel, DROP email, DROP name, DROP lastname, DROP country, CHANGE user_id order__id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10251A8A50 FOREIGN KEY (order__id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_3781EC10251A8A50 ON delivery (order__id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id, DROP carrier_name, DROP carrier_price, DROP delivery');
        $this->addSql('ALTER TABLE order_details ADD product_id INT DEFAULT NULL, DROP total');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C14584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_845CA2C14584665A ON order_details (product_id)');
        $this->addSql('ALTER TABLE product ADD details LONGTEXT DEFAULT NULL');
    }
}
