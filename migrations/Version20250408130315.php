<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250408130315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user DROP FOREIGN KEY FK_57D0F4EFA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user DROP FOREIGN KEY FK_57D0F4EFFC28B3A7
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE logements_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements ADD owner_id INT NOT NULL, DROP status
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements ADD CONSTRAINT FK_EEF1F6187E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EEF1F6187E3C61F9 ON logements (owner_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD location_fk_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649D32B5CF5 FOREIGN KEY (location_fk_id) REFERENCES logements (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649D32B5CF5 ON user (location_fk_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE logements_user (logements_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_57D0F4EFFC28B3A7 (logements_id), INDEX IDX_57D0F4EFA76ED395 (user_id), PRIMARY KEY(logements_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user ADD CONSTRAINT FK_57D0F4EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements_user ADD CONSTRAINT FK_57D0F4EFFC28B3A7 FOREIGN KEY (logements_id) REFERENCES logements (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements DROP FOREIGN KEY FK_EEF1F6187E3C61F9
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_EEF1F6187E3C61F9 ON logements
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE logements ADD status TINYINT(1) NOT NULL, DROP owner_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D32B5CF5
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8D93D649D32B5CF5 ON `user`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP location_fk_id
        SQL);
    }
}
