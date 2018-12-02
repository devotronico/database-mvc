CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(32) NOT NULL,
  `name` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birth` varchar(10) NOT NULL,
  `fiscalcode` varchar(16) NOT NULL,
  `tel` varchar(16) NOT NULL,
  `email` varchar(16) NOT NULL,
  `street` varchar(16) NOT NULL,
  `cap` varchar(16) NOT NULL,
  `city` varchar(16) NOT NULL,
  `country` varchar(16) NOT NULL,
  `color1` varchar(16) NOT NULL,
  `color2` varchar(16) NOT NULL,
  `level` varchar(16) NOT NULL,
  `look` varchar(16) NOT NULL,
  `info` varchar(255) NOT NULL,
  `cookie` varchar(2) NOT NULL,
  `set_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

/*
INSERT INTO `posts` (`id`, `category_id`, `title`, `body`, `author`) VALUES
(1, 1, 'Technology Post One', 'Lorem ipsum dolor sit amet, consectetur iaculis.','Sam Smith'),
(2, 2, 'Gaming Post One', 'Adipiscing elit.','Kevin Williams'),
(3, 1, 'Technology Post Two', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','Sam Smith'),
(4, 4, 'Entertainment Post One', 'Lorem ipsum dolor sit amet interdum eu consectetur et.','Mary Jackson'),
(5, 4, 'Entertainment Post Two', 'Lorem ipsum dolor sit amet amet quis libero.','Mary Jackson'),
(6, 1, 'Technology Post Three', 'Lorem ipsum do
*/