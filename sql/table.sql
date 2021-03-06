# database
CREATE DATABASE IF NOT EXISTS jabburp;

# table account
CREATE TABLE IF NOT EXISTS account(
    uid int(11) NOT NULL AUTO_INCREMENT,
    username varchar(20) NOT NULL,
    password varchar(32) NOT NULL,
    email varchar(64) NOT NULL,
    UNIQUE(username),
    PRIMARY KEY(uid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# table user_info
CREATE TABLE IF NOT EXISTS user_info (
    uid int(11) NOT NULL,
	firstname varchar(32) NOT NULL,
	lastname varchar(32) NOT NULL,
	gender enum('male', 'female'),
	about varchar(255) DEFAULT NULL,
    CONSTRAINT fk_uid FOREIGN KEY(uid) REFERENCES account(uid) ON DELETE CASCADE,
	PRIMARY KEY (uid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# table contact
CREATE TABLE IF NOT EXISTS contact(
    user1 int(11) NOT NULL,
    user2 int(11) NOT NULL,
    status enum('pending',  'confirmed',  'rejected',  'blocked'),
    last_msg_read int(11) DEFAULT 0,
    CONSTRAINT fk_user1 FOREIGN KEY (user1) REFERENCES account(uid) ON DELETE CASCADE,
    CONSTRAINT fk_user2 FOREIGN KEY (user2) REFERENCES account(uid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# table conversation
CREATE TABLE IF NOT EXISTS conversation(
    conv_id int(11) NOT NULL AUTO_INCREMENT,
    users varchar(255) DEFAULT '0, 0',
    PRIMARY KEY(conv_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# table message
CREATE TABLE IF NOT EXISTS message(
    msg_id int(11) NOT NULL AUTO_INCREMENT,
    content varchar(255) NOT NULL DEFAULT '',
    date_time timestamp,
    user int(11),
    conv_id int(11),
    CONSTRAINT fk_user
    FOREIGN KEY(user) REFERENCES account(uid) ON DELETE RESTRICT,
    CONSTRAINT fk_conv
    FOREIGN KEY(conv_id) REFERENCES conversation(conv_id) ON DELETE CASCADE,
    PRIMARY KEY(msg_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# table login_status
CREATE TABLE IF NOT EXISTS login_status(
    uid int(11) NOT NULL,
    last_user_activity timestamp NOT NULL,
    last_client_ping timestamp NOT NULL,
    status enum('online', 'offline', 'busy', 'idle') DEFAULT 'offline',
    initiator enum('auto', 'manual') DEFAULT 'auto',
    CONSTRAINT fk_login_status
    FOREIGN KEY(uid) REFERENCES account(uid),
    PRIMARY KEY(uid)
)ENGINE=InnoDB DEFAULT CHARSET=latin1

# event offline_status
DELIMITER ||
CREATE EVENT offline_status
    ON SCHEDULE EVERY 5 MINUTE
    DO
        BEGIN
            UPDATE login_status SET status = 'offline'
            WHERE TIMESTAMPDIFF(SECOND, last_client_ping, NOW()) > 300 
            AND initiator <> 'auto';
        END||
DELIMITER ;

SET GLOBAL event_scheduler = ON;