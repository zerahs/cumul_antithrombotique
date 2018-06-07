<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180607114300 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tool_review (id INT UNSIGNED AUTO_INCREMENT NOT NULL, participant_id INT UNSIGNED DEFAULT NULL, prescription SMALLINT NOT NULL, changes SMALLINT NOT NULL, clear SMALLINT NOT NULL, operational SMALLINT NOT NULL, useful SMALLINT NOT NULL, ready SMALLINT NOT NULL, recommend SMALLINT NOT NULL, remarks LONGTEXT NOT NULL, INDEX IDX_1C128DDA9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tool_review ADD CONSTRAINT FK_1C128DDA9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
