<?php include ("../inc/connect.inc.php"); ?>

<?php

$tag_entered = mysqli_real_escape_string($con,$_POST['tag_entered']);
$tag_box_number = mysqli_real_escape_string($con,$_POST['tag_box_number']);

$count = 0;

$sendback_string = "<span class='dropdown' id='dropdownsearch$tag_box_number'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' style='display:none;'>Dropdown Example
<span class='caret'></span></button><ul class='dropdown-menu'>";

$getposts = mysqli_query($con,"SELECT * FROM blogpost_tags");
while($row = mysqli_fetch_assoc($getposts))
{
	$tag_name = $row["tag_name"];
	$tag_name_lower = strtolower($tag_name);
	$tag_entered_lower = strtolower($tag_entered);

	if(strpos($tag_name_lower,$tag_entered_lower)!==false)
	{
		$count++;
		$sendback_string = $sendback_string."<li><a onclick='fill_tag($tag_box_number,&#39;$tag_name&#39;)'>$tag_name</a></li>";
	}
}

if($count == 0)
{
	$sendback_string = $sendback_string."<li>&nbsp;No Tags Found</li>";
}

$sendback_string.="</ul></span>";

$result = array('status' => 1, 'msg' => $sendback_string);
echo json_encode($result);

?>