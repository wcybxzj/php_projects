<?php

function db($start_offset, $increment) {
	for ($i = $start_offset; $i < 300; $i += $increment) {
		$re[]= $i;
	}
}


db();

