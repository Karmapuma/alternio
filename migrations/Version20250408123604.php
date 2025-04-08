<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250408123604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE calendrier (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE logements (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, surface INT NOT NULL, loyer INT NOT NULL, charges INT NOT NULL, description LONGTEXT NOT NULL, nb_place INT NOT NULL, date_ajout DATE NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE logements_user (logements_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_57D0F4EFFC28B3A7 (logements_id), INDEX IDX_57D0F4EFA76ED395 (user_id), PRIMARY KEY(logements_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user ADD CONSTRAINT FK_57D0F4EFFC28B3A7 FOREIGN KEY (logements_id) REFERENCES logements (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user ADD CONSTRAINT FK_57D0F4EFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user DROP FOREIGN KEY FK_57D0F4EFFC28B3A7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user DROP FOREIGN KEY FK_57D0F4EFA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE calendrier
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE logements
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE logements_user
        SQL);
    }
}
