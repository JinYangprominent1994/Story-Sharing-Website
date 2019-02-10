# Story Sharing Website

## The Overview of our Website

The URL of file sharing system is http://ec2-52-90-53-14.compute-1.amazonaws.com/~yangjinmodule2/fall2018-module3-group-467364-467527/login.html


## The description of our website

### 1. Login

User can register for a new account before login; or user can visit this website as a visitor.

### 2. The Basic Function

Users can register for accounts and then log in to this website.

Registered users can submit stories and submit comments for every stories. Registered users can view all stories and comments, but they can only delete and edit their own stories and comments.

Visitors can view stories and comments, but they cannot submit stories and comments, edit and delete stories and comments.

A link is associated with each story, and they are stored in table Link.


A session is created when a user logs in, and the session is created;

Passwords are hashed, salted, and checked securely;

Safe from SQL Injection attacks;

Site follows the FIEO philosophy: If users do not input username, password, story_title, story_content, comment_content, error;

CSRF tokens are passed when creating, editing, and deleting comments and stories;

## Creative Portion

### 1. Add date for every stories

When users submit a story, date and time are stored with their story_title, story_link, story_content;

### 2. User can input a specific date to show stories that were submitted in that day.

Registered users and visitors can select a specific date to read stories that were submitted in that day.

They also can read all submitted stories.

### 3. User can add a link for their stories

This story_link is not the link stored in database. When users write a story or edit their own story, they can add a link to help read capture more information from their stories, like http://www.google.com/.

### 4. User can check the current date, timezone and time

Users can check the date, timezone and time if they click the button "date".

### 5. User can search story that they wish to view

If users input a word, or several letters or even one letter, stories' titles that include these letters would be showed, and user can  jump to the story page to read the content and comments of this story.

For example, if users want to read story "good", they can input "good" or "oo" or "g" or "d" or "GOOD" or "OO" or "G" or "D".

### 6. User can show one person's profile

Users can check all stories and comments that are submitted by a specific username.

If users input a username, all stories and comments that are submitted by this username would be selected, and story_title with a link and comment_content would be showed to searcher.

### 7. User can change his/her user_name

Users can change his/her username if this new username is not used by others.

### 8. User can change his/her password

Users can change his/her password, and new password would be hashed an then are stored into the database.

Users have to pass the old password verification.

### 9. User can delete one person's all comments

Users can delete all comments that are submitted by a specific username.
