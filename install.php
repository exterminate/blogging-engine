<?php
	// First time install page 
	
	require "markdown.php";
	
	if(!file_exists("post2Database.db"))
	{
		// Create tables
		$db = new MyDB();
		$db->exec('CREATE TABLE if not exists post 
			(id INTEGER PRIMARY KEY AUTOINCREMENT,
			time TEXT NOT NULL,
			publish TEXT NOT NULL,
			tags TEXT,
			title TEXT NOT NULL,
			content TEXT NOT NULL)');
		$db->exec('CREATE TABLE if not exists user 
			(userID INTEGER PRIMARY KEY AUTOINCREMENT,
			name TEXT NOT NULL,
			email TEXT NOT NULL,
			password TEXT NOT NULL,
			lastlogin TEXT NOT NULL,
			logins TEXT NOT NULL)');

		// Add first example post
		$rowsSetup = $db->query('SELECT COUNT(*) as count FROM post');
		while($rowSetup = $rowsSetup->fetchArray())
		{
			if($rowSetup['count'] == 0)
			{
				$db->exec('INSERT INTO post (time, publish, tags, title, content) VALUES
				("$time", "no", "editorial", "My First Post", "This is a the content in my first post")');
			}
		}
	}	
			
	// Register user
	if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pass1']) && isset($_POST['pass2'])) 
	{	
		$db = new MyDB();
		$username = protect($_POST['username']);
		$email = protect($_POST['email']);
		
		// Check passwords match
		if (md5($_POST['pass1']) == md5($_POST['pass2']))
		{	
			$pass1 = md5($_POST['pass1']);
			$user = new User($db, $username, $email, $pass1);
			$user->add_user_to_database();

			// Thanks message
			echo "Great, all sorted, let's login to the <a href='editor.php'>editor</a>";
			die();
		}
		else
			die("I'm afraid your passwords, don't match. Try again.");
	}	

	/* 
	Finish
	if user > 0 then die

*/





?>

<form action='install.php' method='POST'>
	<label>Name::</label><br>
	<input type='text' name='username'><br>
	<label>E-mail::</label><br>
	<input type='email' name='email'><br>
	<label>Password::</label><br>
	<input type='password' name='pass1'><br>
	<label>Repeat password::</label><br>
	<input type='password' name='pass2'><br>
	<button>Let's go!</button>
</form>