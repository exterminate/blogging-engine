<!doctype html>
<?php
	require "markdown.php";
	$db = new MyDB();
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>????</title>
  <meta name="description" content="???">
  <meta name="author" content="Exterminate.me">

  <link rel="stylesheet" href="css/main.css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>

<?php
	$posts = new Page($db);
	echo $posts->show_all();
?>
			
<script src="js/scripts.js"></script>
</body>
</html>