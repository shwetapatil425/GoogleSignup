<?php require ("GoogleAPI/vendor/autoload.php");
//Step 1: Enter you google account credentials

$g_client = new Google_Client();

$g_client->setClientId("925787406948-57ujeof0b01hhg6vvlj762s6jombftj6.apps.googleusercontent.com");
$g_client->setClientSecret("GHQC4E60sCmSu7KKERnUxrnE");
$g_client->setRedirectUri("http://localhost/googlesinup/");
$g_client->setScopes("email");

//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();
//echo "<a href='$auth_url' style='background-color:blue;color:white;'>Login Through Google </a>";

//Step 3 : Get the authorization  code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;

//Step 4: Get access token
if(isset($code)) {

    try {

        $token = $g_client->fetchAccessTokenWithAuthCode($code);
        $g_client->setAccessToken($token);

    }catch (Exception $e){
        echo $e->getMessage();
    }




    try {
        $pay_load = $g_client->verifyIdToken();


    }catch (Exception $e) {
        echo $e->getMessage();
    }

} else{
    $pay_load = null;
}

if(isset($pay_load)){


    

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Sign up</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="google_signin.php">Sign up</a>
            </li>
          </ul>
        </div> 
    </nav>
<?php
    if($_SERVER["REQUEST_METHOD"]=='POST')
    {
    $servername="localhost";
    $username="root";
    $password="";
    $database="practicetocode";
    $name=$_POST['email'];
    $pass=$_POST['pass'];
    $conn=mysqli_connect($servername,$username,$password,$database);
    $sql="INSERT INTO `login` ( `name`, `password`) VALUES ('$name', '$pass');";
    $result=mysqli_query($conn,$sql);
    if($result)
    {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your email '.$name. ' and password has been submitted <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';    }
    else
    {
        echo"Not inserted";
    }
    header('location:products.html');

  }

?>
<div class="container">
    <form action="google_signin.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <?php echo "<a href='$auth_url' style='background-color:blue;color:white;text-decoration:none;'>Login Through Google </a>";?>

    </form>
</div>
    
</body>
</html>
