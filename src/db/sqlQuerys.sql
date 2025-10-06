DROP DATABASE IF EXISTS [LooperDB];

CREATE DATABASE [LooperDB];

CREATE TABLE [exercices] (
    [id] INTEGER PRIMARY KEY AUTOINCREMENT,
    [title] VARCHAR(255)
);

INSERT INTO exercices (title) VALUES ('Coucou'), ('Voici un exercice'), ('encore un ?');