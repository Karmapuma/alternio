<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250408124538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE calendrier ADD alternant_id_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE calendrier ADD CONSTRAINT FK_B2753CB9FB02512D FOREIGN KEY (alternant_id_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B2753CB9FB02512D ON calendrier (alternant_id_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE calendrier DROP FOREIGN KEY FK_B2753CB9FB02512D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_B2753CB9FB02512D ON calendrier
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE calendrier DROP alternant_id_id
        SQL);
    }
}
