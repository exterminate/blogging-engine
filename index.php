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
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>

	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
	<div class='wrapper'>
		<header>
			<h1>My Blog</h1>
		</header>
		<?php
			$posts = new Page($db);
			
			if(isset($_GET['p']))
				$posts->show_one($_GET['p']);
			else
				$posts->show_all();

			$db->close();
		?>
	</div>						
<script src="js/scripts.js"></script>
</body>
</html>