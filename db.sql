CREATE TABLE userss (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    date_of_birth DATE,
    telephone VARCHAR(20)
);

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    url VARCHAR(255)

);
CREATE TABLE servies (
    id INT,
    names VARCHAR(255) NOT NULL,
    image VARCHAR(255)و
    urll VARCHAR(255)
);


