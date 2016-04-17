# File uploads and processing

## Traits
The objective of the FileProcessing and ImagePathing traits is to have you, the
developer, not worry about how or where the files are going to be written. They
are located under the app/Traits folder.

### ImagePathing
The ImagePathing trait basically implements a default folder for each model
automatically. For example, an uploaded image to an object of the User model will
go to the public/images/user folder without you writing a single line of code.
Note that Users with other roles also use the same folder. You can overwrite the
final folder as you please by setting the $class_image_folder attribute. This trait
also sets a default image (default.jpg) for any model.

### FileProcessing
As for FileProcessing, this trait handles the writing of files and images as well
as the compression of files and folders through the createZip function. Controllers
in Lurk inherit this trait as the base controller already makes use of it.

## Admin module interaction
SleepingOwl uploads files and images directly to the public/images/admin/uploads
folder (setting can be changed in app/config/sleeping_owl.php). Without extending
and re-writing part of the SleepingOwl code, you can not customize this folder for
every model you have.

Because of this, our models need to move the files from this default location to
the location set by ImagePathing. This is done in the boot function inside our models.
