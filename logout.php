<?php
session_start();
unset($_SESSION["userid"]);
	 echo "<script>alert ('Logout successfully. Redirect to login page.'); </script>";
	 echo "<script>window.location.href='https://s3714954cca2.ts.r.appspot.com/login.php'; </script>";
?>