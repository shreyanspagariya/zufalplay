<?php
function convert_youtube_datetime($youtube_datetime)
{
	$zufalplay_datetime = "";
	for($i=0; $i<19; $i++)
	{
		if($youtube_datetime[$i] == 'T')
		{
			$zufalplay_datetime.=" ";
		}
		else
		{
			$zufalplay_datetime.=$youtube_datetime[$i];
		}
	}
	return($zufalplay_datetime);
}

?>