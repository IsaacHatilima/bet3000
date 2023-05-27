CREATE TABLE users
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(150) not NULL,
    status VARCHAR(150) NOT NULL,
    last_login DATETIME NULL,
    date_created DATETIME NULL
);

INSERT INTO users(firstname, lastname, username, password, status) VALUES('John', 'Doe', 'johndoe', '$2y$10$0Hr1gtwKa8hW65cMBcYH0emCfzJOLHicWjPW5cMcuaWNonv7aAlHO','Active')

CREATE TABLE tags
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tag VARCHAR(150) NOT NULL,
    date_created DATETIME NOT NULL,
    user INTEGER NOT NULL,
    FOREIGN KEY(user) REFERENCES users(id)
);

CREATE TABLE blogs
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    body TEXT NOT NULL,
    date_created DATETIME NOT NULL,
    user INTEGER NOT NULL,
    FOREIGN KEY(user) REFERENCES users(id)
);

CREATE TABLE blogs_tags
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    blog INTEGER NOT NULL,
    FOREIGN KEY(blog) REFERENCES blogs(id),
    tag INTEGER NOT NULL,
    FOREIGN KEY(tag) REFERENCES tags(id)
);