<?php

$string = "
= this is a h1
== this h2
=== this h3
img http://placekitten.com/1000/400
this is a http://www.google.com|google paragraph
and another http://www.google.com paragraph
>>> this is a quote
* list 1
* list 2
* list 3
# list 1
# list 2
# list 3
";



function convert($string)
{
	$new_line = array();
	$lines = explode("\n",$string);
	foreach($lines as $line)
	{
		$line_bits = explode(" ",$line);
		switch($line_bits[0])
		{
			case "=":
				$new_line[] = "<h1>".implode(" ", array_slice($line_bits, 1))."</h1>\n";
				break;
			case "==":
				$new_line[] = "<h2>".implode(" ", array_slice($line_bits, 1))."</h2>\n";
				break;	
			case "===":
				$new_line[] = "<h3>".implode(" ", array_slice($line_bits, 1))."</h3>\n";
				break;	
			case ">>>":
				$new_line[] = "<q>".implode(" ", array_slice($line_bits, 1))."</q>\n";
				break;	
			case "*":
				$new_line[] = "<ul><li>".implode(" ", array_slice($line_bits, 1))."</li></ul>";
				break;	
			case "#":
				$new_line[] = "<ol><li>".implode(" ", array_slice($line_bits, 1))."</li></ol>";
				break;		
			case "img":
				$new_line[] = "<img width='100%' src='".implode(" ", array_slice($line_bits, 1))."'>";
				break;
			case "img50":
				$new_line[] = "<img width='50%' src='".implode(" ", array_slice($line_bits, 1))."'>";
				break;
			default:	
				$new_line[] = "<p>".implode(" ", array_slice($line_bits, 1))."</p>\n";
				break;	
		}
	}
	
	$string = implode("",$new_line);
	
	$bits = explode(" ",$string);
	
	foreach($bits as $key => $bit)
	{
		if(substr($bit,0,4) == "http")
		{	
			$link_bit = explode("|",$bit);
			if(!empty($link_bit[1]))
			
			{
				$bits[$key] = "<a href='".$link_bit[0]."'>".$link_bit[1]."</a>"; 
			}else{
				$bits[$key] = "<a href='".$bit."'>".$bit."</a>"; 
			}	
		}			
	}
	$string = implode(" ",$bits);
	$before = array("</ul><ul>","</ol><ol>","</ul>","</ol>","<ul>","<ol>");
	$after = array("\n","\n","\n</ul>\n","\n</ol>\n","<ul>\n","<ol>\n");
	$string = str_replace($before, $after, $string);
	return $string;
}



function protect($string)
{
	if(strpos($string,"<?") == false)
	{
		return true;
	}else{
		return false;
	}
	
}

class MyDB extends SQLite3 
{
	function __construct() {
		$this->open('post2Database.db');
	}
}



class Page
{
	function __construct($db)
	{
		$this->db = $db;
	}
		
	function show_page_list()
	{	
		$list = $this->db->query("SELECT * FROM post");
		while ($row = $list->fetchArray())
		{
			if ($row['publish'] == "yes") { $ifpublish = "Unpublish"; }else{ $ifpublish = "Publish"; } 
			echo "<li><a href='markdowneditor.php?show=".$row['id']."'>".$row['title']."</a> :: <a href='markdowneditoraction.php?publish=".$row['id']."'>[".$ifpublish."]</a> :: <a href='markdowneditoraction.php?delete=".$row['id']."' class='delete_link'>[Delete]</a></li>";
		}
	}
	
	function show_publish($id) 
	{
		$publish = $this->db->query("SELECT publish FROM post WHERE id='$id'");
		while ($row = $publish->fetchArray())
		{
			return $row['publish'];
		}
	}
	
	function publish($id,$decision) 
	{
		$publish = $this->db->query("SELECT publish FROM post WHERE id='$id'");
		while ($row = $publish->fetchArray())
		{
			$this->db->exec("UPDATE post SET publish = '$decision' WHERE id='$id'");
		}
	}
	
	function show_title($id) 
	{
		$title = $this->db->query("SELECT title FROM post WHERE id='$id'");
		while ($row = $title->fetchArray())
		{
			return $row['title'];
		}
	}
	
	function show_content($id)
	{
		$content = $this->db->query("SELECT content FROM post WHERE id='$id'");
		while ($row = $content->fetchArray())
		{
			return $row['content'];
		}	
	}
	
	function update($id,$title,$content)
	{
		$time = strtotime("now");
		$this->db->exec("UPDATE post SET title = '$title', content = '$content', time = '$time' WHERE id='$id'");
		//$this->db->close();
		//unset($this->db);
		//$this->db->busyTimeout(5000);
	}
	
	function save($title,$content)
	{
		$time = strtotime("now");
		$this->db->exec("INSERT INTO post (title,content,time,publish) VALUES('$title','$content','$time','no')");
	}
	
	function delete($id)
	{
		$this->db->exec("DELETE FROM post WHERE id='$id'");
	}
	
	function show_all()
	{
		$all = $this->db->query("SELECT * FROM post WHERE publish = 'yes'");
		while ($row = $all->fetchArray())
		{
			echo "<article><h1 class='title'><a href='?p=".$row['id']."'>".$row['title']."</a></h1>".convert($row['content'])."<p class='date'>".date("Y-m-d H:i", $row['time'])."</p></article>";
		}	
	}
	
	function show_one($p)
		{
			$all = $this->db->query("SELECT * FROM post WHERE publish = 'yes' AND id='$p'");
			while ($row = $all->fetchArray())
			{
				echo "<article><h1 class='title'>".$row['title']."</h1>".convert($row['content'])."<p class='date'>".date("Y-m-d H:i", $row['time'])."</p></article>";
			}	
		}
  
}

class User
{
	function __construct($db, $user, $email, $pass)
	{
		$this->db    = $db;
		$this->user  = $user;
		$this->email = $email;
		$this->pass  = $pass;
	}

	function add_user_to_database()
	{
		$time = strtotime("now");
		$this->db->exec("INSERT INTO user (name,email,password,lastlogin,logins) VALUES('$this->user','$this->email','$this->pass','$time','1')");
	}
	
}
?>