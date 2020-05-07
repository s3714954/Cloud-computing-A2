<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Datastore\DatastoreClient;
$projectId = 's3714954cca2';
# Instantiates a client
$datastore = new DatastoreClient(['projectId' => $projectId]);

if (isset($_POST['submit'])) {
    // Check if any field is empty
    if(! empty($_POST['userid']) && ! empty($_POST['password'])){
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $key = $datastore->key('user',$userid);
    $entity = $datastore->lookup($key);
    // Check if the user input valid id and password. If they are both valid, login
    if  (isset($entity) && $password == $entity['password']){
            $_SESSION["userid"] = $_POST['userid'];
            $_SESSION["userpassword"] = $entity['password'];
            echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/main.php') </script>";
            exit;
        }
        // Pop up a message to remind user input valid id and password
        else{
            echo "<script>alert ('Invalid ID or password.'); </script>";
            unset($_POST);
            $_POST = array();
            echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/login.php') </script>";
        }
    }
    // Pop up a message to remind user input both id and password
    else{
    echo "<script>alert ('ID or password can not be empty.'); </script>";
    unset($_POST);
    $_POST = array();
    echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/login.php') </script>";
    exit;
    }
}
if  (isset($_POST['signup'])) {
echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/signup.php') </script>";
}
?>

<html>  
<body>
<center><div style="padding:10%;">
<img src="/images/logo.png"/>
<br> <br> 
<!-- This a the html form for entering user ID & Password -->
<form method="post" action="login.php">  
<br>
&nbsp&nbsp&nbspID&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp<input name="userid" type="text"> <br> <br>
&nbsp&nbsp&nbspPassword:&nbsp&nbsp<input name="password" type="password"> <br> <br>
&nbsp&nbsp&nbsp<input type="submit" name="submit" value="login"/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="submit" name="signup" value="or click me to register now!"/>  
</form> 
</div></center>

</body>
</html>