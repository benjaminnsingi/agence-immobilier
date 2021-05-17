<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517213901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `pictures` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_picture (property_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_4F1605F1549213EC (property_id), INDEX IDX_4F1605F1EE45BDBF (picture_id), PRIMARY KEY(property_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_picture ADD CONSTRAINT FK_4F1605F1549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_picture ADD CONSTRAINT FK_4F1605F1EE45BDBF FOREIGN KEY (picture_id) REFERENCES `pictures` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property_picture DROP FOREIGN KEY FK_4F1605F1EE45BDBF');
        $this->addSql('DROP TABLE `pictures`');
        $this->addSql('DROP TABLE property_picture');
    }
}
