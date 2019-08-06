<?php
class Database
{
/*private $db_host = 'localhost';
private $db_user = 'edunaukr_vivtech';
private $db_pass = 'bhubaneswar17';
private $db_name = 'edunaukr_vivtech'; */
private $db_host = '166.62.8.83';
private $db_user = 'indusedu';//edunaukr_exams
private $db_pass = 'Indus#@!123';//satyaa
private $db_name = 'indusedu'; 
private $con = false;    
public function connect()
    {
        if(!$this->con)
        {
       
 $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            
            if($myconn)
            {
                $seldb = @mysql_select_db($this->db_name,$myconn);
                if($seldb)
                {

                    $this->con = true;
                    return true;
                } else
                {
                    return false;
                }
            } else
            { 
                return false;
            }
        } else
        {
            return true;
        }
    }
    
    
    public function disconnect()
{
	if($this->con)
	{
		if(@mysql_close())
		{
                       $this->con = false;
			return true;
		}
		else
		{
			return false;
		}
	}
}

private $result = array();
private function tableExists($table)
    {

        $tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb)
        {
            if(mysql_num_rows($tablesInDb)==1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }


public function select($table, $rows , $where , $order, $page)
    {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
     $q .= ' ORDER BY '.$order;
     if($page != null)
    $q .= ' LIMIT 0, '.$page;
        $query = @mysql_query($q);
        if($query)
        {
            $this->numResults = mysql_num_rows($query);
            for($i = 0; $i < $this->numResults; $i++)
            {
                $r = mysql_fetch_array($query);
				//print_r($r);
			    $key = array_keys($r);
                for($x = 0; $x < count($key); $x++)
                {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x]))
                    {
                        if(mysql_num_rows($query) > 1)
                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        else if(mysql_num_rows($query) < 1)
                            $this->result = null;
                        else
                            $this->result[$key[$x]] = $r[$key[$x]];
                    }
                }
            }
            return true;
        }
        else
        {
            return false;
        }
        
}
    
    function get_name()
    	 { 
return $this->result;
 } 
 
 
 public function update($table,$rows,$where)
    {
        if($this->tableExists($table))
        {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for($i = 0; $i < count($where); $i++)
            {
                if($i%2 != 0)
                {
                    if(is_string($where[$i]))
                    {
                        if(($i+1) != null)
                           // $where[$i] = '"'.$where[$i].'" AND ';
                      
                            $where[$i] = '"'.$where[$i].'"';
                    }
                }
            }
            $where = implode('=',$where);

            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++)
           {
                if(is_string($rows[$keys[$i]]))
                {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }

                // Parse to add commas
                if($i != count($rows)-1)
                {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            $query = @mysql_query($update);
            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
     public function insert($table,$values,$rows = null)
    {
        if($this->tableExists($table))
        {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
            {
   $insert .= ' ('.$rows.')';
            }

            for($i = 0; $i < count($values); $i++)
            {
                          
                if(is_string($values[$i]))  
                    $values[$i] = '"'.$values[$i].'"';  

            }
           $values = implode(',',$values);  
          $insert .= ' VALUES ('.$values.')';
            $ins = @mysql_query($insert);
            if($ins)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    public function delete($table,$where = null)
    {
        if($this->tableExists($table))
        {
            if($where == null)
            {
                $delete = 'DELETE '.$table;
            }
            else
            {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            $del = @mysql_query($delete);

            if($del)
            {
                return true;
            }
            else
            {
               return false;
            }
        }
        else
        {
            return false;
        }
    }
 }
 class ArrayToXML
{
	/**
	 * The main function for converting to an XML document.
	 * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
	 *
	 * @param array $data
	 * @param string $rootNodeName - what you want the root node to be - defaultsto data.
	 * @param SimpleXMLElement $xml - should only be used recursively
	 * @return string XML
	 */
	public static function toXml($data, $rootNodeName = 'data', $xml=null)
	{
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}
		
		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='ISO-8859-1'?>
<$rootNodeName /> ");
		}
		
		// loop through the data passed in.
		foreach($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if (is_numeric($key))
			{
				// make string key...
				$key = "idyllic_". (string) $key;
			}
			
			// replace anything not alpha numeric
			$key = preg_replace('/[^a-z]/i', '', $key);
			
			// if there is another array found recrusively call this function
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				// recrusive call.
				ArrayToXML::toXml($value, $rootNodeName, $node);
			}
			else 
			{
				// add single node.
                                $value = htmlentities($value);
				$xml->addChild($key,$value);
			}
			
		}
		// pass back as string. or simple xml object if you want!
		return $xml->asXML();
	}


    

  } 
?>
