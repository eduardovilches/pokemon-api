<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251002120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create pokemon_type join table for ManyToMany between Pokemon and Type';
    }

    public function up(Schema $schema): void
    {
        // Create join table if it does not already exist
        $this->addSql('CREATE TABLE IF NOT EXISTS pokemon_type (pokemon_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_C2999AF0AA0B1F0 (pokemon_id), INDEX IDX_C2999AF0C54C8C93 (type_id), PRIMARY KEY(pokemon_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_C2999AF0AA0B1F0 FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_C2999AF0C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_C2999AF0AA0B1F0');
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_C2999AF0C54C8C93');
        $this->addSql('DROP TABLE IF EXISTS pokemon_type');
    }
}


