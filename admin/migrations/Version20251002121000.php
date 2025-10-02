<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251002121000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create pokemon_move join table for ManyToMany between Pokemon and Move';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS pokemon_move (pokemon_id INT NOT NULL, move_id INT NOT NULL, INDEX IDX_9AA57AA9AA0B1F0 (pokemon_id), INDEX IDX_9AA57AA98C41D25 (move_id), PRIMARY KEY(pokemon_id, move_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokemon_move ADD CONSTRAINT FK_9AA57AA9AA0B1F0 FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_move ADD CONSTRAINT FK_9AA57AA98C41D25 FOREIGN KEY (move_id) REFERENCES move (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pokemon_move DROP FOREIGN KEY FK_9AA57AA9AA0B1F0');
        $this->addSql('ALTER TABLE pokemon_move DROP FOREIGN KEY FK_9AA57AA98C41D25');
        $this->addSql('DROP TABLE IF EXISTS pokemon_move');
    }
}


