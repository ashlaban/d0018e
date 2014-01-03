-- SQL Statements for generating the Code Mercenary database

-- --- DB-USERS --- --
-- ---------------- --

DROP USER "db-man-public";
DROP USER "db-man-private";

CREATE USER "db-man-public"  WITH PASSWORD 'thisisaHorseBatteryStaple';
CREATE USER "db-man-private" WITH PASSWORD 'anotherHorseBatteryStaple';
GRANT CONNECT ON DATABASE "cmerc-db" TO "db-man-public";
GRANT CONNECT ON DATABASE "cmerc-db" TO "db-man-private";

-- --- TYPES --- --
-- ------------- --

CREATE TYPE task_status AS ENUM ('available','started','done');

-- --- USERS --- --
-- ------------- --

CREATE TABLE userdata(
	username    varchar(255) PRIMARY KEY NOT NULL,
	isdeveloper boolean      DEFAULT TRUE,
	isprovider  boolean      DEFAULT FALSE,
	userrating  real         DEFAULT 0.00,
	nratings    int          DEFAULT 0
);

CREATE TABLE userpassword(
	username varchar(255) PRIMARY KEY REFERENCES userdata(username),
	hash     varchar(255) NOT NULL,
	salt     char(16)     NOT NULL
);

CREATE TABLE usercomments(
	commentid bigserial    PRIMARY KEY,
	commentee varchar(255) REFERENCES userdata(username),
	commenter varchar(255) REFERENCES userdata(username),
	comment   text         NOT NULL
);

ALTER TABLE userdata     OWNER TO "db-man-public";
ALTER TABLE userpassword OWNER TO "db-man-public";
ALTER TABLE usercomments OWNER TO "db-man-public";

-- --- PROJECTS --- --
-- ---------------- --

CREATE TABLE projectdata(
	projectid           bigserial                PRIMARY KEY,
	createddate         timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
	owner               varchar(255)             REFERENCES userdata(username),
	projectname         varchar(255)             NOT NULL,
	description         varchar(1024)            NOT NULL,
	extendeddescription text                     ,
	projectrating       real                     DEFAULT 0.00,
	nratings            int                      DEFAULT 0
);

CREATE TABLE projecttasks(
	taskid      bigserial    PRIMARY KEY,
	projectid   bigint       REFERENCES projectdata(projectid),
	localtaskid int          NOT NULL,
	taskname    varchar(255) NOT NULL,
	description text         NOT NULL,
	status      task_status  NOT NULL,
	UNIQUE( projectid, localtaskid )
);

CREATE TABLE projectcomments(
	commentid bigserial    PRIMARY KEY,
	projectid bigint       REFERENCES projectdata(projectid),
	username  varchar(255) REFERENCES userdata(username),
	comment   text         NOT NULL
);

ALTER TABLE projectdata     OWNER TO "db-man-public";
ALTER TABLE projecttasks    OWNER TO "db-man-public";
ALTER TABLE projectcomments OWNER TO "db-man-public";