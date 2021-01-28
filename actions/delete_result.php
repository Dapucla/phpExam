<?php

$poll_id = get_var('poll_id');

if ( ! $poll = $db->get_row("SELECT * FROM polls WHERE id = %d LIMIT 1", $poll_id))
{
	error(404);
}

if ( ! $quastions =  $db->get_rows("SELECT * FROM quastions WHERE poll_id = %d ORDER BY id", $poll->id))
{
	error(500);
}

if ( ! $result = $db->get_row("SELECT * FROM results WHERE poll_id = '%s' AND results != '' ", $poll->id))
{
	error(404);
}

foreach ($quastions as $quation)
{
	$quation->options = unserialize($quation->options);
}

$result->results = unserialize($result->results);
