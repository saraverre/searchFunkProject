# SearchFunk
## Background:
The goal of the project is to collect users data from the API (https://schulcampus.securon.eu/api/documentation) through the terminal and create a simple user interface to search the users.

## Tech Stack:
-  Laravel 9
-  Vue 3
-  Bootstrap 5
-  Phpunit 9
-  MySQL

## Description:
### GetApiData.php: 
Thought the handle method we created a connection to the API, first to get the _access_token_ and then to get the users data. We received the list of users as a Json file and then saved it to the database through the method _create()_ of the ApiUser class.

### ApiUsersController.php
After saving the data to the DB we created a simple search function, that gets as input a name or last name and returns the matching record.
This function is called through an ajax request from a vue function.

### app.js
We created one main method, _search()_ that makes an ajax request through the axios library, to the search method of the ApiUserController. This method is then called from the other 2 methods to show the autocomplete function (_autocomplete()_) and to show the selected user in the list (_pickUser(user)_).

### ApiUserControllerTest.php
For testing purposes we created an extra user with a specific name, we checked if it was indeed created, then we sent a post request to the search function with the specified name with both upper and lowercase letters as search input.



