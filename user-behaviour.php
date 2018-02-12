<?php
function add_table_to_tables_list($table_name, &$tables_list, $tables_list_size)
{
	$tables_list[$tables_list_size++] = $table_name;
	return($tables_list_size);
}

function add_tables_list_to_user_behaviour($tables_list, $con, $datetime, $user_email)
{
	$tables_list_serialized = serialize($tables_list);

	if($user_email == "" || $user_email == "EXTUSER")
	{
		$user_email = spit_ip();
	}

	mysqli_query($con,"INSERT INTO user_behaviour (user_email, transaction_time, tables_affected) VALUES ('$user_email', '$datetime', '$tables_list_serialized')");
}
?>