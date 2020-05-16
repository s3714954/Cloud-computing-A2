<html>
<body>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Datastore\DatastoreClient;
$projectId = 's3714954cca2';
# Instantiates a client
$datastore = new DatastoreClient(['projectId' => $projectId]);
if (! isset($_SESSION["userid"])){
echo "<script>alert ('Please login first.'); </script>";
echo "<script>window.location.href='https://s3714954cca2.ts.r.appspot.com/login.php'; </script>";
}
unset($_SESSION["pagenum"]);
unset($_SESSION["maxpagenum"]);
unset($_SESSION["searchpostid"]);
unset($_SESSION["searchauthor"]);
unset($_SESSION["searchtitle"]);
unset($_SESSION["searchcountry"]);
?>

<!--The 3 options for user-->
<center><div style="padding:10%;">
<h1>Welcome, <?php echo  $_SESSION["userid"] ?>.</h1>
Please select what you would like to do. <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="newpost" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/newpost.php'">New post</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="viewpost" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/viewpost.php'">View post</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="viewpost" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/mypost.php'">My post</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="viewpost" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/search.php'">Search post</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="changepassword" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/password.php'">Change your password</button> <br> <br>
&nbsp&nbsp&nbsp&nbsp<button type="button" name="logout" style="width:300px" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/logout.php'">Logout</button> <br> <br>
</div></center>

</body>
</html>