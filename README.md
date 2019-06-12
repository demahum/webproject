# notes

This is the note app written in PHP.

Functionalities:

1. Displaying existing notes.
2. Adding new note.

Stuff used to build it:
1. FlightPHP
2. PHP PDO
3. PHP DOM

It will not work out of the box, as you would need to for example clone FlightPHP and set it up for this project.
DB is also not included here, but you can use the following query to create the schema it expects:

create table notes(id INT NOT NULL AUTO_INCREMENT, content VARCHAR(300) NOT NULL, submission_date DATE, PRIMARY KEY ( id ));

You will also need to modify DB credentials in the code.

Note that this project is far from best practices, actually it probably goes into category of worst practices, so use with caution.
