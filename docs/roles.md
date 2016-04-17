# Admin module

## Roles
Roles in Lurk have a name and a model. Name is the identifier of the Role and model
is the class that should be used for CRUD actions on that Role. In Lurk, you can
find on 2 base Roles (and models): User and Administrator. Each of these classes
has its own prefix on the roles table. They are "user" and "admin" respectively.

If you want to add more roles, you can add them using a "-" after the prefix. For
example, if you want to have "Moderators" and "Regular users", you can use the User
model for the "Regular users" and add a "user-mod" Role for "Moderators". Both of
these roles will automatically be considered users (and not administrators) because
of the "user" prefix. The same reasoning can be applied to Administrators.

## Models
Models are located in the app/Models folder. There are 3 so far: Role, User and
Administrator. The last inherits from the User model.

Lurk implements a hash value for users (which you should replicate on your application's
models). Hash values hide the incremental identifier of tables which can be used
for exploits . The default size of hash values is 32 and its characters are randomized
using a 64-chars string for each character (same as YouTube). Consider moving to
hashes of size 64 if your application will have more objects than YouTube has videos.
