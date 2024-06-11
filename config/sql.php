CREATE TABLE `events` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `description` text COLLATE utf8_unicode_ci NOT NULL,
    `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `date` date NOT NULL,
    `start_time` time NOT NULL,
    `end_time` time NOT NULL,
    `google_calendar_event_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `created` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'