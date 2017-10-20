# rankwatch17_php_bitbucket
A PHP script that accepts username and password for a BitBucket Account and then logins to that account to extract all the repository names and their links. BitBucket is a free code repository hosting service. You can create your account for free and host as many repositories as you like.

### Requirement
As Bitbucket provides access to its API through RESTful API, we can access the API through cURL,
cURL must be installed with PHP

### Usage
A login page is provided to the user which asks for BitBucket Username and Password, it send a cURL GET request to bitbucket along with the username, like https://api.bitbucket.org/1.0/users/username , the result from bitbucket is a JSON object containing the details of the users along with his Private and Public repositories.
The data received is stored in SESSION Var and user is redirected to the dashboard page where the JSON object is decoded into a PHP associative array and then the inforation about the repositories is accessed through a loop along the accos array.

> A core.inc.php file is included which checks if a user is logged in or not by checking if a SESSION var is set, The Var is set upon successful login, it helps in restricting the user.
