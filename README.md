#Introduction

This plugin imports a CSV-formatted file with Bible text to the database and outputs it on the frontend with the shortcode `[aletheia-bible]`

#Formatting

The CSV file must have, at a minimum, these column headers:

- book_id
- localized_book_name
- chapter_num
- verse_num
- verse_text

Any other columns will be ignored.

CSV file should be saved with UTF-8 encoding to properly maintain accented and other special characters.

##Sample CSV

See the table below, or download a [sample empty file](sample.zip).

| book_id | localized_book_name | chapter_num | verse_num | verse_text                                                 |
|---------|---------------------|-------------|-----------|------------------------------------------------------------|
| 1       | Genèse              | 1           | 1         | AU commencement, Dieu créa les cieux et la terre.          |
| 1       | Genèse              | 1           | 2         | Or la terre était informe et vide, et les ténèbres étaien… |
| 1       | Genèse              | 1           | 3         | Et Dieu dit : Que la lumière soit; et la lumière fut.      |
