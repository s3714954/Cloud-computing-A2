<html>
<body>

<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Storage\StorageClient;
$projectId = 's3714954cca2';
$datastore = new DatastoreClient(['projectId' => $projectId]);
# Instantiates a client

$title;
$description;
$country;
$location;
$gql_query;
$postid;

if(isset($_POST["post"])) {

	 $title = $_POST['title'];

	 if(!empty ($_POST['description'])){
	 $description = $_POST['description'];
	 }
	 else {
	 $description = "None";
	 }

     $country = $_POST['country'];

	 if(!empty ($_POST['location'])){
     $location = $_POST['location'];
	 }
	 else{
	 $location = "Not mentioned";
	 }

	 // Check file size
if ($_FILES["fileToUpload"]["size"] > 500000000) {
    echo "<script>alert ('Sorry, your file is too large.'); </script>";
	unset($_POST);
    $_POST = array();
}

// rename uploaded photo by checking Gcloud last post in same title
	 // $gql_query = new Google_Service_Datastore_GqlQuery();
	 $gql_query = $datastore -> gqlQuery ("Select PostID From post Order by PostID DESC");
	 $result = $datastore->runQuery($gql_query);
	 if ($result -> current() != null){
	 $result = $result -> current()["PostID"];
	 $postid = (int) $result;
	 $postid = $postid + 1;
	 }
	 else {
	 $postid = 1;
	 }

	 $query = $datastore->query()
	 ->filter('Author', '=', $_SESSION['userid'])
	 ->kind('post')
	 ->order('PostID', 'DESCENDING');
	 $result = $datastore->runQuery($query);
	 $posts = [];
	 foreach ($result as $entity) {
     array_push($posts, $entity);
	 }
	 if (!empty($posts)) {
	 $mypostid = count($posts);
	 $mypostid = $mypostid + 1;
	 }
	 else {
	 $mypostid = 1;
	 }

	 $filename = $_FILES['fileToUpload']['name'];
	 $ext = pathinfo($filename, PATHINFO_EXTENSION);
	 if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg' && $ext !='PNG' && $ext != 'JPG' && $ext != 'JPEG' && $ext != 'Png' && $ext != 'Jpg' && $ext != 'Jpeg') {
     echo "<script>alert ('Please upload a png, jpg or jpeg file.'); </script>";
	 unset($_POST);
     $_POST = array();
	 }
	 else {
// upload to gcloud bucket
	$bucketName = 's3714954cca2.appspot.com';
	$objectName = $postid . '.' . $ext;

function upload_object($bucketName, $objectName, $source) {
	$storage = new StorageClient();
    //$file = fopen($source, 'r');
    $bucket = $storage->bucket($bucketName);
	$source = file_get_contents($_FILES['fileToUpload']["tmp_name"]);
	// $file = fopen(__DIR__ . $source, 'r');
    $object = $bucket->upload($source, [
        'name' => $objectName]);
}

		// generate a new entity (post)
		upload_object($bucketName, $objectName, $source);
        echo "<script>alert (' Post successfully.'); </script>";
		  $key = $datastore->key('post',$postid);
		  $task = $datastore->entity($key,[
                        'Title' => $title,
						'Description' => $description,
						'Author' =>  $_SESSION["userid"],
						'Country' => $country,
						'Location' => $location,
						'PostID' => $postid,
						'MyPostID' => $mypostid,
						'Type' => $ext,
                        ] );
                        $datastore->insert($task);
                        unset($_POST);
                        $_POST = array();
                        echo "<script> location.replace('https://s3714954cca2.ts.r.appspot.com/main.php') </script>";
	}
}
?>

<center><div style="padding:10%;">
<h1>New post</h1>

<form method="post" action="newpost.php" enctype="multipart/form-data">  
Title&nbsp
<select name="title" id="title" required >
<option disabled selected value> -- Select an option -- </option>
<option value="Animal">Animal</option>
<option value="Building">Building</option>
<option value="Culture">Culture</option>
<option value="Funny">Funny</option>
<option value="Game">Game</option>
<option value="Mystery">Mystery</option>
<option value="Nature">Nature</option>
<option value="Portrait">Portrait</option>
<option value="Sport">Sport</option>
</select> <br> <br>

Description&nbsp
<input type="text" name="description" id="description" maxlength = "60"> <br> <br>

Country&nbsp
<select name="country" id="country">
		<option value="Unknown">Not suitable / Unknown</option>
		<option value="Afghanistan">Afghanistan</option>
		<option value="Argentina">Argentina</option>
¡@		<option value="Australia">Australia</option>
¡@		<option value="Austria">Austria</option>
¡@		<option value="Bangladesh">Bangladesh</option>
¡@		<option value="Belarus">Belarus</option>
		<option value="Brazil">Brazil</option>
		<option value="Canada">Canada</option>
		<option value="China">China</option>
		<option value="Colombia">Colombia</option>
		<option value="Congo">Congo (Congo-Brazzaville)</option>
		<option value="Costa Rica">Costa Rica</option>
		<option value="Croatia">Croatia</option>
		<option value="Cuba">Cuba</option>
		<option value="Czechia">Czechia</option>
		<option value="Denmark">Denmark</option>
		<option value="Egypt">Egypt</option>	
		<option value="Ethiopia">Ethiopia</option>
		<option value="Finland">Finland</option>
		<option value="France">France</option>
		<option value="Germany">Germany</option>
		<option value="Greece">Greece</option>
		<option value="Haiti">Haiti</option>
		<option value="Holy See">Holy See</option>
		<option value="Hong Kong">Hong Kong</option>			
		<option value="Honduras">Honduras</option>
		<option value="Hungary">Hungary</option>
		<option value="Iceland">Iceland</option>
		<option value="India">India</option>
		<option value="Iran">Iran</option>
		<option value="Iraq">Iraq</option>
		<option value="Ireland">Ireland</option>	
		<option value="Israel">Israel</option>
		<option value="Italy">Italy</option>
		<option value="Jamaica">Jamaica</option>
		<option value="Japan">Japan</option>
		<option value="Laos">Laos</option>
		<option value="Latvia">Latvia</option>		
		<option value="Lebanon">Lebanon</option>
		<option value="Lithuania">Lithuania</option>
		<option value="Luxembourg">Luxembourg</option>
		<option value="Madagascar">Madagascar</option>
		<option value="Malaysia">Malaysia</option>
		<option value="Maldives">Maldives</option>	
		<option value="Mexico">Mexico</option>
		<option value="Montenegro">Montenegro</option>
		<option value="Myanmar">Myanmar</option>
		<option value="Nepal">Nepal</option>
		<option value="Netherlands">Netherlands</option>
		<option value="New Zealand">New Zealand</option>
		<option value="Nicaragua">Nicaragua</option>
		<option value="North">North Korea</option>
		<option value="Norway">Norway</option>
		<option value="Pakistan">Pakistan</option>		
		<option value="Panama">Panama</option>
		<option value="Paraguay">Paraguay</option>	
		<option value="Peru">Peru</option>
		<option value="Philippines">Philippines</option>
		<option value="Poland">Poland</option>
		<option value="Portugal">Portugal</option>
		<option value="Romania">Romania</option>
		<option value="Russia">Russia</option>
		<option value="Rwanda">Rwanda</option>
		<option value="Saudi Arabia">Saudi Arabia</option>	
		<option value="Serbia">Serbia</option>
		<option value="Singapore">Singapore</option>
		<option value="Solomon Islands">Solomon Islands</option>
		<option value="Somalia">Somalia</option>
		<option value="South Africa">South Africa</option>
		<option value="South Korea">South Korea</option>
		<option value="Spain">Spain</option>	
		<option value="Sri Lanka">Sri Lanka</option>
		<option value="Sudan">Sudan</option>
		<option value="Sweden">Sweden</option>
		<option value="Switzerland">Switzerland</option>
		<option value="Syria">Syria</option>
		<option value="Tanzania">Tanzania</option>	
		<option value="Thailand">Thailand</option>
		<option value="Turkey">Turkey</option>
		<option value="Uganda">Uganda</option>
		<option value="Ukraine">Ukraine</option>
		<option value="United Arab Emirates">United Arab Emirates</option>
		<option value="United Kingdom">United Kingdom</option>	
		<option value="United States of America">United States of America</option>
		<option value="Uruguay">Uruguay</option>
		<option value="Vanuatu">Vanuatu</option>
		<option value="Venezuela">Venezuela</option>
		<option value="Vietnam">Vietnam</option>
		<option value="Yemen">Yemen</option>
		<option value="Zimbabwe">Zimbabwe</option>
        </select> <br> <br>

Location&nbsp
<input type="text" name="location" id="location" maxlength = "40"> <br> <br>

&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPhoto&nbsp
<input type="file" name="fileToUpload" id="fileToUpload"  accept="image/png, image/jpeg, image/jpg"> <br> <br>

<input type="submit" name="post" value="post"/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" name="goback" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/main.php'">go back</button>
</form>
</div></center>

</body>
</html>