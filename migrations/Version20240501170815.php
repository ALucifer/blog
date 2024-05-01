<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240501170815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Link between writters on category';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_id INT DEFAULT NULL, INDEX IDX_608AC0EA76ED395 (user_id), INDEX IDX_608AC0E12469DE2 (category_id), UNIQUE INDEX UNIQ_608AC0EA76ED39512469DE2 (user_id, category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_user ADD CONSTRAINT FK_608AC0EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE category_user ADD CONSTRAINT FK_608AC0E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category_user DROP FOREIGN KEY FK_608AC0EA76ED395');
        $this->addSql('ALTER TABLE category_user DROP FOREIGN KEY FK_608AC0E12469DE2');
        $this->addSql('DROP TABLE category_user');
    }
}
