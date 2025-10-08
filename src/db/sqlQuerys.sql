CREATE TABLE [exercises] (
    [id] INTEGER PRIMARY KEY AUTOINCREMENT,
    [title] VARCHAR(255),
    [status] TEXT CHECK([status] IN ('Building', 'Answering', 'Closed')) NOT NULL DEFAULT 'Building'
);

INSERT INTO exercises (title, status) VALUES ('Coucou','Building'), ('Voici un exercice','Answering'), ('encore un ?','Answering');