<?php
date_default_timezone_set('America/Lima');

class Db {
	private $link;
	private $stmt;
	private $array;

	var $host = '';
    var $username = '';
    var $passwd = '';
    var $dbName = '';


	public function Db($params_cn=false)
	{
		if ($params_cn !== false) {
			$host = $params_cn['host'];
			$user = $params_cn['user'];
			$password = $params_cn['password'];
			$db = $params_cn['db'];
		}
		else {
			if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1')){
				$host = '127.0.0.1';
				$user = 'Admin';
				$password = '123456';
				$db = 'codigofit';
			}
			else {
				$host = 'localhost';
				$user = 'codigofi_root';
				$password = '9U&DT^VD#NbX';
				$db = 'codigofi_BD';
			}
		}

		$this->host     = $host;
        $this->username = $user;
        $this->passwd   = $password;
        $this->dbName   = $db;
	}

	private function conectar()
	{
		$_host = $this->host;
        $_user = $this->username;
        $_password = $this->passwd;
        $_db = $this->dbName;

		$this->link = mysqli_connect($_host, $_user, $_password, $_db);
		@mysqli_query($this->link, "SET NAMES 'utf8'");
	}

	private function desconectar()
	{
		mysqli_close($this->link);
	}

	private function obtener_filas($stmt)
	{
		$fetchrow = array();

		while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
			$fetchrow[] = $row;

		$this->array = $fetchrow;
		return $this->array;
	}

	private function lastID()
	{
		return mysqli_insert_id($this->link);
	}

	public function ejecutar($sql)
	{
		$this->conectar();

		$this->stmt=mysqli_query($this->link, $sql);

		/*echo $sql;
		*/
		echo mysqli_error($this->link);
		return $this->stmt;
	}

	public function exec_sp_select($sp_name, $sp_params)
	{
		$strsql = 'CALL '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';	
		
		$strsql .= ')';

		$this->conectar();
		
		$rs_output = mysqli_query($this->link, $strsql);
		echo mysqli_error($this->link);
		$result = $this->obtener_filas($rs_output);
		$this->stmt = $rs_output;
		mysqli_free_result($rs_output);

		//echo $strsql;
		$this->desconectar();

		return $result;
	}

	public function exec_sp_iud($sp_name, $sp_params, $sp_output = '')
	{
		$strsql = 'CALL '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
		else
			$strsql .= '\'' .$sp_params . '\'';

		if ($sp_output != '')
			$strsql .= ', '.$sp_output;

		$strsql .= ')';

		$this->conectar();
		
		if ($sp_output != ''){
			$rsproc = mysqli_multi_query($this->link, $strsql.'; SELECT '.$sp_output.';');
			echo mysqli_error($this->link);
			mysqli_next_result($this->link);
			$rs_output = mysqli_store_result($this->link);
			$result = $this->obtener_filas($rs_output);
			
			$this->stmt = $rs_output;
			mysqli_free_result($rs_output);
		}
		else {
			$this->stmt = mysqli_query($this->link, $strsql);
			echo mysqli_error($this->link);
			$result = array(array('rpta' => 1));
		}
		
		/*echo $strsql;
		*/
		$this->desconectar();

		return $result;
	}

	public function multiQuery($sql)
	{
		$this->conectar();

		$this->stmt=mysqli_multi_query($this->link, $sql);

		/*echo $sql;
		echo mysqli_error($this->link);*/
		$this->desconectar();
		return $this->stmt;
	}
	
	public function show_tables($param='')
	{
		$strsql = ' SHOW TABLES ';

		$this->conectar();

		$rs = $this->ejecutar($strsql);

		$resultado = $this->obtener_filas($rs);

		//echo $strsql;
		echo mysqli_error($this->link);
		$this->desconectar();
		return $resultado;
	}

	public function set_select($fields, $table, $where = false, $orderby = false, $groupby = false, $limit = false)
	{
		$this->conectar();

		if (is_array($fields))
			$fields = '' . implode($fields, ', ') . '';

		$groupby = ($groupby) ? ' GROUP BY ' . $groupby : '';
		$orderby = ($orderby) ? ' ORDER BY ' . $orderby : '';
		$limit = ($limit) ? ' LIMIT ' . $limit : '';
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'SELECT ' . $fields . ' FROM ' . $table . '' . $where . $groupby . $orderby . $limit;
		
		$rs = $this->ejecutar($strsql);
		$resultado = $this->obtener_filas($rs);

		/*echo $strsql;
		*/
		echo mysqli_error($this->link);
		$this->desconectar();
		return $resultado;
	}

	public function set_insert(array $values, $table)
	{
		$result = 0;

		if (count($values) < 0)
			return false;

		foreach($values as $field => $val){
			$val = '\''.$val.'\'';
			$values[$field] = $val; 
		}

		$strsql = 'INSERT INTO '.$table.' ('.implode(array_keys($values), ', ').') VALUES ('.implode($values, ', ').')';
		$rs = $this->ejecutar($strsql);

		/*echo $strsql;
		*/
		echo mysqli_error($this->link);

		if ($rs)
			$result = $this->lastID();
		else
			$result = 0;

		$this->desconectar();
		return $result;
	}

	public function set_update($values, $table, $where = false)
	{
		$result = 0;

		if (is_array($values)) {
			if (count($values) < 0)
				return false;

			$fields = array();

			foreach($values as $field => $val){
				$val = '\''.$val.'\'';
				$fields[] = $field.' = '.$val;
			}
			$strsql = 'UPDATE '.$table.' SET '.implode($fields, ', ');
		}
		else
			$strsql = 'UPDATE '.$table.' SET '.$values;

		$where = ($where) ? ' WHERE '.$where : '';
		$strsql = $strsql.$where;
		
		$rs = $this->ejecutar($strsql);

		/*echo $strsql;
		*/
		echo mysqli_error($this->link);

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		$this->desconectar();
		return $result;
	}

	public function set_delete($table, $where = false)
	{
		$result = 0;
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'DELETE FROM '.$table.$where;

		$rs = $this->ejecutar($strsql);

		//echo $strsql;
		echo mysqli_error($this->link);

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		$this->desconectar();
		return $result;
	}

	public function backupTables($tables, $outputDir)
    {
    	$this->conectar();

        try {
            /**
            * Tables to export
            */
            $_dbName = $this->dbName;

            if($tables == '*'){
                $tables = array();
                $result = mysqli_query($this->link, 'SHOW TABLES');
                while($row = mysqli_fetch_row($result))
                    $tables[] = $row[0];
            }
            else
                $tables = is_array($tables) ? $tables : explode(',', $tables);
 
            $sql = 'CREATE DATABASE IF NOT EXISTS '.$_dbName.";\n\n";
            $sql .= 'USE '.$_dbName.";\n\n";
 
            /**
            * Iterate tables
            */
            foreach($tables as $table){
                $result = mysqli_query($this->link, 'SELECT * FROM '.$table);
                $numFields = mysqli_num_fields($result);
 
                $sql .= 'DROP TABLE IF EXISTS '.$table.';';
                $row2 = mysqli_fetch_row(mysql_query('SHOW CREATE TABLE '.$table,$this->link));
                $sql.= "\n\n".$row2[1].";\n\n";
 
                for ($i = 0; $i < $numFields; $i++){
                    while($row = mysqli_fetch_row($result)){
                        $sql .= 'INSERT INTO '.$table.' VALUES(';
                        for($j=0; $j<$numFields; $j++){
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n","\\n",$row[$j]);
                            
                            if (isset($row[$j]))
                                $sql .= '"'.$row[$j].'"' ;
                            else
                                $sql.= '""';
 
                            if ($j < ($numFields-1))
                                $sql .= ',';
                        }
                        $sql.= ");\n";
                    }
                }
 
                $sql.="\n\n\n";
            }
            //echo $sql;
			//echo mysqli_error($this->link);
        }
        catch (Exception $e){
            var_dump($e->getMessage());
            return false;
        }
        return $this->saveFile($sql, $outputDir);
    }
 
 	public function backupToExcel($table, $outputDir)
    {
    	$this->conectar();

    	$query = 'SELECT * FROM '.$table;

		// Execute the database query
		$result = mysqli_query($this->link, $query) or die(mysqli_error());

		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$rowCount = 1; 

		//start of printing column names as names of MySQL fields  
		$column = 'A';
		for ($i = 1; $i < mysqli_num_fields($result); $i++)  {
		    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
		    $column++;
		}
		//end of adding column names  

		//start while loop to get data  
		$rowCount = 2;
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		while($row = mysqli_fetch_row($result)) {  
		    $column = 'A';
		    for($j=1; $j<mysqli_num_fields($result);$j++) {  
		        if(!isset($row[$j]))  
		            $value = NULL;  
		        elseif ($row[$j] != '')  
		            $value = strip_tags($row[$j]);  
		        else  
		            $value = '';  

		        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
		        $column++;
		    }  
		    $rowCount++;
		}
		
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		$objWriter->save($outputDir);

		$this->desconectar();
    }
    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql, $outputDir = '.')
    {
        if (!$sql) return false;
 
        try {
            $handle = fopen($outputDir,'w+');
            fwrite($handle, $sql);
            fclose($handle);
        }
        catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
        return true;
    }
}
?>