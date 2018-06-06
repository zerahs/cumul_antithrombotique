<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180606130709 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participant ADD thesis_date VARCHAR(63) NOT NULL, ADD cumul_percent VARCHAR(63) NOT NULL, ADD at_ease VARCHAR(63) NOT NULL, ADD where_to_reco VARCHAR(63) NOT NULL, DROP place');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
