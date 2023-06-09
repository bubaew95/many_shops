<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220810212548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item ADD shop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094D16C4DD FOREIGN KEY (shop_id) REFERENCES shops (id)');
        $this->addSql('CREATE INDEX IDX_52EA1F094D16C4DD ON order_item (shop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094D16C4DD');
        $this->addSql('DROP INDEX IDX_52EA1F094D16C4DD ON order_item');
        $this->addSql('ALTER TABLE order_item DROP shop_id');
    }
}
