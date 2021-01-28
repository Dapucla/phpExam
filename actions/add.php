<?php

if ( ! IS_LOGGED) redirect('/login');

if (IS_POST)
{
	extract($_POST);
	
	check_fields(['field_type', 'field_name', 'opt_name', 'opt_val']);
	
	if (empty($error))
	{
		$poll_id = $db->insert('polls', [
			'name' => $_POST['poll_name']
		]);
		
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
		
		redirect('edit', ['poll_id' => $poll_id, 'alert' => 'Сессия добавлена']);
	}

	$_GET['error'] = $error;
}

$poll_id = 0;
$poll_name = '';

