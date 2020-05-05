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

<br>
<button type="button" name="goback" onclick="window.location.href='https://s3714954cca2.ts.r.appspot.com/main.php'">Go back to main page</button>
</body>

</html>