<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221123103915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, article_type_id INT NOT NULL, article_id INT DEFAULT NULL, component_id INT DEFAULT NULL, machine_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_23A0E66A76ED395 (user_id), INDEX IDX_23A0E66289EC824 (article_type_id), INDEX IDX_23A0E667294869C (article_id), UNIQUE INDEX UNIQ_23A0E66E2ABAFFF (component_id), UNIQUE INDEX UNIQ_23A0E66F6B75B26 (machine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, article_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C7294869C (article_id), INDEX IDX_9474526CF8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, document_type_id INT DEFAULT NULL, article_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content LONGBLOB NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_D8698A7661232A4F (document_type_id), INDEX IDX_D8698A767294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, price_max VARCHAR(255) DEFAULT NULL, price_min VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine_component (machine_id INT NOT NULL, component_id INT NOT NULL, INDEX IDX_5D349AD4F6B75B26 (machine_id), INDEX IDX_5D349AD4E2ABAFFF (component_id), PRIMARY KEY(machine_id, component_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66289EC824 FOREIGN KEY (article_type_id) REFERENCES article_type (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E667294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7661232A4F FOREIGN KEY (document_type_id) REFERENCES document_type (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A767294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE machine_component ADD CONSTRAINT FK_5D349AD4F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE machine_component ADD CONSTRAINT FK_5D349AD4E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66289EC824');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E667294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66E2ABAFFF');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F6B75B26');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF8697D13');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7661232A4F');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A767294869C');
        $this->addSql('ALTER TABLE machine_component DROP FOREIGN KEY FK_5D349AD4F6B75B26');
        $this->addSql('ALTER TABLE machine_component DROP FOREIGN KEY FK_5D349AD4E2ABAFFF');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_type');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_type');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE machine_component');
        $this->addSql('DROP TABLE user');
    }
}
