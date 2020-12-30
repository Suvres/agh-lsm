<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201230181728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_copies_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE books_loans_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE book (id INT NOT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, age_threshold INT NOT NULL, brand VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book_copies (id INT NOT NULL, book_id INT NOT NULL, hashcode VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0A8D81116A2B381 ON book_copies (book_id)');
        $this->addSql('CREATE TABLE books_loans (id INT NOT NULL, borrower_id INT NOT NULL, book_copy_id INT DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, committed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2930F94511CE312B ON books_loans (borrower_id)');
        $this->addSql('CREATE INDEX IDX_2930F9453B550FE4 ON books_loans (book_copy_id)');
        $this->addSql('ALTER TABLE book_copies ADD CONSTRAINT FK_F0A8D81116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books_loans ADD CONSTRAINT FK_2930F94511CE312B FOREIGN KEY (borrower_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books_loans ADD CONSTRAINT FK_2930F9453B550FE4 FOREIGN KEY (book_copy_id) REFERENCES book_copies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD surname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD birth_date DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book_copies DROP CONSTRAINT FK_F0A8D81116A2B381');
        $this->addSql('ALTER TABLE books_loans DROP CONSTRAINT FK_2930F9453B550FE4');
        $this->addSql('DROP SEQUENCE book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_copies_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE books_loans_id_seq CASCADE');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_copies');
        $this->addSql('DROP TABLE books_loans');
        $this->addSql('ALTER TABLE "user" DROP name');
        $this->addSql('ALTER TABLE "user" DROP surname');
        $this->addSql('ALTER TABLE "user" DROP birth_date');
    }
}
