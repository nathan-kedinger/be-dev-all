<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326115925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_language (id INT AUTO_INCREMENT NOT NULL, language_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_345695B582F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_language ADD CONSTRAINT FK_345695B582F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id)');
        $this->addSql('ALTER TABLE message ADD is_read TINYINT(1) NOT NULL, CHANGE sent_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_language DROP FOREIGN KEY FK_345695B582F1BAF4');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE user_language');
        $this->addSql('ALTER TABLE message DROP is_read, CHANGE created_at sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
