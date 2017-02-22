CREATE TABLE old_proj
(
	proj_no    int(10) 	Primary key,
	title  	 	varchar(50) 	NOT NULL
);

DELIMITER $$
CREATE TRIGGER insert_into_old_proj
	BEFORE DELETE ON project
	FOR EACH ROW
	BEGIN
	
	INSERT INTO old_proj
	SET action='insert',
	proj_no = old.proj_no,
	title  = old.title,

END$$
DELIMITER ;
