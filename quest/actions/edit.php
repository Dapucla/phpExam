<?php

if ( ! IS_LOGGED) redirect('/login');

$poll_id = (int)get_var('poll_id');

if (IS_POST)
{
	extract($_POST);
	
	check_fields(['field_type', 'field_name', 'opt_name', 'opt_val']);
	
	if (empty($error))
	{
		if ( ! $poll = $db->get_row("SELECT * FROM polls WHERE status = 0 AND id = %d LIMIT 1", $poll_id))
		{
			error(404);
		}		
		
		$db->update(
			'polls',
			['name' => $_POST['poll_name']], 
			['id' => $poll_id]
		);
		
		$db->query("DELETE FROM quastions WHERE poll_id = $poll_id");
		
		foreach ($field_type as $key => $type)
		{
			$options = [];
			foreach ($opt_name[$key] as $o_key => $o_val)
			{
				$options[$o_val] = $opt_val[$key][$o_key];
			}

			$db->insert('quastions', [
				'poll_id' => $poll_id,
				'type'    => $type,
				'name'    => $field_name[$key],
				'options' => serialize($options),
			]);
		}
		
		redirect('edit', ['poll_id' => $poll_id, 'alert' => 'Сессия обновлена']);
	}

	$_GET['error'] = $error;
}

if ( ! $poll = $db->get_row("SELECT * FROM polls WHERE id = %d LIMIT 1", $poll_id))
{
	error(404);
}

if ( ! $quastions =  $db->get_rows("SELECT * FROM quastions WHERE poll_id = %d ORDER BY id", $poll_id))
{
	error(500);
}

foreach ($quastions as $quation)
{
	$quation->options = unserialize($quation->options);
}

$poll_id     = $poll->id;
$poll_name   = $poll->name;
$poll_status = $poll->status;

$results = $db->get_rows("SELECT * FROM results WHERE poll_id = %d ORDER BY id DESC", $poll_id);


