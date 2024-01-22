<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122144800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE waiting_return (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, object VARCHAR(255) NOT NULL, nextweek TINYINT(1) DEFAULT NULL, INDEX IDX_D6C0CFAD9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE waiting_return_user (waiting_return_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_30E2F7FC60E702E4 (waiting_return_id), INDEX IDX_30E2F7FCA76ED395 (user_id), PRIMARY KEY(waiting_return_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE waiting_return ADD CONSTRAINT FK_D6C0CFAD9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE waiting_return_user ADD CONSTRAINT FK_30E2F7FC60E702E4 FOREIGN KEY (waiting_return_id) REFERENCES waiting_return (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE waiting_return_user ADD CONSTRAINT FK_30E2F7FCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE waiting_return DROP FOREIGN KEY FK_D6C0CFAD9395C3F3');
        $this->addSql('ALTER TABLE waiting_return_user DROP FOREIGN KEY FK_30E2F7FC60E702E4');
        $this->addSql('ALTER TABLE waiting_return_user DROP FOREIGN KEY FK_30E2F7FCA76ED395');
        $this->addSql('DROP TABLE waiting_return');
        $this->addSql('DROP TABLE waiting_return_user');
    }
}
