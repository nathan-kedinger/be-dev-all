<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326173136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission_languages DROP FOREIGN KEY FK_1264A450BE6CAE90');
        $this->addSql('ALTER TABLE mission_languages DROP FOREIGN KEY FK_1264A4505D237A9A');
        $this->addSql('DROP TABLE mission_languages');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_languages (mission_id INT NOT NULL, languages_id INT NOT NULL, INDEX IDX_1264A450BE6CAE90 (mission_id), INDEX IDX_1264A4505D237A9A (languages_id), PRIMARY KEY(mission_id, languages_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mission_languages ADD CONSTRAINT FK_1264A450BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_languages ADD CONSTRAINT FK_1264A4505D237A9A FOREIGN KEY (languages_id) REFERENCES languages (id) ON DELETE CASCADE');
    }
}
