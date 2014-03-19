<!doctype html>
<?php
	require "markdown.php";
	$db = new MyDB();
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

	<form method='POST' action='markdowneditoraction.php<?php if(isset($_GET['show'])) echo "?show=".$_GET['show'];?>'>
		<input type='text' name='title' placeholder='enter title' value='<?php
			if (isset($_GET['show']) && is_numeric($_GET['show']))
			{
				$edit_page = new Page($db);
				echo $edit_page->show_title($_GET['show']);
			}
		?>'>
		<textarea name='content'><?php
			if (isset($_GET['show']) && is_numeric($_GET['show']))
			{
				echo $edit_page->show_content($_GET['show']);
			}
		?></textarea>
		<button>Save</button>
	</form>
<?php
$db->close();
?>
<script src="js/scripts.js"></script>
</body>
</html>