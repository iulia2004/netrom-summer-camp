<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250627043023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_artist ADD festival_id INT DEFAULT NULL, ADD artist_id INT DEFAULT NULL, DROP festival, DROP artist
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_artist ADD CONSTRAINT FK_E68F0A788AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_artist ADD CONSTRAINT FK_E68F0A78B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E68F0A788AEBAF57 ON festival_artist (festival_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E68F0A78B7970CF8 ON festival_artist (artist_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase ADD user_id INT DEFAULT NULL, ADD festival_id INT DEFAULT NULL, DROP user, DROP festival
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6117D13BA76ED395 ON purchase (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6117D13B8AEBAF57 ON purchase (festival_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_artist DROP FOREIGN KEY FK_E68F0A788AEBAF57
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_artist DROP FOREIGN KEY FK_E68F0A78B7970CF8
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E68F0A788AEBAF57 ON festival_artist
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E68F0A78B7970CF8 ON festival_artist
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_artist ADD festival VARCHAR(255) NOT NULL, ADD artist VARCHAR(255) NOT NULL, DROP festival_id, DROP artist_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B8AEBAF57
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6117D13BA76ED395 ON purchase
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6117D13B8AEBAF57 ON purchase
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase ADD user VARCHAR(255) NOT NULL, ADD festival VARCHAR(255) NOT NULL, DROP user_id, DROP festival_id
        SQL);
    }
}
