-- Table: users
CREATE TABLE `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(15) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ticket_rates
CREATE TABLE `ticket_rates` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `day_type` ENUM('weekday', 'weekend', 'holiday') NOT NULL,
  `show_time` ENUM('morning', 'afternoon', 'evening') NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: movies
CREATE TABLE `movies` (
  `movie_id` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(255) NULL,
  `Description` TEXT NULL,
  `Duration` VARCHAR(30) NULL,
  `URL` VARCHAR(50) NULL,
  `Genre` VARCHAR(40) NULL,
  `Thumbnail` VARCHAR(50) NULL,
  PRIMARY KEY (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: seat_reservations
CREATE TABLE `seat_reservations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `seat_number` VARCHAR(5) NOT NULL,
  `reservation_date` DATE NOT NULL,
  `showtime` TIME NULL,
  `reserved_by` INT(11) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `movie_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`reserved_by`) REFERENCES `users` (`user_id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: archive_booking_table
CREATE TABLE `archive_booking_table` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `seat_number` VARCHAR(5) NOT NULL,
  `reservation_date` DATE NOT NULL,
  `showtime` TIME NULL,
  `reserved_by` INT(11) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `movie_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`reserved_by`) REFERENCES `users` (`user_id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
