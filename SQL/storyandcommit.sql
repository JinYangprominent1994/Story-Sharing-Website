table user {
| user  | CREATE TABLE `user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 |

}


table story {

| story | CREATE TABLE `story` (
  `story_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `story_title` varchar(50) NOT NULL,
  `story_author_id` mediumint(8) unsigned NOT NULL,
  `story_content` varchar(1000) NOT NULL,
  `story_time` datetime NOT NULL,
  `story_link` varchar(200) NOT NULL,
  PRIMARY KEY (`story_id`),
  KEY `story_author_id` (`story_author_id`),
  CONSTRAINT `story_ibfk_1` FOREIGN KEY (`story_author_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 |
}


table comment {

| comment | CREATE TABLE `comment` (
  `comment_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `comment_author_id` mediumint(8) unsigned NOT NULL,
  `comment_story_id` mediumint(8) unsigned NOT NULL,
  `comment_content` varchar(500) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_author_id` (`comment_author_id`),
  KEY `comment_story_id` (`comment_story_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`comment_author_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`comment_story_id`) REFERENCES `story` (`story_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 |

}


table link {

| link  | CREATE TABLE `link` (
  `link_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `link_address` varchar(200) NOT NULL,
  `link_story_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`link_id`),
  KEY `link_story_id` (`link_story_id`),
  CONSTRAINT `link_ibfk_1` FOREIGN KEY (`link_story_id`) REFERENCES `story` (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |

}
