<?php
class Text
{
	function __construct($text)
	{
		$this->text = $text;
	}
	
	function output()
	{
		return $this->text;
	}
	
}	


$string = "
# This is my heading
## and this is a subheading
this is a paragraph.
followed by another.
";


$input = new Text($string); 

echo $input->output; 
?>