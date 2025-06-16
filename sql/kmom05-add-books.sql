

DELETE FROM book;
INSERT INTO book (title, isbn, author, image) 
VALUES
    ('Around the World in Eighty Days','978-1949460858','Jules Verne','80days.jpg'),
    ('Krig och fred. Vol 1, 1805','978-9174619249','Leo Tolstoy','kf1.jpg'),
    ('Krig och fred. Vol 2, 1806-1812','978-9174619256','Leo Tolstoy','kf2.jpg'),
    ('Krig och fred. Vol 3, 1812','978-9174619263','Leo Tolstoy','kf3.jpg'),
    ('Krig och fred. Vol 4, 1812-1813 / Epilog','978-9174619270','Leo Tolstoy','kf4.jpg');
";