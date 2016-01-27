# OpenTroubleTicketingBoard
An Open Trouble Ticketing Board!

Hello everybody!

I'm proud to show my new project: an open source Trouble Ticketing Board!

I'll use all my new acquired knowledges to write an ITIL like board to manage issues. 

I did not checked if something like this already exists..I'm pretty sure about that, 
but I need something to work on during my spare time :)

This time, the entire project will be in English.

-setup step:

What the SETUP does?

1) Acquires data from user about MySQL hostname, user, password and a custom db name
2) generate the DB named by the user
3) create the db.php which will be used to connect to MySQL for future uses
4) acquires admin's info
5) generate the users table, adding the admin
6) acquires board's info 
7) generate the board table, adding the data just inserted
8) move setup.php in _installFolder and move login.php to root

-login step:
1) check if setup is completed: if not, tries to do it, otherwise ask for a new installation
2) just login user :)


TO DO:
1) CRUD for users 
2) CRUD for tech's group
3)..

Feel free to contact me for any doubts or critics: www.gennarotamburrelli.eu

The code, as always, is completely free. If you use it, just name me :)
And if I helped you to understand something, name me twice :P


