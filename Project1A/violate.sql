/*Duplicate primary key Movie.id*/
insert into Movie
values (4734, "Time", 1999, "R", "ABC");
/*ERROR 1062 (23000): Duplicate entry '4734' for key 'PRIMARY'*/

/*Year out of range*/
insert into Movie
values (5000, "Time", 1800, "R", "ABC");

/*MPAA not matching*/
insert into Movie
values (5000, "Time", 1999, "A", "ABC");

/*Duplicate primary key Actor.id*/
insert into Actor
values (68632, "Jiang", "Yunong", "male", "1995-12-26", Null);
/*ERROR 1062 (23000): Duplicate entry '68632' for key 'PRIMARY'*/

/*Date of birth is earlier than 1850*/
insert into Actor
values (70000, "Jiang", "Yunong", "male", "1800-12-26", Null);

/*Date of birth is later than date of death*/
insert into Actor
values (70000, "Jiang", "Yunong", "male", "1995-12-26", "1994-01-03");

/*Sales id mismatch*/
insert into Sales
values (5000, 5, 1500);
/*ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Sales`, CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*Sales ticketsSold is greater than 0*/
insert into Sales
values (4734, 0, 1500);

/*Director's id is duplicate*/
insert into Director
values (16, "Bhargava", "Rishi", "1996-04-01", Null);
/*ERROR 1062 (23000): Duplicate entry '16' for key 'PRIMARY'*/

/*Date of birth is earlier than 1850*/
insert into Director
values (1, "Bhargava", "Rishi", "1800-12-26", Null);

/*Date of birth is later than date of death*/
insert into Director
values (1, "Bhargava", "Rishi", "1996-04-01", "1994-01-03");

/*MovieGenre's mid not found in Movie's id*/
insert into MovieGenre
values (5000, "A");
/*ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*MovieDirector's mid not found in Movie's id*/
insert into MovieDirector
values (5000, 16);
/*ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*MovieDirector's did not found in Director's id*/
insert into MovieDirector
values (4734, 1);
/*ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))*/

/*MovieActor's mid not found in Movie's id*/
insert into MovieActor
values (5000, 68632, "hero");
/*ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*MovieActor's aid not found in Actor's id*/
insert into MovieActor
values (4734, 70000, "hero");
/*ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))*/

/*MovieRating's mid not found in Movie's id*/
insert into MovieRating
values (5000, 9, 90);
/*ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieRating`, CONSTRAINT `MovieRating_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

/*MovieRating's imdb greater than 10*/
insert into MovieRating
values (4734, 11, 90);

/*MovieRating's rot greater than 100*/
insert into MovieRating
values (4734, 9, 110);
