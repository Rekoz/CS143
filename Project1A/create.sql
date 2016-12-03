create table Movie(
       id int , 
       title varchar(100), 
       year int, 
       rating varchar(10), 
       company varchar(50),
       primary key (id), /* ids must be unique */
       check(year >= 1850 and year <=2016), /* Years cannot be too early or later than the current year */
       check(rating = 'G' or rating = 'PG' or rating = 'PG-13' or rating = 'R' or rating = 'NC-17') /* MPAA ratings can only be one of G, PG, PG-13, R or NC-17.*/
);

create table Actor(
       id int, 
       last varchar(20), 
       first varchar(20), 
       sex varchar(6), 
       dob date, 
       dod date,
       primary key (id), /* ids must be unique */
       check(dob >= '1850-01-01' and dod > dob), /* Date of birth cannot be too early and date of death should not be earlier than date of birth */
       check(sex = "male" or sex = "female") /* sex can either be male or female */
);

create table Sales(
       mid int, 
       ticketsSold int, 
       totalIncome int,
       foreign key (mid) references Movie(id) /* Referential integrity: mid must appear in Movie.id */
) engine=innodb;

create table Director(
       id int, 
       last varchar(20),
       first varchar(20), 
       dob date, 
       dod date,
       primary key (id), /* ids must be unique */
       check(dob >= '1850-01-01' and dod > dob) /* Date of birth cannot be too early and date of death shou\
ld not be earlier than date of birth */
);

create table MovieGenre(
       mid int, 
       genre varchar(20),
       foreign key (mid) references Movie(id) /* Referential integrity: mid must appear in Movie.id */
) engine=innodb;

create table MovieDirector(
       mid int, 
       did int,
       foreign key (mid) references Movie(id), /* Referential integrity: mid must appear in Movie.id */
       foreign key (did) references Director(id) /* Referential integrity: did must appear in Director.id */
) engine=innodb;

create table MovieActor(
       mid int, 
       aid int, 
       role varchar(50),
       foreign key (mid) references Movie(id), /* Referential integrity: mid must appear in Movie.id */
       foreign key (aid) references Actor(id) /* Referential integrity: aid must appear in Actor.id */
) engine=innodb;

create table MovieRating(
       mid int, 
       imdb int, 
       rot int,
       foreign key (mid) references Movie(id), /* Referential integrity: mid must appear in Movie.id */
       check(imdb >= 0 and imdb <= 10), /* imdb rating can only be between 0 and 10 */
       check(rot >=0 and rot <= 100) /* rot rating can only be between 0% and 100% */
) engine=innodb;

/* Currently won't be used in Project 1A */
create table Review(
       name varchar(20), 
       time timestamp, 
       mid int, 
       rating int, 
       comment varchar(500),
       foreign key (mid) references Movie(id), /* Referential integrity: mid must appear in Movie.id */
       check(rating >= 0 and rating <= 5) /* Review rating can only be between 0 and 5 */
) engine=innodb;

create table MaxPersonID(id int);
create table MaxMovieID(id int);
insert into MaxPersonID values(69000);
insert into MaxMovieID values(4750);
