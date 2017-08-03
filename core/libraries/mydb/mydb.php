<?php
require_once 'rows.php';
require_once 'fields.php';
class mydb
{
        var $connect; // Connection link identifier @var resource
        var $connect_param; //Connection  Parameters Object (host=>'', user=>'', pass=>'', name=>'', port=>'', socket=>'')
        var $query_obj = array();
        	
        
	/**
	 * Constructor; sets up variables and connect
	 *
	 * @param string $db_host Server
	 * @param string $db_user User Name
	 * @param string $db_pass Password
	 * @param string $db_name Database Name
	 * @param int $db_port Database Port
	 * @param string $db_socket Database Socket
	 * @return void
	 **/
	 public function __construct($db_host, $db_user, $db_pass, $db_name, $db_port = 3306, $db_socket = "")
         {     
                $this->connect_param = (object) array('host'=>$db_host,'user'=>$db_user,'pass'=>$db_pass,'db'=>$db_name,'port'=>$db_port,'socket'=>$db_socket);  
                $this->connect = new mysqli("$db_host:$db_port". (!$db_socket ? '' : ":$db_socket"), $db_user, $db_pass, $db_name);


                if( $this->connect->connect_error ) 
                    {
                 throw new \Exception('Database connect failed: '  . $this->connect->connect_error);
                    }

                
                /* change character set to utf8 */
                if (!$this->connect->set_charset("utf8"))
                    {
                        throw new \Exception("Error loading character set utf8: ". $this->connect->connect_error ); 
                    }
                }
        
         
        
        /**
	 * Parent (Main) function - Executes a query with security and can change columns name  (butter than query)
	 *
	 * @param string $sql SQL query
         * @param Array Query Parameters $arrParams('SELECT * FROM std WHERE x=?')    ? => Parameter
         * @param Array $arrBindNames Custom Columns Names
	 * @return resource Executed query
	 **/
        
       private function improved_query($sql, $arrParams, $arrBindNames=false) { 
              
                $result = array('query_text'=>$sql,'params'=>$arrParams, 'BindNames'=>$arrBindNames);                 
                $query_result = $this->connect->prepare($result['query_text']); // Prepare Mysql Query through Mysqli
                if ($query_result) { 
                $result = array_merge($result, $this->execute($query_result, $arrParams, $arrBindNames));
                $query_result->free_result(); 
                $query_result->close(); 
                 } 
                else 
                 {
                 $result['error'] = True;
                 $result['errno'] = $this->connect->errno;
                 $result['errde'] = $this->connect->error;
                 throw new \Exception('Mysqli Error No.: '. $this->connect->errno.',   Details:  '. $this->connect->error.',   Query:  '.$result['query_text'] ); 
                 }                          
             
                return $result;
        } 

        
        
         /**
	 * Send Parameters Array to Mysqli Class mysqli_stmt::bind_param
	 *
	 * @param Prepar Mysqli Resault $query_result + $params Parameters array 
	 * @return true because it is to send parameters only
	 **/

        private function bind_param(&$query_result, $params)
        {
            if (count($params) > 1)
                 {
                $params = $this->getRefArray($params); // <-- Added due to changes since PHP 5.3 
                $method = new ReflectionMethod('mysqli_stmt', 'bind_param'); 
                $method->invokeArgs($query_result, $params);    
                 }
             return true;

        }
        
        
         /**
	 * Child (Sub) Function - The Parent (improved_query) - Executes a query with security and can change columns name  (butter than query)
	 *
	 * @param string $sql SQL query
         * @param Array Query Parameters $params ('SELECT * FROM std WHERE x=?')    ? => Parameter
         * @param Array $BindNames Custom Columns Names
	 * @return resource Executed query
	 **/

        private function execute(&$query_result, $params, $BindNames)
        {  
                $result = array();
                $this->bind_param($query_result, $params);
                $query_result->execute(); 
                $meta = $query_result->result_metadata(); //(Insert Or Update Query will return false) (SELECT Query will return Array)
                $result['affected_rows'] = $this->affected_rows($query_result,$meta);
                $result['insert_id'] = $this->insert_id($query_result,$meta);
                $result['fields'] = new mysqli_fields($this->fields($meta,$BindNames));
                $result['rows'] = new mysqli_rows($this->data($query_result, $meta, $result['fields']->all));     
               
                if ($meta)
                {
                $meta->close();  
                }
               
                return $result;
        }


        
       
        
         /**
	 * Fetch Fields data (name , original name, types) 
	 *
	 * @param Prepar Mysqli $meta results , Custom fields names array 
	 * @return fields data object array
	 **/

        private function fields($meta,$BindNames)
        {  
            $fields = array(); 

            if ($meta) { 
            while ($field = $meta->fetch_field()) { 
                    $field->asname = $field->name;
                    $fields[] = (array) $field; 
                } 
                
               $fields =  $this->add_custom_fields_names($fields, $BindNames);
                         
            }
            
            return $fields;
        }
        
        
        
                
         /**
	 * Add custom fields names to fields object array 
	 *
	 * @param Prepar Mysqli $meta results , Custom fields names array 
	 * @return fields data object array
	 **/

        private function add_custom_fields_names($fields, $BindNames)
        {
          if ($BindNames && count($BindNames) == count($fields))
            {
               for ($i=0,$j=count($BindNames); $i<$j; $i++) 
                        { 
                            $fields[$i]['name'] = $BindNames[$i];    
                            $fields[$i]['cname'] = $BindNames[$i]; 
                        } 

            }
            return $fields;
        }

        
        /**
	 * Executes a Standard query
	 *
	 * @param string $query SQL query
	 * @return resource Executed query
	 **/
	private function standard_query($query)
	{    
		$result = array();                
                $result['query_text'] = $query;
                                
		$query_result = $this->connect->query($result['query_text']); 
                
                if (!$query_result)
                {
                 $result['error'] = True;
                 $result['errno'] = $this->connect->errno;
                 $result['errde'] = $this->connect->error;
                throw new \Exception("<b style='color:#FF0000'>A fatal MySQL error occured</b>\n<br /><b style='color:#009000'>Query:</b> " . $result['query_text'] . "<br />\n<b style='color:#009000'>Error:</b> ". $this->connect->connect_error);
                }
                
                return $result;
	}
        
        
        
        
        public function query($sql, $arrParams =array(), $arrBindNames=false)
        {
            $result = array();
            $sql_commands = array("SELECT", "INSERT", "UPDATE", "REPLACE");
            $sql_query_text_1 = substr(trim(strtoupper($sql)), 0, 6);            
            $sql_query_text_2 = substr(trim(strtoupper($sql)), 0, 7);
            $stime = explode(' ', microtime());
            $starttime = $stime[1] + $stime[0];

            if (in_array($sql_query_text_1,$sql_commands) || in_array($sql_query_text_2,$sql_commands)) {

               $result  = $this->improved_query($sql, $arrParams, $arrBindNames);
            }
            else {
               $result  = $this->standard_query($sql);
            }
            
            $etime      = explode(' ', microtime());
            $querytime  = ($etime[1] + $etime[0]) - $starttime;                
            $result['querytime']   = $querytime;    
            
            $this->query_obj[] = (object) $result;
            
            return end ($this->query_obj);
        }

        
         /**
	 * Create Array of rows (Data)
	 *
	 * @param Integer $query_result, $meta, $fields
	 * @return array of Data (Rows)
	 **/
        
        private function data($query_result, $meta, $fields)
	{
           $row = array(); 
           $rows = array(); 

           if ($meta) {                        
               $params = array(); 
               foreach ($fields AS $field) { 
                  $params[] = &$row[$field['name']]; 
               } 
                     
            $method = new ReflectionMethod('mysqli_stmt', 'bind_result'); 
            $method->invokeArgs($query_result, $params); 
            
                     while ($query_result->fetch()) { 
                         $rows[] = $this->row_data($row);
                     } 
           } 
           return $rows;
                 
        }
        
         
        /**
	 * Convert Refrenced Array to Value Array
	 *
	 * @param Array $row  from data() func
	 * @return array of Data (One Row)
	 **/

        private function row_data($row)
        {
            $row_data = array();
            foreach ($row as $key=>$value)
               {
                    $row_data[$key] = $value;
               }  
               
               return $row_data;
        }        
        
        
         /**
	 * Retrieves the insert ID of the last executed query
	 *
	 * @return int Insert ID
	 **/
	private function insert_id($query_result, $meta)
	{
             if (!$meta) {            
                   return $query_result->insert_id; 
             }
             else {return 0; }
	}

        
        
        /**
	 * Gets the number of rows affected by the last executed UPDATE
	 *
	 **/
	private function affected_rows($query_result, $meta)
	{
             if (!$meta) {            
                   return $query_result->affected_rows; 
             }
             else {return 0; }
	}
        

         /**
	 * Create Refrenced Array to solve problem with bind_param in mysqli
	 * Added due to changes since PHP 5.3 
	 * @param Array $a 
	 * @return resource Executed query
	 **/

        private function getRefArray($a) { 
            if (strnatcmp(phpversion(),'5.3')>=0) { 
              $keys = array_keys($a);
              $ret = array(); 
              foreach($keys as $key ) { 
               $ret[$key] = &$a[$key]; 
              } 
              return $ret; 
            } 
            return $a; 
        } 
        
        
}
