# Add link module

ALTER TABLE `node` CHANGE `type` `type` ENUM( 'page', 'block', 'news', 'testimonial', 'label', 'link' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
CREATE TABLE IF NOT EXISTS `node_link_content` (
  `node_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8,
  `language` enum('en','vi','kr') NOT NULL DEFAULT 'en',
  PRIMARY KEY (`node_id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;