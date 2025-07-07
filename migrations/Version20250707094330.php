<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250707094330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, note INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE notes_user (notes_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C5C8C0C8FC56F556 (notes_id), INDEX IDX_C5C8C0C8A76ED395 (user_id), PRIMARY KEY(notes_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE notes_pictures (notes_id INT NOT NULL, pictures_id INT NOT NULL, INDEX IDX_E37A6C61FC56F556 (notes_id), INDEX IDX_E37A6C61BC415685 (pictures_id), PRIMARY KEY(notes_id, pictures_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_user ADD CONSTRAINT FK_C5C8C0C8FC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_user ADD CONSTRAINT FK_C5C8C0C8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_pictures ADD CONSTRAINT FK_E37A6C61FC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_pictures ADD CONSTRAINT FK_E37A6C61BC415685 FOREIGN KEY (pictures_id) REFERENCES pictures (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_user DROP FOREIGN KEY FK_C5C8C0C8FC56F556
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_user DROP FOREIGN KEY FK_C5C8C0C8A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_pictures DROP FOREIGN KEY FK_E37A6C61FC56F556
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notes_pictures DROP FOREIGN KEY FK_E37A6C61BC415685
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notes_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notes_pictures
        SQL);
    }
}
