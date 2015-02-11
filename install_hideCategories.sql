DROP TABLE IF EXISTS `hide_categories`;
CREATE TABLE `hide_categories` (
  `hide_categories_id` int(11) NOT NULL auto_increment,
  `categories_id` int(11) NOT NULL,
  `visibility_status` int(11) NOT NULL,
  PRIMARY KEY  (`hide_categories_id`)
);
