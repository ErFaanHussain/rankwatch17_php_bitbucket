<?php
  include('includes/core.inc.php');
  if(loggedIn()){
    header('Location:dashboard.php');
    // if user already logged in, redirect him to dashboard.php
  }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>BitBucket Interface</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--Bootstrap, jQuery, Tether, Bootstrap JS, Font Awesome CDNs  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<body>
  <!--    full width bootstrap container for NavBar -->
<div class="container-fluid px-0">
  <nav class="navbar navbar-inverse bg-primary">
    <div class="navbar-brand mx-auto">BitBucket Interface</div>
  </nav>
</div>
<!-- container for input form -->
<div class="container">
  <!--form in half of grid and centered -->
	<div class="col-md-6 mx-auto mt-5" >
    <ul class="nav nav-tabs">
			<li class="nav-item">
				<span class="nav-link active"><h6>Login</h6></span>
			</li>
		</ul>
    <div class="tab-content">
      <div class="tab-pane fade show active">
        <form id="loginForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <div class="form-group">
            <label class="col-form-label" for="username">Enter GitBucket Username</label>
            <input type="text" class="form-control" id="uid" name="username" value="" placeholder="Username">
          </div>
          <div class="form-group">
            <label class="col-form-label" for="pwd">Enter GitBucket Password</label>
            <input type="password" class="form-control" id="pwd" name="password" value="" placeholder="Password">
          </div>
          <!-- bootstrap alert to alert user of errors and success messages -->
          <div id="loginAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">
               <span aria-hidden="true">&times;</span>
               </button>Please Login First
          </div>
          <div class="form-group">
          <div class="text-center">
            <button type="submit" class="btn btn-primary" name="loginSubmit">Login</button>
            <button type="reset" class="btn btn-danger ml-md-5">Cancel</button>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</body>
</html>
<?php
if(isset($_POST["loginSubmit"]))
	{
		if(isset($_POST["username"]) && isset($_POST["password"])) //check if username and password set
		{
			$uname = $_POST["username"];
			$pass = $_POST["password"];
			if (empty($uname) || empty($pass)) //check if username and password aren't empty, then alert user, if empty
			{ ?>
				<script>
          jQuery("#loginAlert").html('<button type="button" class="close" data-dismiss="alert"><span> &times; </span> </button>Please Enter Username and Password');
        </script>
			<?php }
			else
			{
        // since bitbucket provides RESTful API, we will use cURL for request
        $ch = curl_init(); //initialize cURL and set operation parameters
        curl_setopt($ch, CURLOPT_URL, "https://api.bitbucket.org/1.0/users/".$uname); // REST bitbucket API url
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //cURL return transfer
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); //HTTP verb
        curl_setopt($ch, CURLOPT_USERPWD, $uname . ":". $pass); //authentication
        $result = curl_exec($ch); //execute cURL
        curl_close ($ch); //close cURL handler
        if (empty($result)) { //check for result, alert user if empty
          ?>
    				<script>
              jQuery("#loginAlert").html('<button type="button" class="close" data-dismiss="alert"><span> &times; </span> </button>Username or Password Incorrect');
            </script>
    			<?php
        }
        else{
          //success, get data and decode it to associative array
          $res = json_decode($result,true);
          //set session vars, to be used for
          $_SESSION["user"] = $uname;
          $_SESSION["name"] = $res["user"]["display_name"];
          $_SESSION["data"] = $res; //saving data in session var
          header('Location:dashboard.php'); //redirect user to dashboard
        }
			}
		}
	}
?>
