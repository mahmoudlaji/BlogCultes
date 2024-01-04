<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620090912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP one_to_many');
        $this->addSql('ALTER TABLE image_article ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_972A59BA7294869C ON image_article (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD one_to_many VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image_article DROP FOREIGN KEY FK_972A59BA7294869C');
        $this->addSql('DROP INDEX IDX_972A59BA7294869C ON image_article');
        $this->addSql('ALTER TABLE image_article DROP article_id');
    }
}
