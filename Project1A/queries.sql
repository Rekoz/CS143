/* Give me the names of all the actors in the movie 'Die Another Day'. Please also make sure actor names are in this format:  <firstname> <lastname>   (seperated by a single space). */
select concat(a.first, ' ', a.last)
from Movie m, Actor a, MovieActor ma
where m.title="Die Another Day" and m.id=ma.mid and ma.aid=a.id;

/* Give me the count of all the actors who acted in multiple movies. */
select distinct count(ma1.aid)
from MovieActor ma1, MovieActor ma2
where ma1.aid = ma2.aid and ma1.mid > ma2.mid;

/* Give me the title of movies that sell more than 1,000,000 tickets. */
select m.title
from Movie m, Sales s
where s.mid=m.id and s.ticketsSold > 1000000;

/* Show movie titles where Director and Actor have smae last name. */
select distinct m.title
from Movie m, Director d, Actor a, MovieDirector md, MovieActor ma
where d.last=a.last and md.mid=m.id and ma.mid=m.id and md.did=d.id and ma.aid=a.id;

/* Show movie that has IMDB greater than 9.0 or Rotten Tomatoes greater than 90%. */
select distinct m.title
from Movie m, MovieRating mr
where m.id=mr.mid and (mr.imdb > 9 or mr.rot > 90);
