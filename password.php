<html>
<body>

<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Datastore\DatastoreClient;
$projectId = 's3714954cca2';
# Instantiates a client
$datastore = new DatastoreClient(['projectId' => $projectId]);
?>

<?php 
if (isset($_POST['submit'])) {
        $key = $datastore->key('user',$_SESSION["userid"]);
        $entity = $datastore->lookup($key);
    // Check if the new password is empty. If it is not empty, check if the old password equal to the user's old password
    if (! empty($_POST['newpassword'])) {
        // Check if the old password is correct. If it is correct, update
        if ($_POST['oldpassword'] ==  $entity['password']){
        $transaction = $datastore->transaction();
        $entity['password'] = $_POST['newpassword'];
        $transaction->update($entity);
        $transaction->commit();
        echo "<script>alert ('Update successfully. Redirect to login page now.'); </script>";
        $_SESSION["userpassword"] = $entity['password'];
        unset($_POST);
        $_POST = array();
        echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/login.php') </script>";
        }
        // Pop up a message to remind user input the correct old password
        else{
        echo "<script>alert ('Please input the correct old password.'); </script>";
        unset($_POST);
        $_POST = array();
        echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/password.php') </script>";
        }
    }
        // Pop up a message to remind user enter something to be the new password
        else {
        echo "<script>alert ('New password can not be empty.'); </script>";
        unset($_POST);
        $_POST = array();
        echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/password.php') </script>";
    }
}
?>
<center><div style="padding:15%;">
<h1>Change your password</h1>

<form method="post" action="password.php">  
Please type the old password here <br>
<input name="oldpassword" type="password"> <br> <br>
Please type the new password here <br>
<input name="newpassword" type="password"> <br> <br>
<input type="submit" name="submit" value="change"/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" name="goback" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/main.php'">go back</button>
</form>
</div></center>
</body>

</html>