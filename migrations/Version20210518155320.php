<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518155320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE property_picture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_picture (property_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_4F1605F1549213EC (property_id), INDEX IDX_4F1605F1EE45BDBF (picture_id), PRIMARY KEY(property_id, picture_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE property_picture ADD CONSTRAINT FK_4F1605F1549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_picture ADD CONSTRAINT FK_4F1605F1EE45BDBF FOREIGN KEY (picture_id) REFERENCES pictures (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
