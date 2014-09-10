=== Localizations for latch-plugin-wordpress ===
Contributors: Juan Luis Podadera <www.softbreakers.com>
Tags: localization, plugin
License: GPLv2

This files allow WordPress administrators to integrate Latch on his/her WordPress service with translated UI strings.

== Description ==

Latch plugin introduces interfaces for administrator settings and for WordPress users in order to activate Latch service in their accounts.  

Each .PO file contains plain text with pairs of "msgid" strings and the translated "msgstr" value for the specified language. In order to be loaded by WordPress, .PO files must be compiled to .MO format.

For new translations, you have to generate a new .PO file with "msgstr" values translated to new language. After translating all values, new .PO file must be compiled to .MO.

Filename format for each pair of .PO and .MO files is "latch-xx_YY", where "xx" identifies language and "YY" identifies country. For example "latch-es_ES" corresponds to spanish for Spain. 'WPLANG' WordPress constant defines which language file is going to be loaded.

New translation files can generated with aid of free tools like I18n tools or PoEdit:

http://codex.wordpress.org/I18n_for_WordPress_Developers
http://poedit.net/

== Installation of language files ==

* Localization files must be installed in "languages" folder, inside Latch plugin installation folder.

* At least .MO file for desired language (as defined by WPLANG constant) is mandatory. .PO file will let you to modify translation, so installation of .PO files is optional.

* At initialization, plugin will try automatically to load the defined language file by WPLANG constant. If the language file is not present, 