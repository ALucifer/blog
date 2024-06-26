<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240425081249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add owner in post table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE post CHANGE owner_id owner_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE post CHANGE owner_id owner_id INT DEFAULT NULL');
    }
}
