<!doctype html>
<?php

require "markdown.php";
$db = new MyDB();

if(isset($_GET['publish']))
{

}

?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Editor</title>
  <meta name="description" content="Editor">
  <meta name="author" content="Exterminate.me">

  <link rel="stylesheet" href="css/style.css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>

	<h2>Post list</h2>
	<div><a href='markdowneditor.php'>New post</a></div>
	<ul class='post-list'>
		<?php
			$posts = new Page($db);
			$posts->show_page_list();
		?>
	</ul>

<?php $db->close(); ?>
			
<script>

var element = document.getElementsByClassName('delete_link');
var confirmIt = function (e) {
	if (!confirm('Are you sure you want to delete this?')) e.preventDefault();
};
for (var i = 0, l = element.length; i < l; i++) {
	element[i].addEventListener('click', confirmIt, false);
}

</script>
</body>
</html>