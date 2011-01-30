#
# Encoding: Unicode (UTF-8)
#


DROP TABLE bi_recipes;


CREATE TABLE `bi_recipes` (
  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_title` varchar(200) DEFAULT NULL,
  `recipe_image` text,
  `recipe_desc` text,
  `ingredients` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`recipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



