<?php
function getAPIKey($vendeur)
{
	if(in_array($vendeur, array('MIM_F', 'TEST'))) {
		return substr(md5($vendeur), 1, 15);
	}
	return "zzzz";
}
?>
