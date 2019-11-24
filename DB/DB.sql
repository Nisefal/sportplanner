CREATE DATABASE sportplannerDB;

USE sportplannerDB;
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL 
);

CREATE TABLE IF NOT EXISTS gyms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS requests (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    gym_id INT NOT NULL,
	type VARCHAR(255) NOT NULL,    
    FOREIGN KEY (client_id)
        REFERENCES clients (id)
        ON UPDATE RESTRICT ON DELETE CASCADE,
    FOREIGN KEY (gym_id)
        REFERENCES gyms (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS coaches (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    gym_id INT NOT NULL,
	name VARCHAR(255) NOT NULL,
    FOREIGN KEY (gym_id)
        REFERENCES gyms (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS client_cards (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    gym_id INT NOT NULL,   
    FOREIGN KEY (client_id)
        REFERENCES clients (id)
        ON UPDATE RESTRICT ON DELETE CASCADE,
    FOREIGN KEY (gym_id)
        REFERENCES gyms (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS group_classes (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    gym_id INT NOT NULL,
	name VARCHAR(255) NOT NULL,   
	description VARCHAR(255) NOT NULL,  
    FOREIGN KEY (gym_id)
        REFERENCES gyms (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS equipment (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    gym_id INT NOT NULL,
	name VARCHAR(255) NOT NULL,   
	occupation VARCHAR(255) NOT NULL,  
    FOREIGN KEY (gym_id)
        REFERENCES gyms (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS exercises (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_id INT NOT NULL,
	name VARCHAR(255) NOT NULL,  
	description VARCHAR(255) NOT NULL,  
    FOREIGN KEY (equipment_id)
        REFERENCES equipment (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reservation (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    coach_id INT NOT NULL,
	group_classes_id INT NOT NULL,
	client_card_id INT NOT NULL,
	training_date DATE NOT NULL,
	start_time TIME NOT NULL,
	end_time TIME NOT NULL,
    FOREIGN KEY (coach_id)
        REFERENCES coaches (id)
        ON UPDATE RESTRICT ON DELETE CASCADE,
    FOREIGN KEY (group_classes_id)
        REFERENCES group_classes (id)
        ON UPDATE RESTRICT ON DELETE CASCADE,
    FOREIGN KEY (client_card_id)
        REFERENCES client_cards (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS training (
   	id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_id INT NOT NULL,
    reservation_id INT NOT NULL,
	name VARCHAR(255) NOT NULL,  
	duration FLOAT NOT NULL,  
	break_duration FLOAT NOT NULL,  
	rounds INT NOT NULL,
    FOREIGN KEY (exercise_id)
        REFERENCES exercises (id)
        ON UPDATE RESTRICT ON DELETE CASCADE,
    FOREIGN KEY (reservation_id)
        REFERENCES reservation (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
);


