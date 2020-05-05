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

<!--The 3 options for user-->
<center><div style="padding:15%;">
<h1>Welcome, <?php echo  $_SESSION["userid"] ?>.</h1>
Please select what you would like to do. <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="newpost" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/newpost.php'">New post</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="viewpost" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/viewpost.php'">View post</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="changepassword" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/password.php'">Change your password</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="logout" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/login.php'">Logout</button> <br> <br>
</div></center>
</body>
</html>