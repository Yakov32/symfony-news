<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202181426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD unique_id BIGINT AUTO_INCREMENT NOT NULL, CHANGE id id INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (unique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post MODIFY unique_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE post DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE post DROP unique_id, CHANGE id id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE post ADD PRIMARY KEY (id)');
    }
}