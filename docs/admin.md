# Admin module

## Structure
The Admin module is fully located under the app/Admin folder. Exceptions to this rule are:
- SleepingOwl configuration (config/sleeping_owl.php)
- SleepingOwl provider (config/app.php:144)
- Templates for addons (resources/views/admin)

To completely remove the Admin module, remove the folders/files/lines listed above
and remove the dependency from the composer.json file.

Note that the templates are actually being loaded through a namespace that is being
created in the admin bootstrap file.

## Sections
Sections of the Admin module are located in the app/Admin/Sections folder. Each
section also creates a menu entry of its own, so you don't need to manually add
them to either the navigation or routes files (like the Dashboard).

## Addons
There are several addons created in Lurk to make life easier for developers. They
are being loaded (i.e. added to the AliasBinder) in the bootstrap file.
The addons are:

### BoolFunction
Display column created with the purpose of calling a boolean function to display
a "check" or a "minus" for each object of a table. You can change the Font-awesome
classes with the setTrueClass and setFalseClass functions.

### Hash
Display column with the purpose of displaying a hash value in several lines (instead
of occupying one huge line in the table). You can change the maximum amount of
characters per line with the setMaxCharactersPerLine function (default is 32).

### Translatable
This class should be used when you want to translate the value of an attribute.
Its basic usage translates the attribute being shown in the language activated.
However, if the attribute is a reference to another table, you can use the
setReference function to tell the Translatable class to get a custom attribute on
the table being referenced.
