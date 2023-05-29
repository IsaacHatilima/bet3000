# bet3000

# INSTALLATION STEPS

1. Create a database in your MySQL database server with name bet
2. Copy and run the code in the Schema.sql file, the plain password is Password and username is johndoe
3. Rename dbConfigExample.php to dbConfig.php and update the variables according to you workstation values
4. Run the application on localhost/bet3000 to access and use the application

# Project Description

This is an "improved" clone of Fefes Blog. the application was developed using the lates PHP version 8.2. The application was done using PHP OOP and PDO query management.
The filter is done by clicking a tag appearing on the right side of the screen, this has been done to easily show users all available tags to choose from, the tags and blogs only have create, read and delete functionality. For the UI, Bootstrap 5 was used.

# File Structure

-admin

    -ajax

        -blog.js

        -tagJS.js

    -core

        -blogLogic.php

        -logout.php

        -tagsLogic.php

    -includes

        -header.php

    -pages

        -blogs.php

        -index.php

        -tags.php

-auth

    -ajax

        -auth,js

    -core

        -core.php

    -index.php

-config

    -dbConfigExample.php

-.gitignore

-.htaccess

-index.php

-README.md

-Schema.sql