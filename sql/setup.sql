-- Setup
SET NAMES utf8;
USE kabc16;


-- Reset
DROP TABLE IF EXISTS wgtotw_vote;
DROP TABLE IF EXISTS wgtotw_post_tag;
DROP TABLE IF EXISTS wgtotw_tag;
DROP TABLE IF EXISTS wgtotw_post;
DROP TABLE IF EXISTS wgtotw_user;


-- Users
CREATE TABLE wgtotw_user (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(25) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(200) NOT NULL,
    website VARCHAR(500) NULL,
    hideEmail BOOLEAN NOT NULL DEFAULT FALSE,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE,
	created DATETIME NOT NULL,
	updated DATETIME NULL,
	deleted DATETIME NULL
) ENGINE InnoDb CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO wgtotw_user (username, password, email, hideEmail, isAdmin, created)
    VALUES ('admin', '$2y$10$e/KyNRcs0GNwVfJX2xeNv.5UsvkbacVRDVZ55xyhli.EArAqf8oUW', 'kabc16@student.bth.se', FALSE, TRUE, NOW());
INSERT INTO wgtotw_user (username, password, email, hideEmail, isAdmin, created)
    VALUES ('doe', '$2y$10$5sBHCuP1DOwnBpG5kk8eLeIzhdoqzlXK4ZWGW5RVcSYFH6ry8E5sW', 'e@mail.com', FALSE, FALSE, NOW());
INSERT INTO wgtotw_user (username, password, email, website, hideEmail, isAdmin, created)
    VALUES ('LRC', '$2y$10$rnrmsCZdcThJJTnrMWLEw.wTKaYhf/K.w4c41XURULG8.cDhwEPRm', 'kalle.brisland@lillsjon.net', 'http://www.student.bth.se/~kabc16/dbwebb-kurser/ramverk1/me/anax/htdocs/', TRUE, TRUE, NOW());


-- Posts (questions, answers, comments)
CREATE TABLE wgtotw_post (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    userId INT UNSIGNED NOT NULL,
    parentId INT UNSIGNED NULL,     -- NULL for questions
    type VARCHAR(10) NOT NULL,      -- 'question'/'answer'/'comment'
    title VARCHAR(100) NULL,        -- NULL for answers and comments
    text TEXT NOT NULL,
    rank INT NOT NULL DEFAULT 0,
    status VARCHAR(10) NULL,
    published DATETIME NOT NULL,
    updated DATETIME NULL,
    deleted DATETIME NULL,
    
    FOREIGN KEY (userId) REFERENCES wgtotw_user(id),
    FOREIGN KEY (parentId) REFERENCES wgtotw_post(id) ON DELETE CASCADE
) ENGINE InnoDb CHARACTER SET utf8 COLLATE utf8_swedish_ci;

CREATE INDEX idx_type ON wgtotw_post(type);
CREATE INDEX idx_published ON wgtotw_post(published);

-- example questions
INSERT INTO wgtotw_post (id, userId, type, title, text, status, published)
	VALUES (1, 2, 'question', 'Vad är meningen med livet, universum och allting?', 'Ja, vad är egentligen svaret på den stora frågan om livet, universum och allting? Är det någon som vet?', 'answered', '2017-10-15 18:55:41');
INSERT INTO wgtotw_post (id, userId, type, title, text, rank, published)
	VALUES (2, 3, 'question', 'Vem kan segla förutan vind?', 'Jag kan det inte i alla fall.', -2, '2017-10-15 18:57:30');
INSERT INTO wgtotw_post (id, userId, type, title, text, rank, published)
	VALUES (8, 2, 'question', 'Vad säger Chewie?', 'Är det verkligen någon som förstår vad han säger, eller _låtsas_ alla bara? Det låter mest som råmanden tycker jag...', -1, '2017-10-21 21:01:03');
INSERT INTO wgtotw_post (id, userId, type, title, text, published)
	VALUES (9, 2, 'question', 'TOS vs TNG', 'Vem är bäst av Kirk och Picard?\r\n\r\nJag röstar nog på Kirk, som aldrig var rädd att ta i med hårdhandskarna när det behövdes.', '2017-10-22 21:03:29');
INSERT INTO wgtotw_post (id, userId, type, title, text, rank, published)
	VALUES (10, 3, 'question', 'Star Trek: Discovery – bu eller bä?', 'Det har ju börjat en ny serie, så låtom oss prata lite om den! Är den nåt att ha?\r\n\r\nJag har sett några avsnitt och tycker det verkar konstigt att man aldrig hört talas om den där "spordriften" sedan dess, så nåt skumt verkar det vara. Sen påminner den ju lite om den oändliga osannolikhetsdriften från Liftaren, liksom om "kryddpiloterna" i Dune... Eller de kanske kommer med någon halvrimlig förklaring vad det lider...?\r\n\r\nVad säger ni?', 2, '2017-10-23 10:08:51');

-- example answers
INSERT INTO wgtotw_post (id, userId, parentId, type, text, rank, status, published)
	VALUES (3, 3, 1, 'answer', '42', 1, 'accepted', '2017-10-15 22:30:28');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, published)
	VALUES (4, 2, 2, 'answer', '**Jag** kan!', '2017-10-15 23:19:01');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, published)
	VALUES (11, 2, 10, 'answer', 'Jag har inte sett något avsnitt än, men bilderna som synts på nätet är ju häftiga så det verkar lovande.', '2017-10-23 15:26:12');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, rank, published)
	VALUES (12, 1, 10, 'answer', 'Jag har liknande reservationer som du, men jag är inte beredd att ge upp riktigt än. Sedan är det ju spännande att se vad det blir av det där "hemliga projektet" som Nick Meyer håller på med!', 1, '2017-10-23 15:30:30');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, published, updated)
	VALUES (15, 1, 1, 'answer', '47? Nej, ursäkta. Fel av mig.', '2017-10-23 18:04:26', '2017-10-24 19:05:01');

-- example comments
INSERT INTO wgtotw_post (id, userId, parentId, type, text, published)
	VALUES (5, 1, 1, 'comment', 'Bra fråga!', '2017-10-16 01:25:58');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, published)
	VALUES (6, 2, 3, 'comment', 'Ja, det stämmer ju!', '2016-10-16 06:37:09');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, rank, published)
	VALUES (7, 3, 3, 'comment', 'Ha, jag är *bäst* i hela världen...', -1, '2016-10-16 11:19:38');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, published)
	VALUES (13, 3, 12, 'comment', 'Ja, absolut! Spännande tider...', '2017-10-23 16:00:41');
INSERT INTO wgtotw_post (id, userId, parentId, type, text, published)
	VALUES (14, 1, 2, 'comment', 'Öh, vad har den här frågan med sci-fi att göra...? :/', '2017-10-23 16:04:15');



-- Tags
CREATE TABLE wgtotw_tag (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(25) NOT NULL UNIQUE,
    description VARCHAR(200) NOT NULL,
    created DATETIME NOT NULL,
    updated DATETIME NULL
) ENGINE InnoDb CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO wgtotw_tag (id, name, description, created)
	VALUES (1, 'thhgttg', 'Liftarens guide till galaxen', '2017-10-14 16:24:12');
INSERT INTO wgtotw_tag (id, name, description, created)
	VALUES (2, 'startrek', 'Star Trek', '2017-10-14 16:24:49');
INSERT INTO wgtotw_tag (id, name, description, created)
	VALUES (3, 'starwars', 'Star Wars', '2017-10-14 16:27:27');
INSERT INTO wgtotw_tag (id, name, description, created)
	VALUES (4, 'övrigt', 'Vad som helst', '2017-10-14 16:30:40');


-- Post/Tag association
CREATE TABLE wgtotw_post_tag (
    postId INT UNSIGNED NOT NULL,
    tagId INT UNSIGNED NOT NULL,
    
    PRIMARY KEY (postId, tagId),
    FOREIGN KEY (postId) REFERENCES wgtotw_post(id) ON DELETE CASCADE,
    FOREIGN KEY (tagId) REFERENCES wgtotw_tag(id) ON DELETE CASCADE
) ENGINE InnoDb CHARACTER SET utf8;

INSERT INTO wgtotw_post_tag VALUES (1, 1);
INSERT INTO wgtotw_post_tag VALUES (2, 4);
INSERT INTO wgtotw_post_tag VALUES (8, 3);
INSERT INTO wgtotw_post_tag VALUES (9, 2);
INSERT INTO wgtotw_post_tag VALUES (10, 2);
INSERT INTO wgtotw_post_tag VALUES (10, 1);


-- Votes
CREATE TABLE wgtotw_vote (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    postId INT UNSIGNED NOT NULL,
    userId INT UNSIGNED NOT NULL,
    value TINYINT NOT NULL,
    
    FOREIGN KEY (postId) REFERENCES wgtotw_post(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES wgtotw_user(id)
) ENGINE InnoDb CHARACTER SET utf8;

INSERT INTO wgtotw_vote VALUES (1, 3, 2, 1);
INSERT INTO wgtotw_vote VALUES (2, 7, 2, -1);
INSERT INTO wgtotw_vote VALUES (3, 8, 3, -1);
INSERT INTO wgtotw_vote VALUES (4, 10, 1, 1);
INSERT INTO wgtotw_vote VALUES (5, 10, 2, 1);
INSERT INTO wgtotw_vote VALUES (6, 12, 3, 1);
INSERT INTO wgtotw_vote VALUES (7, 2, 1, -1);
INSERT INTO wgtotw_vote VALUES (8, 2, 2, -1);
