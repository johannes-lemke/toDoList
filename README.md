# to-do-list

A simple self-hosted to-do list to keep track of your open and completed to-dos

## Requirements

A XAMPP environment is required to host this to-do list. Download and install here: 

```https://www.apachefriends.org/de/index.html```

In addition, the following database environment is required:

`CREATE DATABASE todo_db;`

```CREATE TABLE Todo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bezeichnung VARCHAR(255) NOT NULL,
    faelligkeit DATE DEFAULT CURRENT_DATE,
    status INT(1) DEFAULT 0
);```

`CREATE TABLE toggle (
    state TINYINT PRIMARY KEY DEFAULT 0
);`

`INSERT INTO config (setting, value) VALUES ('toggle_only_open_todos', 0);`
