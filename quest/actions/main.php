<?php 

if ( ! IS_LOGGED) redirect('login');

$polls = $db->get_rows("SELECT * FROM polls ORDER BY id DESC");

foreach ($polls as $poll)
{
	$poll->quastions = $db->get_rows("SELECT * FROM quastions WHERE poll_id = %d", $poll->id);
	$poll->results   = $db->get_rows("SELECT * FROM results WHERE poll_id = %d", $poll->id);
	
	foreach ($poll->quastions as $quation)
	{
		$quation->options = unserialize($quation->options);
	}	
}

