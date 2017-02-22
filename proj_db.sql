/* DBMS for Project Management in a College/University
 * Database used : MySQL
 * set editor's tab-width = 4 */

create database proj_db;

use proj_db;

create table project
(
	proj_no			decimal(10),
	title			varchar(50) 	NOT NULL,
	description		varchar(1000),
	start_date		date,
	finish_date		date,
	completed_on	date,
	PRIMARY KEY		(proj_no)
);

create table faculty
(
	faculty_id		decimal(10),
	name			varchar(50)		NOT NULL,
	birth_year		int(4) 			NOT NULL,
	rank			varchar(20)		NOT NULL,
	research_spec	varchar(200)	NOT NULL,
	PRIMARY KEY		(faculty_id)
);

create table contact_no
(
	faculty_id		decimal(10),
	contact_no		decimal(12) 	NOT NULL,
	FOREIGN KEY 	(faculty_id) REFERENCES faculty(faculty_id)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(faculty_id, contact_no)
);

create table department
(
	dept_no			int(4),
	name			varchar(50)		NOT NULL,
	hod				decimal(10) 	/* NOT NULL */,
	PRIMARY KEY		(dept_no),
	FOREIGN KEY 	(hod) REFERENCES faculty(faculty_id)
					ON UPDATE CASCADE
);

create table faculty_dept
(
	faculty_id		decimal(10),
	dept_no 		int(4),
	time_percent	int(3),
	FOREIGN KEY 	(faculty_id) REFERENCES faculty(faculty_id)
					ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY 	(dept_no) REFERENCES department(dept_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(faculty_id, dept_no)
);

create table student
(
	sch_no			decimal(10),
	name			varchar(50)		NOT NULL,
	degree			varchar(10)		NOT NULL
					CHECK(degree IN('UG', 'PG', 'PHD')),
	dob				date 			NOT NULL,
	dept_no			int(4),
	senior			decimal(10),
	PRIMARY KEY		(sch_no),
	FOREIGN KEY		(dept_no) REFERENCES department(dept_no)
					ON UPDATE CASCADE
);

alter table student add
(
	FOREIGN KEY		(senior) REFERENCES student(sch_no)
					ON UPDATE CASCADE
);

create table course_proj
(
	proj_no 		decimal(10),
	dept_no 		int(4),
	investigator	decimal(10),
	FOREIGN KEY 	(proj_no) REFERENCES project(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(proj_no),
	FOREIGN KEY 	(dept_no) REFERENCES department(dept_no)
					ON UPDATE CASCADE,
	FOREIGN KEY 	(investigator) REFERENCES faculty(faculty_id)
					ON UPDATE CASCADE
);

create table course_proj_sem
(
	proj_no 		decimal(10),
	sem 			int(2),
	FOREIGN KEY 	(proj_no) REFERENCES course_proj(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(proj_no, sem)
);

create table std_on_proj
(
	proj_no 		decimal(10),
	sch_no			decimal(10),
	supervisor		decimal(10),
	FOREIGN KEY		(proj_no) REFERENCES course_proj(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY 	(sch_no) REFERENCES student(sch_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY		(proj_no, sch_no),
	FOREIGN KEY 	(supervisor) REFERENCES faculty(faculty_id)
					ON UPDATE CASCADE
);

create table common_proj
(
	proj_no 		decimal(10),
	amount 			decimal(12, 2),
	major_advisor	decimal(10),
	FOREIGN KEY 	(proj_no) REFERENCES project(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(proj_no),
	FOREIGN KEY 	(major_advisor) REFERENCES faculty(faculty_id)
					ON UPDATE CASCADE
);


create table `member`
(
	proj_no 		decimal(10),
	sch_no  		decimal(10),
	FOREIGN KEY 	(proj_no) REFERENCES common_proj(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY 	(sch_no) REFERENCES student(sch_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(proj_no, sch_no)
);

create table advisor
(
	proj_no 		decimal(10),
	faculty_id		decimal(10),
	FOREIGN KEY 	(proj_no) REFERENCES common_proj(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY 	(faculty_id) REFERENCES faculty(faculty_id)
					ON UPDATE CASCADE,
	PRIMARY KEY 	(proj_no, faculty_id)
);

create table sponsor
(
	proj_no 		decimal(10),
	name 			decimal(50),
	amount			decimal(12, 2),
	FOREIGN KEY 	(proj_no) REFERENCES common_proj(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(proj_no, name)
);

create table intern
(
	reg_id 			decimal(10),
	proj_no 		decimal(10),
	name 			varchar(50) 	NOT NULL,
	college 		varchar(50) 	NOT NULL,
	email 			varchar(50) 	NOT NULL,
	contact_no 		decimal(10) 		NOT NULL,
	branch 			varchar(20) 	NOT NULL,
	duration 		time 			NOT NULL,
	FOREIGN KEY 	(proj_no) REFERENCES common_proj(proj_no)
					ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY 	(reg_id, proj_no)
);

/*CREATE VIEW as 
select from  

craete trigger check-delete-trigger after delete on project */

CREATE TABLE old_proj
(
	proj_no    int(10) 	Primary key,
	title  	 	varchar(50) 	NOT NULL
);

CREATE TABLE old_course_proj
(
	proj_no    int(10) 	Primary key,
	title  	 	varchar(50) 	NOT NULL
);

CREATE TABLE old_common_proj
(
	proj_no    int(10) 	Primary key,
	title  	 	varchar(50) 	NOT NULL
);

DELIMITER $$
CREATE TRIGGER insert_into_old_proj
	BEFORE DELETE ON project
	FOR EACH ROW BEGIN
	
	INSERT INTO old_proj
	SET action='insert',
	proj_no = old.proj_no,
	title  = old.title,

END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER insert_into_old_course_proj
	BEFORE DELETE ON course_proj
	FOR EACH ROW BEGIN
	
	INSERT INTO old_course_proj
	SET action='insert',
	proj_no = old.proj_no,
	title  = old.title,

END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER insert_into_common_proj
	BEFORE DELETE ON common_proj
	FOR EACH ROW BEGIN
	
	INSERT INTO old_common_proj
	SET action='insert',
	proj_no = old.proj_no,
	title  = old.title,

END$$
DELIMITER ;


