CREATE DATABASE IF NOT EXISTS movie_booking;
USE movie_booking;

-- Users Table
CREATE TABLE users (
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Movies Table
CREATE TABLE movies (
    movie_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Description TEXT,
    Duration VARCHAR(30),
    URL VARCHAR(50),
    Genre VARCHAR(40),
    Thumbnail VARCHAR(50),
    status ENUM('Now Showing', 'Coming Soon') NOT NULL
);

-- Showtimes Table
CREATE TABLE showtimes (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    movie_id INT(11),
    show_date DATE NOT NULL,
    show_time TIME NOT NULL,
    day_type ENUM('weekday', 'weekend', 'holiday') NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);

-- Ticket Rates Table
CREATE TABLE ticket_rates (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    day_type ENUM('weekday', 'weekend', 'holiday') NOT NULL,
    show_time ENUM('10:00:00', '14:00:00', '18:00:00') NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- Seat Reservations Table
CREATE TABLE seat_reservations (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    seat_number VARCHAR(5) NOT NULL,
    reservation_date DATE NOT NULL,
    showtime TIME NOT NULL,
    reserved_by INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    movie_id INT(11),
    STATUS ENUM('available', 'reserved') NOT NULL DEFAULT 'available',
    FOREIGN KEY (reserved_by) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);

-- Archive Booking Table
CREATE TABLE archive_booking_table (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    seat_number VARCHAR(5) NOT NULL,
    reservation_date DATE NOT NULL,
    showtime TIME NOT NULL,
    reserved_by INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    movie_id INT(11),
    FOREIGN KEY (reserved_by) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);
