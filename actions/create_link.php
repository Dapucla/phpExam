<?php

if ( ! IS_LOGGED) redirect('/login');

check_fields(['poll_id', 'title']);

$poll_id = (int)get_var('poll_id');
$title   = get_var('title');

$link = md5(microtime(true));

$db->insert('results', [
	'poll_id' => $poll_id,
	'title'   => $title,
	'link'    => $link,
]);

$db->query("UPDATE polls SET status = 1 WHERE id = ".$poll_id." LIMIT 1");

redirect('edit', ['poll_id' => $poll_id, 'alert' => 'Ссылка создана']);
