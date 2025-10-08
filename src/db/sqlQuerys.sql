CREATE TABLE [exercices] (
    [id] INTEGER PRIMARY KEY AUTOINCREMENT,
    [title] VARCHAR(255),
    [status] TEXT CHECK([status] IN ('Building', 'Answering', 'Closed')) NOT NULL DEFAULT 'Building'
);

INSERT INTO exercices (title) VALUES ('Coucou'), ('Voici un exercice'), ('encore un ?');