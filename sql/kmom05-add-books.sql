

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `isbn` varchar(17) NOT NULL,
  `author` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) 
INSERT INTO `book` VALUES
(3,'Around the World in Eighty Days','978-1949460858','Jules Verne','80days.jpg'),
(4,'Krig och fred. Vol 1, 1805','978-9174619249','Leo Tolstoy','kf1.jpg'),
(5,'Krig och fred. Vol 2, 1806-1812','978-9174619256','Leo Tolstoy','kf2.jpg'),
(6,'Krig och fred. Vol 3, 1812','978-9174619263','Leo Tolstoy','kf3.jpg'),
(7,'Krig och fred. Vol 4, 1812-1813 / Epilog','978-9174619270','Leo Tolstoy','kf4.jpg');
