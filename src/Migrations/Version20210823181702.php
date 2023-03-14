<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823181702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE oficina ADD observaciones TEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE INDEX idx_turno_fecha_hora ON turno (fecha_hora)');
        $this->addSql('CREATE INDEX idx_turno_estado ON turno (estado)');
        $this->addSql('ALTER TABLE oficina DROP observaciones');
        $this->addSql('CREATE INDEX idx_oficina_oficina ON oficina (oficina)');
        $this->addSql('CREATE INDEX idx_oficina_habilitada ON oficina (habilitada)');
        $this->addSql('CREATE INDEX persona_dni_idx ON persona (dni)');
        $this->addSql('CREATE INDEX idx_turnos_diarios_fecha ON turnos_diarios (fecha)');
        $this->addSql('CREATE INDEX idx_turno_rechazado_fecha_hora_turno ON turno_rechazado (fecha_hora_turno)');
        $this->addSql('CREATE INDEX idx_turno_rechazado_fecha_hora_rechazo ON turno_rechazado (fecha_hora_rechazo)');
    }
}
