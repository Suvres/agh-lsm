-- Doctrine Migration File Generated on 2023-10-12 20:42:52

-- Version DoctrineMigrations\Version20201229190833
CREATE SEQUENCE reader_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE reader (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE UNIQUE INDEX UNIQ_CC3F893CE7927C74 ON reader (email);

-- Version DoctrineMigrations\Version20201230172031
DROP SEQUENCE reader_id_seq CASCADE;
CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email);
DROP TABLE reader;

-- Version DoctrineMigrations\Version20201230181728
CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE book_copies_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE books_loans_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE book (id INT NOT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, age_threshold INT NOT NULL, brand VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id));
CREATE TABLE book_copies (id INT NOT NULL, book_id INT NOT NULL, hashcode VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_F0A8D81116A2B381 ON book_copies (book_id);
CREATE TABLE books_loans (id INT NOT NULL, borrower_id INT NOT NULL, book_copy_id INT DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, committed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_2930F94511CE312B ON books_loans (borrower_id);
CREATE INDEX IDX_2930F9453B550FE4 ON books_loans (book_copy_id);
ALTER TABLE book_copies ADD CONSTRAINT FK_F0A8D81116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE books_loans ADD CONSTRAINT FK_2930F94511CE312B FOREIGN KEY (borrower_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE books_loans ADD CONSTRAINT FK_2930F9453B550FE4 FOREIGN KEY (book_copy_id) REFERENCES book_copies (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE "user" ADD name VARCHAR(255) NOT NULL;
ALTER TABLE "user" ADD surname VARCHAR(255) NOT NULL;
ALTER TABLE "user" ADD birth_date DATE NOT NULL;