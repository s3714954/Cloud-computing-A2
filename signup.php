<html>
<body>

<?php
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Datastore\DatastoreClient;
$projectId = 's3714954cca2';
# Instantiates a client
$datastore = new DatastoreClient(['projectId' => $projectId]);
?>

<?php 
if (isset($_POST['submit'])) {
    if (($_POST['password']) == ($_POST['passwordconfirm'])) {
            if(! empty($_POST['userid']) && ! empty($_POST['password'])) {
            $userid = $_POST['userid'];
            $password = $_POST['password'];
            $key = $datastore->key('user',$userid);
            $entity = $datastore->lookup($key);
                if  (isset($entity)) {
                echo "<script>alert ('Sorry, this user ID has been used.'); </script>";
                unset($_POST);
                $_POST = array();
                echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/signup.php') </script>";
                } else {
                        echo "<script>alert ('Sign up successfully. Redirect to login page now.'); </script>";
                        $key = $datastore->key('user', $userid);
                        $task = $datastore->entity($key, [
                        'password' => $password
                        ] );
                        $datastore->insert($task);
                        unset($_POST);
                        $_POST = array();
                        echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/login.php') </script>";
                }
            } else {
            echo "<script>alert ('ID or password can not be empty.'); </script>";
            unset($_POST);
            $_POST = array();
            echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/signup.php') </script>";
            exit;
            }
    } else {
        echo "<script>alert ('The password is not equal to the confirmation.'); </script>";
        unset($_POST);
        $_POST = array();
        echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/signup.php') </script>";
        exit;
    }
}
?>
<center><div style="padding:10%;">
<h1>Sign up</h1>

<form method="post" action="signup.php">  
Please type the ID here <br>
<input name="userid" type="text" maxlength="20" minlength="5"> <br> <br>
Please type the password here <br>
<input name="password" type="password" maxlength="20" minlength="5"> <br> <br>
Please type the password again for confirmation here <br>
<input name="passwordconfirm" type="password" maxlength="20" minlength="5"> <br> <br>
<input type="submit" name="submit" value="signup"/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" name="goback" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/login.php'">go back</button>
</form>
</div></center>

</body>
</html>