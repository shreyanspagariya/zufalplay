<?php
function convert_time($str) 
{
    $n = strlen($str);
    $ans = 0;
    $curr = 0;
    for($i=0; $i<$n; $i++)
    {
        if($str[$i] == 'P' || $str[$i] == 'T')
        {

        }
        else if($str[$i] == 'H')
        {
            $ans = $ans + 3600*$curr;
            $curr = 0;
        }
        else if($str[$i] == 'M')
        {
            $ans = $ans + 60*$curr;
            $curr = 0;
        }
        else if($str[$i] == 'S')
        {
            $ans = $ans + $curr;
            $curr = 0;
        }
        else
        {
            $curr = 10*$curr + $str[$i];
        }
    }
    return($ans);
}
?>