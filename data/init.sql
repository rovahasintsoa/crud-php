CREATE DATABASE studentsDB;

    use studentsDB;

    CREATE TABLE student ( 
        id int(2) NOT NULL auto_increment,  
        name varchar(50) NOT NULL default '', 
        class varchar(10) NOT NULL default '', 
        mark int(3) NOT NULL default '0', 
        location VARCHAR(50),
        UNIQUE KEY id (id));

    INSERT INTO student VALUES (1, 'John Deo', 'Four', 75, "Manchester");
    INSERT INTO student VALUES (2, 'Max Ruin', 'Three', 85, "Liverpool");
    INSERT INTO student VALUES (3, 'Arnold', 'Three', 55, "London");
    INSERT INTO student VALUES (4, 'Krish Star', 'Four', 60, "London");
    INSERT INTO student VALUES (5, 'John Mike', 'Four', 60, "Newcastle");
    INSERT INTO student VALUES (6, 'Alex John', 'Five', 55, "Manchester");