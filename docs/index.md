# Lurk documentation

This is the Lurk documentation. These files are intended to provide explanations
on how to extend Lurk's functionalities.

## Admin module

### Structure
The Admin module is fully located under the app/Admin folder. Exceptions to this rule are:
- SleepingOwl configuration (config/sleeping_owl.php)
- SleepingOwl provider (config/app.php:144)
- Templates (resources/views/admin)

To completely remove the Admin module, remove the folders/files/lines listed above
and remove the dependency from the composer.json file.

Note that the templates are actually being loaded through a namespace that is being
created in the admin bootstrap file.

### Sections
Sections of the Admin module are located in the app/Admin/Sections folder. Each
section also creates a menu entry of its own, so you don't need to manually add
them to either the navigation or routes files (like the Dashboard).

### Addons
There are several addons created in Lurk to make life easier for developers. They
are being loaded (i.e. added to the AliasBinder) in the bootstrap file.
The addons are:

#### BoolFunction
Display column created with the purpose of calling a boolean function to display
a "check" or a "minus" for each object of a table. You can change the Font-awesome
classes with the setTrueClass and setFalseClass functions.

#### Hash
Display column with the purpose of displaying a hash value in several lines (instead
of occupying one huge line in the table). You can change the maximum amount of
characters per line with the setMaxCharactersPerLine function (default is 32).

#### Translatable
This class should be used when you want to translate the value of an attribute.
Its basic usage translates the attribute being shown in the language activated.
However, if the attribute is a reference to another table, you can use the
setReference function to tell the Translatable class to get a custom attribute on
the table being referenced.


## Roles and Models

### Roles
Roles in Lurk have a name and a model. Name is the identifier of the Role and model
is the class that should be used for CRUD actions on that Role. In Lurk, you can
find on 2 base Roles (and models): User and Administrator. Each of these classes
has its own prefix on the roles table. They are "user" and "admin" respectively.

If you want to add more roles, you can add them using a "-" after the prefix. For
example, if you want to have "Moderators" and "Regular users", you can use the User
model for the "Regular users" and add a "user-mod" Role for "Moderators". Both of
these roles will automatically be considered users (and not administrators) because
of the "user" prefix. The same reasoning can be applied to Administrators.

Lurk implements a hash value for users (which you should replicate on your application's
models). Hash values hide the incremental identifier of tables which can be used
for exploit purposes. The default size of hash values is 32 and its characters are
randomized using a 64-chars string for each character (same as YouTube). Consider
moving to hashes of size 64 if your application will have more objects than YouTube
has videos.

Note that models are located in the app/Models folder.

## File uploads and processing
- processFile/Image functions
- Default folders (imagepathing)
- Default images for classes (default.jpg)
- Interaction with Admin module

## Search
- Searchable attributes

## Translations
- Auto-locales
- How to use locales
- One-time translation

## Scripts and Styles
- Location
- Laravel elixir
- Compilation

## Testing
- Structure
- Admin auto-login
