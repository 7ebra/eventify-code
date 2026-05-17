# eventify-code
# 3. Project Deployment Manual
3.1 Environment Specification
The application was developed and tested on the following local server stack.
ComponentVersionWAMP Server3.4.0 (64-bit)Apache2.4.65PHP8.3.28MySQL8.4.7Operating SystemWindows 10/11 (64-bit)
Any version at or above these figures will run the project without modification. PHP 7.4+ is the technical minimum (for named arguments and str_contains), but 8.3 is what the codebase was written and tested against.

3.2 Prerequisites
Before starting, confirm the following:

WAMP 3.4.0 64-bit is installed. The installer is available at https://www.wampserver.com/en/
The WAMP taskbar icon is green — if it is orange, Apache or MySQL has not started. Right-click the icon and restart all services before proceeding
A browser (Chrome, Firefox, or Edge — any version from 2022 onward)


3.3 Deployment Steps
Step 1 — Copy the project files
Download the project zip file from the link in section 3.5. Extract the folder. Rename it eventify if it is not already named that. Copy the entire folder into:
C:\wamp64\www\
The result should be something like:
C:\wamp64\www\eventify\
    index.php
    login.php
    signup.php
    add-event.php
    view-events.php
    about.php
    guest.php
    process-auth.php
    process-event.php
    config\
        database.php
    includes\
        auth.php
        header.php
        footer.php
    assets\
        css\
            editorial.css
        js\
            main.js
            
Step 2 — Create the database
Open a browser and go to:
http://localhost/phpmyadmin/
Log in with the default WAMP credentials (username: root, password: leave blank). In the left panel, click New. Name the database eventify_db and set the collation to utf8mb4_unicode_ci. Click Create.
Step 3 — Import the SQL schema
With eventify_db selected in the left panel, click the Import tab at the top. Click Choose File and select eventify.sql from the project zip. Leave all other settings as default and click Go.
This creates two tables — users and event_details — with the correct column types, constraints, and character sets. You should see a green success notice when it completes.
