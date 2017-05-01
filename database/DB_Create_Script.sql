/*mysqldump.php version  */
/* Table structure for table `RegTranslate` */
DROP TABLE IF EXISTS `RegTranslate`;

CREATE TABLE `RegTranslate` (
  `regValue` varchar(45) NOT NULL,
  `regDesc` varchar(45) NOT NULL,
  `regStatus` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`regValue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* dumping data for table `RegTranslate` */
insert into `RegTranslate` values
('bletchley','Bletchley Park',0),
('buffet','Friday Buffet',0),
('dinner','Saturday Dinner',0),
('enigma','Enigma Machine Talk',0),
('health','Health Screen',0),
('hotel','Hotel booking',0),
('paygdinner','PAYG Sunday Dinner',0),
('poker','Poker',0),
('satalk','Self Awareness Talk',0),
('swimming','Swimming Lesson',0),
('website','Build Your Own Website',0);

/* Table structure for table `RegisterList` */
DROP TABLE IF EXISTS `RegisterList`;

CREATE TABLE `RegisterList` (
  `ID` int(10) unsigned default NULL,
  `userFullName` varchar(129) default NULL,
  `regEvent` varchar(20) default NULL,
  `regStatus` int(10) unsigned default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Table structure for table `Registration` */
DROP TABLE IF EXISTS `Registration`;

CREATE TABLE `Registration` (
  `userId` int(10) unsigned NOT NULL,
  `regEvent` varchar(20) NOT NULL,
  `regStatus` int(10) unsigned NOT NULL default '1',
  `CMCount` int(11) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/* dumping data for table `Registration` */
insert into `Registration` values
(10,'hotel',1,0),
(10,'paygdinner',1,0),
(10,'buffet',1,0);

/* Table structure for table `Virtuals` */
DROP TABLE IF EXISTS `Virtuals`;

CREATE TABLE `Virtuals` (
  `userID` int(10) unsigned NOT NULL,
  `vName` varchar(64) NOT NULL,
  `vRelation` varchar(64) NOT NULL,
  PRIMARY KEY  (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;


/* Table structure for table `carShare` */
DROP TABLE IF EXISTS `carShare`;

CREATE TABLE `carShare` (
  `regEvent` varchar(20) NOT NULL,
  `userId` int(11) default NULL,
  PRIMARY KEY  (`regEvent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* dumping data for table `carShare` */
insert into `carShare` values
('bletchley',30);

/* Table structure for table `loggedUsers` */
DROP TABLE IF EXISTS `loggedUsers`;

CREATE TABLE `loggedUsers` (
  `userId` int(11) NOT NULL default '0',
  `sessionId` char(32) NOT NULL default '',
  `loginTime` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastAccess` datetime default NULL,
  PRIMARY KEY  (`userId`,`sessionId`),
  KEY `lastAccess` (`lastAccess`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* dumping data for table `loggedUsers` */
insert into `loggedUsers` values
(1,'0f1ff85e3c8e734eb82ad78d8b908f94','2010-10-05 08:23:45','2010-10-05 08:24:05'),
(3,'be48a4b34c18c73a67ef178b16a0dd45','2010-10-05 08:24:05','2010-10-05 08:24:05');

/* Table structure for table `paygOptions` */
DROP TABLE IF EXISTS `paygOptions`;

CREATE TABLE `paygOptions` (
  `paygID` int(10) unsigned NOT NULL auto_increment,
  `paygName` varchar(45) NOT NULL,
  `paygGenre` varchar(60) default NULL,
  `paygSuggest` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`paygID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/* dumping data for table `paygOptions` */
insert into `paygOptions` values
(1,'Nandos','peri-peri chicken',10),
(3,'The Eight Blessings','Chinese Dim Sum',53),
(5,'Zen Garden','Oriental (mainly Chinese) buffet - just down from hotel',22);

/* Table structure for table `sessions` */
DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `session_id` varchar(32) NOT NULL default '',
  `session_data` text NOT NULL,
  `session_expiration` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/* Table structure for table `siteContent` */
DROP TABLE IF EXISTS `siteContent`;

CREATE TABLE `siteContent` (
  `pID` int(11) NOT NULL auto_increment,
  `Heading` char(40) default NULL,
  `menuTitle` char(25) default NULL,
  `mID` char(5) default NULL,
  `menuLevel` tinyint(4) default NULL,
  `accessLevel` tinyint(4) NOT NULL,
  `url` char(40) default NULL,
  PRIMARY KEY  (`pID`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

/* dumping data for table `siteContent` */
insert into `siteContent` values
(1,'The Unoff Weekend 3','Home','m1',1,1,'../core/main.php'),
(2,'Login','Login','m2',1,1,'../core/login.php'),
(3,'Logout','Logout','m3',1,1,'../core/logout.php'),
(5,'The Unoff Weekend 3','Index','m5',0,1,''),
(10,'User Administration','User Administration','m10',2,3,'../admin/useradmin.php'),
(11,'Update User','Update User','m11',0,3,null),
(12,'Update User Profile','Update Profile','m12',0,3,null),
(13,'Update User Status','Update User Status','m12',0,3,''),
(14,'Site Administration','Site Administration','m14',2,3,'../admin/siteadmin.php'),
(15,'Event Administration','Event Administration','m15',2,3,'../admin/eventadmin.php'),
(16,'Database Backup','Database Backup','m16',2,3,''),
(17,'Reports','Reports','m17',2,3,''),
(18,'Access Log','Access Log','m18',2,3,''),
(20,'Change Password','Change Password','m20',2,2,'../core/changepwd.php'),
(21,'Change Profile','Change Profile','m21',2,2,'../core/profile.php'),
(22,'Register for Event','Register','m22',0,2,null),
(23,'Password Reminder','Password Reminder','m23',0,2,null),
(24,'Register a Username','Sign up','m24',2,1,'../core/signup.php'),
(25,'Validate a Username','Validation','m25',0,1,null),
(31,'The Holiday Inn','The Hotel','m31',2,1,'../members/hotel.php'),
(32,'Around Milton Keynes','Milton Keynes','m32',2,1,'../members.location.php'),
(33,'Travel Sharing','Travel Sharing','m33',2,2,''),
(35,'The Friday Night Buffet','The Friday Night Buffet','m35',2,1,''),
(36,'Dinner on Saturday Night','Dinner on Saturday Night','m36',2,1,''),
(37,'PAYG Dinner on Sunday','PAYG Dinner','m37',2,1,''),
(41,'Murder!','Murder!','m41',2,1,''),
(42,'Talk - Self Awareness','Self Awareness','m42',2,1,''),
(43,'Talk - The Enigma Machine','The Enigma Machine','m43',2,1,''),
(44,'Talk - Build your own Website','Build your own Website','m44',2,1,''),
(45,'Competitions','Competitions','m45',2,1,''),
(46,'Poker','Poker','m46',2,1,''),
(47,'Open Mike Night','Open Mike Night','m47',2,1,''),
(48,'Indoor Skiing','Skiing','m48',2,1,''),
(49,'Indoor Wall Climbing','Wall Climbing','m49',2,1,''),
(50,'Walks','Walks','m50',2,1,''),
(51,'Treasure Hunt','Treasure Hunt','m51',2,1,''),
(52,'Swimming Lessons','Swimming Lessons','m52',2,1,''),
(53,'Crafts','Crafts','m53',2,1,''),
(54,'Booking Information','Booking nformation','m54',2,2,''),
(55,'Whos Who','Whos Who','m55',2,2,''),
(56,'Health Screening','Health Screen','m56',2,1,''),
(57,'Bletchley Park','Bletchley Park','m17',2,1,'');

/* Table structure for table `travelShare` */
DROP TABLE IF EXISTS `travelShare`;

CREATE TABLE `travelShare` (
  `userId` int(10) unsigned NOT NULL auto_increment,
  `travelFrom` varchar(60) NOT NULL,
  `travelOut` varchar(25) NOT NULL,
  `travelBack` varchar(25) NOT NULL,
  `wantOffer` varchar(10) NOT NULL,
  PRIMARY KEY  (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/* Table structure for table `userProfile` */
DROP TABLE IF EXISTS `userProfile`;

CREATE TABLE `userProfile` (
  `userId` int(11) NOT NULL default '0',
  `userFirstName` varchar(64) NOT NULL default '',
  `userEmail` varchar(64) NOT NULL default '',
  `userLastName` varchar(64) NOT NULL default '',
  `userCity` varchar(64) NOT NULL default '',
  `userState` varchar(64) NOT NULL default '',
  `userCountry` varchar(64) NOT NULL default '',
  `userValidationKey` varchar(32) NOT NULL default '',
  `userIP` varchar(32) NOT NULL default '',
  `userSignUp` datetime NOT NULL default '0000-00-00 00:00:00',
  `userValidated` tinyint(1) NOT NULL default '0',
  `userNewsLetter` tinyint(1) default '0',
  `ListName` varchar(64) default NULL,
  `userDescription` varchar(1024) default NULL,
  `Allegiance` varchar(10) NOT NULL,
  `CurrentPhoto` varchar(64) default NULL,
  `OldPhoto` varchar(64) default NULL,
  `userBooked` tinyint(4) default '0',
  `profileTag` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* dumping data for table `userProfile` */
insert into `userProfile` values
(1,'Administrator','','','','','','915d1af3f1bdc574af6a2b3dda376d59','127.0.0.1','2003-11-08 11:22:45',1,1,null,null,'',null,null,0,0),
(3,'Guest','me@here.now','','','','','','','0000-00-00 00:00:00',1,0,'Guest user','Guest user','0',null,null,0,0);

/* Table structure for table `users` */
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userId` int(11) NOT NULL auto_increment,
  `userStatus` tinyint(4) NOT NULL default '0',
  `userName` char(40) NOT NULL default '0',
  `userPassword` char(48) NOT NULL default '0',
  PRIMARY KEY  (`userId`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

/* dumping data for table `users` */
insert into `users` values
(1,3,'admin','ce184e638411ea98c4d2acb2fe92f8d3'),
(3,1,'Guest','5800546c62fddae1dcbc3e98473c3621');



