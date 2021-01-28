<?php

if ( ! IS_LOGGED) redirect('/login');

$poll_id = (int)get_var('poll_id');

$db->query("DELETE FROM quastions WHERE poll_id = $poll_id");
$db->query("DELETE FROM polls WHERE id = $poll_id");
$db->query("DELETE FROM results WHERE poll_id = $poll_id");

redirect('main', ['alert' => 'сессия удалена']);