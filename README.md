# Introduction

This plugin displays the Aletheia Project Bible text using the shortcode `[apb-display]`, with an optional `language` attribute for multiple language support.

# Installation

- Upload the .zip file to the plugins page of your WordPress installation
- Go to the “Aletheia Project” settings page under the “Settings” menu in the backend.
- Choose the default language from the dropdown list and save changes.
- After uploading the CSV file (using phpMyAdmin or another MySQL tool of choice) to the database and tables listed by the plugin, go back to the settings page and use the “Create Table of Contents” button to finish the setup.
- On any page, use the shortcode `[apb-display]` to display the default language, or use `[apb-display language="code"]` with one of the codes listed below to manually specify a language.

# CSV Formatting

The CSV file must have these column headers:

- language
- book_id
- localized_book_name
- chapter_num
- verse_num
- verse_text

Any other columns will be ignored.

Use the language code listed below in the language column.

CSV files should be saved with UTF-8 encoding to properly maintain accented and other special characters.

## Sample CSV

See the table below, or download a [starter file](inc/starter.zip).

| language | book_id | localized_book_name | chapter_num | verse_num | verse_text                                                 |
|----------|---------|---------------------|-------------|-----------|------------------------------------------------------------|
| fr-FR    | 1       | Genèse              | 1           | 1         | AU commencement, Dieu créa les cieux et la terre.          |
| fr-FR    | 1       | Genèse              | 1           | 2         | Or la terre était informe et vide, et les ténèbres étaien… |
| fr-FR    | 1       | Genèse              | 1           | 3         | Et Dieu dit : Que la lumière soit; et la lumière fut.      |

## Special Notes

To include the Hebrew letters in Psalm 119, add the lines from the Psalm 119.csv file included in the [starter file](inc/starter.zip)—just make sure that you update the language accordingly and that each line goes in its proper order among the actual verses.


# Language Codes

Note: if you can’t find a language code here, check the official [Library of Congress file](http://www.loc.gov/standards/iso639-2/ascii_8bits.html).

| code           | country                                    |                   
|----------------|--------------------------------------------| 
| af             | Afrikaans                                  | 
| am             | Amharic                                    | 
| ar-sa          | Arabic (Saudi Arabia)                      | 
| as             | Assamese                                   | 
| az-Latn        | Azerbaijani (Latin)                        | 
| be             | Belarusian                                 | 
| bg             | Bulgarian                                  | 
| bn-BD          | Bangla (Bangladesh)                        | 
| bn-IN          | Bangla (India)                             | 
| bs             | Bosnian (Latin)                            | 
| ca             | Catalan Spanish                            | 
| ca-ES-valencia | Valencian                                  | 
| cs             | Czech                                      | 
| cy             | Welsh                                      | 
| da             | Danish                                     | 
| de             | German (generic)                           | 
| de-de          | German (Germany)                           | 
| el             | Greek                                      | 
| en             | English (generic)                          | 
| en-GB          | English (United Kingdom)                   | 
| en-US          | English (United States)                    | 
| es             | Spanish (generic)                          | 
| es-ES          | Spanish (Spain)                            | 
| es-US          | Spanish (United States)                    | 
| es-MX          | Spanish (Mexico)                           | 
| et             | Estonian                                   | 
| eu             | Basque                                     | 
| fa             | Persian                                    | 
| fi             | Finnish                                    | 
| fil-Latn       | Filipino                                   | 
| fr             | French (generic)                           | 
| fr-FR          | French (France)                            | 
| fr-CA          | French (Canada)                            | 
| ga             | Irish                                      | 
| gd-Latn        | Scottish Gaelic                            | 
| gl             | Galician                                   | 
| gu             | Gujarati                                   | 
| ha-Latn        | Hausa (Latin)                              | 
| he             | Hebrew                                     | 
| hi             | Hindi                                      | 
| hr             | Croatian                                   | 
| hu             | Hungarian                                  | 
| hy             | Armenian                                   | 
| id             | Indonesian                                 | 
| ig-Latn        | Igbo                                       | 
| is             | Icelandic                                  | 
| it             | Italian (generic)                          | 
| it-it          | Italian (Italy)                            | 
| ja             | Japanese                                   | 
| ka             | Georgian                                   | 
| kk             | Kazakh                                     | 
| km             | Khmer                                      | 
| kn             | Kannada                                    | 
| ko             | Korean                                     | 
| kok            | Konkani                                    | 
| ku-Arab        | Central Curdish                            | 
| ky-Cyrl        | Kyrgyz                                     | 
| lb             | Luxembourgish                              | 
| lt             | Lithuanian                                 | 
| lv             | Latvian                                    | 
| mi-Latn        | Maori                                      | 
| mk             | Macedonian                                 | 
| ml             | Malayalam                                  | 
| mn-Cyrl        | Mongolian (Cyrillic)                       | 
| mr             | Marathi                                    | 
| ms             | Malay (Malaysia)                           | 
| mt             | Maltese                                    | 
| nb             | Norwegian (Bokmal)                         | 
| ne             | Nepali (Nepal)                             | 
| nl             | Dutch (generic)                            | 
| nl-BE          | Dutch (Netherlands)                        | 
| nn             | Norwegian (Nynorsk)                        | 
| nso            | Sesotho sa Leboa                           | 
| or             | Odia                                       | 
| pa             | Punjabi (Gurmukhi)                         | 
| pa-Arab        | Punjabi (Arabic)                           | 
| pl             | Polish                                     | 
| prs-Arab       | Dari                                       | 
| pt-BR          | Portuguese (Brazil)                        | 
| pt-PT          | Portuguese (Portugal)                      | 
| qut-Latn       | Kiche                                      | 
| quz            | Quechua (Peru)                             | 
| ro             | Romanian (Romania)                         | 
| ru             | Russian                                    | 
| rw             | Kinyarwanda                                | 
| sd-Arab        | Sindhi (Arabic)                            | 
| si             | Sinhala                                    | 
| sk             | Slovak                                     | 
| sl             | Slovenian                                  | 
| sq             | Albanian                                   | 
| sr             | Sranantongo                                | 
| sr-Cyrl-BA     | Serbian (Cyrillic, Bosnia and Herzegovina) | 
| sr-Cyrl-RS     | Serbian (Cyrillic, Serbia)                 | 
| sr-Latn-RS     | Serbian (Latin, Serbia)                    | 
| sv             | Swedish (Sweden)                           | 
| sw             | Kiswahili                                  | 
| ta             | Tamil                                      | 
| te             | Telugu                                     | 
| tg-Cyrl        | Tajik (Cyrillic)                           | 
| th             | Thai                                       | 
| ti             | Tigrinya                                   | 
| tk-Latn        | Turkmen (Latin)                            | 
| tn             | Setswana                                   | 
| tr             | Turkish                                    | 
| tt-Cyrl        | Tatar (Cyrillic)                           | 
| ug-Arab        | Uyghur                                     | 
| uk             | Ukrainian                                  | 
| ur             | Urdu                                       | 
| uz-Latn        | Uzbek (Latin)                              | 
| vi             | Vietnamese                                 | 
| wo             | Wolof                                      | 
| xh             | isiXhosa                                   | 
| yo-Latn        | Yoruba                                     | 
| zh-Hans        | Chinese (Simplified)                       | 
| zh-Hant        | Chinese (Traditional)                      | 
| zu             | isiZulu                                    | 

# Changelog

## 1.0.1
- Add Sranantongo language codes

## 1.0
- Initial plugin
