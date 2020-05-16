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

$query = $datastore->query()
	->filter('Author', '=', intval ($_SESSION['userid']))
	->kind('post')
	->order('PostID', 'DESCENDING');
$result = $datastore->runQuery($query);
$posts = [];
foreach ($result as $entity) {
    array_push($posts, $entity);
}

// 檢查我是否有POST。如果沒有，回到Main.php Correct
if (empty($posts)) {
	echo "<script>alert ('You have not post anything. Redirect to main menu.'); </script>";
	echo "<script>window.location.href='https://s3714954cca2.ts.r.appspot.com/main.php'; </script>";
	exit();
}

$targetPost = null;
$maxPageNum = count($posts);
if (!isset($_GET['p'])) {
	$targetPost = $posts[0];
	$_GET['p'] = 1;
} else {
	$pageNo = $_GET['p'];
	if (!($pageNo < 1 || $pageNo > $maxPageNum)) {
		$targetPost = $posts[$pageNo - 1];
	} else {
		if (!($pageNo < 1)) {
		echo "<script>alert ('It is your first post.'); </script>";
		}
		elseif ($pageNo > $maxPageNum){
		echo "<script>alert ('It is your last post.'); </script>";
		}
	}
}

/*
echo $maxPageNum . " - Session  All Post number <br>";
echo $_SESSION["userid"] . " - Session my user ID <br>";
echo $_SESSION["mylastpost"] . " - My last Post ID <br>";
echo $targetPost["MyPostID"] . " - This post MyPostID <br>";
echo $targetPost["PostID"] . " - This post PostID <br>";
echo $targetPost["Author"] . " - Author <br>";
*/
?>

<center><div id="postcontent" padding="5%">
<?php
$mypostid = $targetPost["MyPostID"];
$postid = $targetPost["PostID"];
$author = $targetPost["Author"];
$title = $targetPost["Title"];
$description = $targetPost["Description"];
$country = $targetPost["Country"];
$location = $targetPost["Location"];
$type = $targetPost["Type"];
$path = "https://storage.googleapis.com/s3714954cca2.appspot.com/" . $postid . "." . $type;
?>

<h1><br>My <?php echo $mypostid; ?> post</h1>
<table width='740'>
<tr>
<td rowspan='7' width='100'><center><input type="button" onclick="window.location.href='?p=<?php echo intval($_GET['p'])-1; ?>'" value="Rewind" <?php if (intval($_GET['p'])-1 <= 0) echo "disabled"; ?>></center></form></td>
<th width='50%'>Post ID</th>
<td width='50%'><center><?php echo $postid; ?></td></center>
<td rowspan='7' width='100'><center><input type="button" onclick="window.location.href='?p=<?php echo intval($_GET['p'])+1; ?>'" value="Next" <?php if (intval($_GET['p'])+1 > $maxPageNum) echo "disabled"; ?>></center></form></td>
</tr>
<tr>
<th>Title</th>
<td><center><?php echo $title; ?></td></center>
</tr>
<tr>
<th>Author</th>
<td><center><?php echo $author; ?></td></center>
</tr>
<tr>
<th>Description</th>
<td><center><?php echo $description; ?></td></center>
</tr>
<tr>
<td colspan='2'><center><a href='<?php echo $path; ?>'><img src='<?php echo $path; ?>' height = '300' width = '540'></img></a></center></td>
<tr>
<th>Country</th>
<td><center><?php echo $country; ?></td></center>
</tr>
<tr>
<th>Location</th>
<td><center><?php echo $location; ?></td></center>
</tr>
<?
if ($type == 'Game' || $location != 'Not mentioned'){
	$location2 = str_replace(' ','%20',$location);
	if ($country != 'Unknown'){
		$googlemappath = 'https://www.google.com/maps/embed/v1/search?q=' .  $country . "%20" . $location2 . '&amp;key=AIzaSyDi7Vk60euuFAzNAOHXhEAKY3qbQwxZw0c';
	}
	else{
		$googlemappath = 'https://www.google.com/maps/embed/v1/search?q=' . $location2 . '&amp;key=AIzaSyDi7Vk60euuFAzNAOHXhEAKY3qbQwxZw0c';
	}
	?> 
	<tr>
	<td></td>
	<td colspan='2'><center><iframe src='<?php echo $googlemappath; ?>' height='300' width='540' frameborder='0' style='border:0;' aria-hidden='false' tabindex='0' allowfullscreen></center></iframe>
	</td>
	<td></td>
	</tr>
	<?php
}
?>
<tr><td></td><td colspan='2'> <center><br><button type='button' name='goback' onclick='window.location.href="https://s3714954cca2.ts.r.appspot.com/main.php"'>go back to main menu</button></center>
</td><td></td>
</tr>
</div></center>
</body>
</html>