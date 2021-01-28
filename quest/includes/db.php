<?php 

class DB 
{
	private $mh = null;
	
	private function connect()
	{
		if ( ! $this->mh = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME))
		{
			trigger_error('ошибка подключения к БД');
			exit;
		}
	}
	
	public function query($sql, $ignore = false)
	{
		if ( ! $this->mh) $this->connect();
		
		if (is_array($sql)) 
		{
			$sql = sprintf(...$sql);
		}
		
		if ( ! $result = mysqli_query($this->mh, $sql))
		{
			if ($ignore) return false;
			trigger_error(sprintf(
				"Query: <b>$sql</b><br>\nError #%d: %s", 
				mysqli_errno($this->mh),
				mysqli_error($this->mh)
			));
			exit;
		}
		
		return $result;
	}
	
	public function insert($table, $values)
	{
		if ( ! $this->mh) $this->connect();		
		
		foreach ($values as &$value) 
		{
			$value = mysqli_real_escape_string($this->mh, $value);
		}
		
		$sql = sprintf(
			"INSERT INTO $table (%s) VALUES('%s')",
			join(", ", array_keys($values)),
			join("', '", $values)
		);
		
		$result = $this->query($sql);
		
		return mysqli_insert_id($this->mh);
	}
	
	public function update($table, $values, $where = [], $limit = 1000000)
	{
		if (empty($where)) 
		{
			$where_str = '1';
		}
		else 
		{
			$where_parts = [];
			foreach ($where as $key => $val)
			{
				$where_parts[] = "$key = '" . mysqli_real_escape_string($this->mh, $val) . "'";
			}
			$where_str = join(', ', $where_parts);
		}
		
		$set_parts = [];
		foreach ($values as $key => $val)
		{
			$set_parts[] = "$key = '" . mysqli_real_escape_string($this->mh, $val) . "'";
		}
		$set = join(', ', $set_parts);		
			
		$sql = sprintf("UPDATE $table SET %s WHERE %s LIMIT %d", $set, $where_str, $limit);		
		
		$result = $this->query($sql);
		
		return mysqli_affected_rows($this->mh);
	}
	
	public function get_row(...$sql)
	{
		$result = $this->query($sql);
		return mysqli_num_rows($result) ? mysqli_fetch_object($result) : false;
	}
	
	public function get_rows(...$sql)
	{
		$result = $this->query($sql);
		
		$rows = [];
		while ($row = mysqli_fetch_object($result))
		{
			$rows[] = $row;
		}
		
		return $rows;
	}	
}
