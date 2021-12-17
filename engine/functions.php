<?php
function generateToken($length = 5)
{
	$arr = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
		'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9',
	);
 
	$res = '';
	for ($i = 0; $i < $length; $i++) {
		$res .= $arr[random_int(0, count($arr) - 1)];
	}
	return $res;
}

?>