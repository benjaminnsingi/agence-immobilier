<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518155904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures ADD property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC0549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('CREATE INDEX IDX_8F7C2FC0549213EC ON pictures (property_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `pictures` DROP FOREIGN KEY FK_8F7C2FC0549213EC');
        $this->addSql('DROP INDEX IDX_8F7C2FC0549213EC ON `pictures`');
        $this->addSql('ALTER TABLE `pictures` DROP property_id');
    }
}
