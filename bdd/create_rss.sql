DROP TRIGGER IF EXISTS deleteOldRssItem ON ITEM_OF_FLUX_RSS;
DROP FUNCTION IF EXISTS deleteRSSITEM();
DROP FUNCTION IF EXISTS getCategory(Category.name%TYPE);
DROP FUNCTION IF EXISTS insertRssItem(RSS_ITEM.title%TYPE, RSS_ITEM.link%TYPE, RSS_ITEM.pub_date%TYPE, RSS_ITEM.description%TYPE, varchar[], RSS_ITEM.importance%TYPE);
DROP FUNCTION IF EXISTS getAllCategories(CATEGORY.name%TYPE);
DROP VIEW IF EXISTS RSS_ITEM_WITH_CATEG;
DROP FUNCTION IF EXISTS getAllCategories(RSS_ITEM.id%TYPE);


DROP TABLE IF EXISTS ITEM_OF_FLUX_RSS;

DROP TABLE IF EXISTS FLUX_RSS;

DROP TABLE IF EXISTS CATEGORY_OF_RSS_ITEM;
DROP TABLE IF EXISTS RSS_ITEM;

DROP TABLE IF EXISTS CATEGORY_CONTAINS_CATEGORY;
DROP TABLE IF EXISTS CATEGORY;

DROP TRIGGER IF EXISTS deleteOldCateg ON RSS_ITEM;
DROP FUNCTION deleteCateg();


CREATE TABLE RSS_ITEM (
	id SERIAL PRIMARY KEY NOT NULL,
	title VARCHAR NOT NULL,
	link VARCHAR NOT NULL,
	pub_date TIMESTAMP,
	description VARCHAR,
	importance INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE FLUX_RSS (
	link VARCHAR PRIMARY KEY NOT NULL,
	id_last_rss INTEGER,
	CONSTRAINT FLUX_RSS_id_last_rss FOREIGN KEY (id_last_rss) REFERENCES RSS_ITEM(id)
	ON DELETE SET NULL
);

CREATE TABLE ITEM_OF_FLUX_RSS (
	link_flux_rss VARCHAR NOT NULL,
	id_rss_item INTEGER NOT NULL,
	PRIMARY KEY (link_flux_rss, id_rss_item),
	CONSTRAINT ITEM_OF_FLUX_RSS_link_flux_rss FOREIGN KEY (link_flux_rss) REFERENCES FLUX_RSS(link)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT ITEM_OF_FLUX_RSS_id_rss_item FOREIGN KEY (id_rss_item) REFERENCES RSS_ITEM(id)
	ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE FUNCTION deleteRSSITEM() RETURNS trigger AS $emp_stamp$
    BEGIN
        DELETE FROM RSS_ITEM WHERE id=old.id_rss_item;
		RETURN NEW;
    END;
$emp_stamp$ LANGUAGE plpgsql;

CREATE TRIGGER deleteOldRssItem AFTER DELETE ON ITEM_OF_FLUX_RSS
    FOR EACH ROW EXECUTE PROCEDURE deleteRSSITEM();

CREATE TABLE CATEGORY (
	name VARCHAR NOT NULL PRIMARY KEY
);

CREATE TABLE CATEGORY_CONTAINS_CATEGORY (
	name_category_master VARCHAR NOT NULL,
	name_category_slave VARCHAR NOT NULL,
	PRIMARY KEY (name_category_master, name_category_slave),
	CONSTRAINT CATEGORY_CONTAINS_CATEGORY_name_category_master FOREIGN KEY (name_category_master) REFERENCES CATEGORY(name)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT CATEGORY_CONTAINS_CATEGORY_name_category_slave FOREIGN KEY (name_category_slave) REFERENCES CATEGORY(name)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE CATEGORY_OF_RSS_ITEM (
	id_rss_item INTEGER NOT NULL,
	name_category VARCHAR NOT NULL,
	PRIMARY KEY (id_rss_item, name_category),
	CONSTRAINT CATEGORY_OF_RSS_ITEM_id_rss_item FOREIGN KEY (id_rss_item) REFERENCES RSS_ITEM(id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT CATEGORY_OF_RSS_ITEM_name_category FOREIGN KEY (name_category) REFERENCES CATEGORY(name)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE FUNCTION deleteCateg() RETURNS trigger AS $emp_stamp$
    BEGIN
		DELETE FROM CATEGORY as A WHERE NOT EXISTS (SELECT name_category FROM CATEGORY_OF_RSS_ITEM WHERE A.name = name_category);
		RETURN NEW;
    END;
$emp_stamp$ LANGUAGE plpgsql;

CREATE TRIGGER deleteOldCateg AFTER DELETE ON RSS_ITEM
    FOR EACH ROW EXECUTE PROCEDURE deleteCateg();

CREATE OR REPLACE FUNCTION getCategory(category_name Category.name%TYPE) RETURNS Category.name%TYPE AS
$$
	DECLARE
		current_category_name Category.name%TYPE;

		current_category_name_reduced Category.name%TYPE;
		category_name_reduced Category.name%TYPE;
	BEGIN
		SELECT LOWER(category_name) into category_name_reduced;
		SELECT TRANSLATE ( category_name_reduced, 'éèà', 'eea' ) into category_name_reduced;

		FOR current_category_name IN SELECT name FROM CATEGORY
		LOOP
			SELECT LOWER(current_category_name) into current_category_name_reduced;
			SELECT TRANSLATE (current_category_name_reduced, 'éèà', 'eea' ) into current_category_name_reduced;
			IF ( FOUND AND category_name_reduced=current_category_name_reduced )
			THEN
				RETURN current_category_name;
			END IF;
		END LOOP;

		RETURN null;
	END
$$ LANGUAGE PLpgSQL;



CREATE OR REPLACE FUNCTION insertRssItem(title RSS_ITEM.title%TYPE, link RSS_ITEM.link%TYPE, pub_date RSS_ITEM.pub_date%TYPE, description RSS_ITEM.description%TYPE, categories varchar[], importance RSS_ITEM.importance%TYPE) RETURNS RSS_ITEM.id%TYPE AS
$$
	DECLARE
		category_name Category.name%TYPE;
		nom_category Category.name%TYPE;
		id RSS_ITEM.id%TYPE;
	BEGIN
		INSERT INTO RSS_ITEM(title,link,pub_date,description,importance) VALUES(title,link,pub_date,description,importance);
		SELECT currval('rss_item_id_seq') INTO id;

		IF (categories IS NOT NULL)
		THEN
			FOREACH category_name IN ARRAY categories
			LOOP
				SELECT getCategory(category_name) INTO nom_category;
				IF ( nom_category IS NULL )
				THEN
					INSERT INTO CATEGORY VALUES(category_name);
					nom_category := category_name;
				END IF;

				PERFORM * FROM CATEGORY_OF_RSS_ITEM as A WHERE A.id_rss_item=id and A.name_category=nom_category;
				IF (NOT FOUND)
				THEN
					INSERT INTO CATEGORY_OF_RSS_ITEM VALUES(id, nom_category);
				END IF;
			END LOOP;
		END IF;

		RETURN id;
	END
$$ LANGUAGE PLpgSQL;

CREATE OR REPLACE FUNCTION getAllCategories(name CATEGORY.name%TYPE) RETURNS SETOF CATEGORY.name%TYPE AS
$$
	DECLARE
		category_of_category RECORD;
		category_of_subcategory RECORD;
	BEGIN
		RETURN NEXT name;
		FOR category_of_category IN SELECT name_category_master,name_category_slave FROM CATEGORY_CONTAINS_CATEGORY WHERE name_category_master=name
		LOOP
			FOR category_of_subcategory IN SELECT getAllCategories(category_of_category.name_category_slave)
			LOOP
				RETURN NEXT category_of_subcategory;
			END LOOP;
		END LOOP;

		RETURN;
	END
$$ LANGUAGE PLpgSQL;

CREATE OR REPLACE FUNCTION getAllCategories(id RSS_ITEM.id%TYPE) RETURNS SETOF CATEGORY.name%TYPE AS
$$
	DECLARE
		category_rss_item RECORD;
		subcategory_rss_item RECORD;
	BEGIN
		FOR category_rss_item IN SELECT name_category,id_rss_item FROM CATEGORY_OF_RSS_ITEM WHERE id_rss_item=id
		LOOP
			FOR subcategory_rss_item IN SELECT getAllCategories(category_rss_item.name_category)
			LOOP
				RETURN NEXT subcategory_rss_item;
			END LOOP;
		END LOOP;

		RETURN;
	END
$$ LANGUAGE PLpgSQL;

CREATE OR REPLACE FUNCTION getAllCategoriesOfFluxRss(link FLUX_RSS.link%TYPE) RETURNS SETOF CATEGORY.name%TYPE AS
$$
	DECLARE
		id_item_of_flux RECORD;
		categ_of_item RECORD;
	BEGIN
		FOR id_item_of_flux IN SELECT id_rss_item FROM ITEM_OF_FLUX_RSS WHERE link_flux_rss=link
		LOOP
			FOR categ_of_item IN SELECT getAllCategories(id_item_of_flux.id_rss_item) AS name
			LOOP
				RETURN NEXT categ_of_item.name;
			END LOOP;
		END LOOP;

		RETURN;
	END
$$ LANGUAGE PLpgSQL;


CREATE OR REPLACE VIEW RSS_ITEM_WITH_CATEG AS
	SELECT I.*, Array(SELECT DISTINCT getAllCategories(I.id)) as category
	FROM RSS_ITEM as I;
	
	
	
	
CREATE TABLE PAGE_LINKS_CATEGS (
	id SERIAL PRIMARY KEY NOT NULL,
	numpage INTEGER NOT NULL,
	link_flux_rss VARCHAR NOT NULL,
	name_category VARCHAR,
	CONSTRAINT PAGE_LINKS_CATEGS_link_flux_rss FOREIGN KEY (link_flux_rss) REFERENCES FLUX_RSS(link)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT PAGE_LINKS_CATEGS_name_category FOREIGN KEY (name_category) REFERENCES CATEGORY(name)
	ON DELETE CASCADE ON UPDATE CASCADE
);

-- SELECT insertrssitem('test'::varchar,'lienn'::varchar,'2019-11-20'::timestamp,'description'::varchar,ARRAY['cyber','secu','hack']::varchar[],0) AS id;
