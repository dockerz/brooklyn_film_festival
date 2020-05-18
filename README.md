# Brooklyn Film Festival

## About
```
LAMP project, using rudimentary React UI.
Originally was using Vue.js, but have changed mind.
```

## Todo
```
This system was setup under the assumption that all films were being imported from an .xls Film Freeway dump. This assumption led to the singular importance of the ID(BKLN1234) assigned to each film, via Film Freeway.

This id was to be unique and all edits and whatnot where supposed to add a new record to the DB, that referenced this ID. But the entire Short Doc category was not on Film Freeway, so a workaround(hack) had to be implemented, assigning an arbitrary ID(CSTM1234) to these special films.

As it turns out this was wrong. There were films, not in Film Freeway, that only existed in the lineup G Doc and had to be imported manually. Many of these had almost no data, at all.

1. The system must be refactored to for unique identifiers be based upon the original title(including definite article - "The Greatest Film") and year, as 2 films could have the same name, from different years.

2. For next year's festival, years must be implemented, starting with 2020. Start by assigning all existing films to 2020.

3. Next, a login for admins and guest access must be allowed for folks viewing portfolio.

4. Using PHP's GD library, add the ability to drop a folder of images onto a page, which will format, name and upload them. Each subsequent dropping of a folder, initializes the images, for that film.

```
