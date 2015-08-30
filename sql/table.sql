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
    inviter int(11) NOT NULL,
    invitee int(11) NOT NULL,
    status enum('pending',  'confirmed',  'rejected',  'blocked'),
    CONSTRAINT fk_inviter FOREIGN KEY (inviter) REFERENCES account(uid) ON DELETE CASCADE,
    CONSTRAINT fk_invitee FOREIGN KEY (invitee) REFERENCES account(uid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;