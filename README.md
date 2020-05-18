# Brooklyn Film Festival

## About
```
This tool is to replace a significant amount of work in the production of the yearly Brooklyn Film Festival. Before this tool, the production process consisted of gathering data from about 5 different platforms and having to sift through hundreds of emails. The process took over 2 weeks. This tool has cut that down to about 3 days and further changes will probably make it a 1 day job.

The goal is to eventually link this to the bff.org's Wordpress DB, via Rest API.

LAMP CMS, with the UI being refactored in React.

Initially considered Vue as the UI, but have since switched to React, as I am able to incrementally apply it, instead of having to rebuild, the entire application, from the ground up.

The UI was originally built in JS, HTML, CSS & jQuery, as a prototype for a more robust implementation.

The MySQL DB takes advantage of the newish JSON data type, storing the exportable data in a JSON formatted cell, again, as the intent of this CMS is to eventually link directly to the Wordpress import. This is the groundwork for the Rest API to do that.
```

## Todo
```
This system was setup under the assumption that all films were being imported from an .xls Film Freeway dump. This assumption led to the singular importance of the SUBMIT_ID(BKLN1234) assigned to each film, via Film Freeway.

This id was to be unique and all edits and whatnot where supposed to add a new record to the DB, that referenced this ID. But the entire Short Doc category was not on Film Freeway, so a workaround(hack) had to be implemented, assigning an arbitrary ID(CSTM1234) to these special films.

As it turns out this was wrong. There were films, not in Film Freeway, that only existed in the lineup G Doc and had to be imported manually. Many of these had almost no data, at all.

1. The system must be refactored to for unique identifiers be based upon the original title(including definite article - "The Greatest Film") and year, as 2 films could have the same name, from different years.

2. For next year's festival, years must be implemented, starting with 2020. Start by assigning all existing films to 2020.

3. A login for admins and guest access must be allowed for folks viewing portfolio.

4. Using PHP's GD library, add the ability to drop a folder of images onto a page, which will format, name and upload them. Each subsequent dropping of a folder, initializes the images, for that film.

5. Change all references of submission_id to submit_id, including in the DB.

6. Add ability to add a note from edit.php

7. Update the import script to do everything on the list of import.php

```
