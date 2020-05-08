<html>
<body>

<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Google\Cloud\Storage;

$projectId = 's3714954cca2';
$datastore = new DatastoreClient(['projectId' => $projectId]);
$storage = new StorageClient();
$bucketName = 's3714954cca2.appspot.com';
$bucket = $storage->bucket($bucketName); // Put your bucket name here.

	 $gql_query = $datastore -> gqlQuery ("Select * From post Order by PostID DESC");
	 $result = $datastore->runQuery($gql_query);

	 if (!isset($_SESSION["pagenum"]) &&  $result -> valid() == true){
	 $_SESSION["pagenum"] = $result -> current()["PostID"];
	 $_SESSION["maxpagenum"] = $result -> current()["PostID"];
	 }
	 else {
	 while ($result -> current()["PostID"] > $_SESSION["pagenum"]){
	 $result -> next();
	 }

	 // Find the valid pointer.
	 if (isset ($_POST["rewind"])){
     if ($_SESSION["pagenum"] !=  $_SESSION["maxpagenum"]){
	 $lastnum =  $result -> current()["PostID"] + 1;
	 if ($lastnum != $_SESSION["maxpagenum"]){
	 $result -> rewind();
	 while ($_SESSION["pagenum"] != $lastnum ){
	 $result -> next();
	 $_SESSION["pagenum"]  = $result -> current()["PostID"];
	 }
	 }
	 else {
	 $result -> rewind();
	 $_SESSION["pagenum"]  = $result -> current()["PostID"];
	 }
     }
     else {
     echo "<script>alert ('This is the lastest post.'); </script>";
     }
 	 unset($_POST);
     $_POST = array();
}	 }

	 if (isset ($_POST["next"])){
	 if ($_SESSION["pagenum"] > 1){
	 $nextnum =  $result -> current()["PostID"] - 1;
	 $result -> rewind();
	 while ($_SESSION["pagenum"] != $nextnum ){
	 $result -> next();
	 $_SESSION["pagenum"]  = $result -> current()["PostID"];
	 }
	 }
	 else {
	 echo "<script>alert ('This is the first post.'); </script>";
	 }
 	 unset($_POST);
     $_POST = array();
	 }
?>

<center><div id="postcontent" padding="5%">
<h1><br>View post</h1>
<?php
	 $postid = $result -> current()["PostID"];
	 $author = $result -> current()["Author"];
	 $title = $result -> current()["Title"];
	 $description = $result -> current()["Description"];
	 $country = $result -> current()["Country"];
	 $location = $result -> current()["Location"];
	 $type = $result -> current()["Type"];
	 $path = "https://storage.googleapis.com/s3714954cca2.appspot.com/" . $postid . "." . $type;

	 echo "
	 <table width='740'>
	 <tr>
     <td rowspan='7' width='100'><center><form method='post' action='viewpost.php'><input type='submit' name='rewind' value='Rewind'></center></form></td>
     <th width='50%'>Post ID</th>
     <td width='50%'><center>" . $postid . "</td></center>
     <td rowspan='7' width='100'><center><form method='post' action='viewpost.php'><input type='submit' name='next' value='Next'></center></form></td>
	 </tr>
	 <tr>
     <th>Tittle</th>
     <td><center>" . $title . "</td></center>
	 </tr>
	 <tr>
     <th>Author</th>
     <td><center>" . $author . "</td></center>
	 </tr>
     <tr>
     <th>Description</th>
     <td><center>" . $description . "</td></center>
	 </tr>
	 <tr>
     <td colspan='2'><center><a href='$path'><img src='$path' height = '300' width = '540'></img></a></center></td>" . 
	 "<tr>
	 <th>Country</th>
	 <td><center>" . $country . "</td></center>
	 </tr>
	 <tr>
	 <th>Location</th>
	 <td><center>" . $location ."</td></center>
	 </tr>";
	 if ($type == 'Game' || $location != 'Not mentioned'){
	 $location2 = str_replace(' ','%20',$location);
	 if ($country != 'Unknown'){
	 $googlemappath = 'https://www.google.com/maps/embed/v1/search?q=' .  $country . "%20" . $location2 . '&amp;key=AIzaSyDi7Vk60euuFAzNAOHXhEAKY3qbQwxZw0c';
	 }
	 else{
	 $googlemappath = 'https://www.google.com/maps/embed/v1/search?q=' . $location2 . '&amp;key=AIzaSyDi7Vk60euuFAzNAOHXhEAKY3qbQwxZw0c';
	 }
	 echo "
	 <tr>
	 <td></td>
     <td colspan='2'><center><iframe src='$googlemappath' height='300' width='540' frameborder='0' style='border:0;' aria-hidden='false' tabindex='0' allowfullscreen></center></iframe>
	 </td>
	 <td></td>
	 </tr>";
	 };
	 echo "<tr><td></td><td colspan='2'> <center><br><button type='button' name='goback' onclick='window.location.href=\"https://s3714954cca2.ts.r.appspot.com/main.php \"'>go back to main menu</button></center>
	 </td><td></td>
	 </tr>";
?>
</div></center>
</body>
</html>