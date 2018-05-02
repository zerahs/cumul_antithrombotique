<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502150713 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE answer (id INT UNSIGNED AUTO_INCREMENT NOT NULL, participant_id INT UNSIGNED DEFAULT NULL, question_id INT UNSIGNED NOT NULL, `values` LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_DADD4A259D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A259D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
