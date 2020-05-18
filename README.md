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

The system must be refactored to be based upon the original title, including definite article, and year, as 2 films could have the same name, from different years.

Also, years must be implemented, starting with 2020. Assign all 2020 films this.

```
