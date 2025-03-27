CREATE TABLE admin (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    birth_date DATE,
    email VARCHAR(255) NOT NULL,
    role ENUM("super", "normal", "blocked"),
    password VARCHAR(255) NOT NULL
);


CREATE TABLE user (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    birth_date DATE,
    rfid_code VARCHAR(20) NOT NULL,
    access_level INT DEFAULT 0,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO user (id_user, first_name, last_name, birth_date, rfid_code, access_level) VALUES
(4, 'Unknown', 'Unknown', null, '-1', '3');

CREATE TABLE access_logs (
    log_number INT NOT NULL,
    user_id_log INT NOT NULL,
    log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    used_rfid_code VARCHAR(20),
    status ENUM("Access Granted", "Access Denied") NOT NULL,                 -- Access Granted / Denied
    PRIMARY KEY (log_number, user_id_log),

    FOREIGN KEY (user_id_log) REFERENCES user(id_user) ON DELETE CASCADE
);

DELIMITER $$
CREATE TRIGGER before_insert_access_logs
BEFORE INSERT ON access_logs
FOR EACH ROW
BEGIN
    DECLARE last_log INT;

    -- Get the highest log_number for this user
    SELECT COALESCE(MAX(log_number), 0) INTO last_log
    FROM access_logs
    WHERE user_id_log = NEW.user_id_log;

    -- Set log_number to last_log + 1
    SET NEW.log_number = last_log + 1;
END $$
DELIMITER ;
 
-- Can be added 
CREATE TABLE door (
    id_door INT PRIMARY KEY AUTO_INCREMENT,
    room_number INT NOT NULL,
    needed_access_level INT DEFAULT 0
);






















