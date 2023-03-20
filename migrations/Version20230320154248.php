<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320154248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire ADD ouverture_matin VARCHAR(255) NOT NULL, ADD fermeture_matin VARCHAR(255) NOT NULL, ADD ouverture_soir VARCHAR(255) NOT NULL, ADD fermeture_soir VARCHAR(255) NOT NULL, DROP ouverture, DROP fermeture, DROP moment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire ADD ouverture VARCHAR(255) NOT NULL, ADD fermeture VARCHAR(255) NOT NULL, ADD moment VARCHAR(255) NOT NULL, DROP ouverture_matin, DROP fermeture_matin, DROP ouverture_soir, DROP fermeture_soir');
    }
}
