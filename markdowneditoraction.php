<?php
//markdowneditoraction.php

require "markdown.php";
$db = new MyDB();
$post = new Page($db);

// Add data to database
if(isset($_POST['title']) && isset($_POST['content']))
{
	
	$title = trim($_POST['title']);
	$content = trim($_POST['content']);
	
	if(protect($content) == true) //  || protect($title) == true
	{
		if(isset($_GET['show']) && is_numeric($_GET['show'])){
			$post->update($_GET['show'],htmlentities($title),htmlentities($content));
		}else{
			$post->save(htmlentities($title),htmlentities($content));
		}
		header('Location: editor.php');
		exit;
		
	}else{
		echo "you entered bad content";
	}
}

// activate (or not) the post
if(isset($_GET['publish']) && is_numeric($_GET['publish']))
{	
	if($post->show_publish($_GET['publish']) == "no")
		$post->publish($_GET['publish'],"yes");
	else
		$post->publish($_GET['publish'],"no");
	header('Location: editor.php');
	exit;	
}

// delete post
if(isset($_GET['delete']) && is_numeric($_GET['delete']))
{
	$post->delete($_GET['delete']);
	header('Location: editor.php');
	exit;
}
?>