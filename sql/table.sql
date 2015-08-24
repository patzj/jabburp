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
	gender varchar(6) DEFAULT NULL,
	about varchar(255) DEFAULT NULL,
	PRIMARY KEY (uid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;