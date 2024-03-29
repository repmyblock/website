<?php
// MYSQL Classes
class db {

  var $connect_id;
  var $type;
  var $pdo;
  
  function db($database_type="mysql") {
    $this->type = $database_type;
  }

   function open($database, $host, $port, $user, $password, $sslkeys, $DebugInfo) {

    if(empty($user)) {
      // $this->connect_id = mysql_connect(); - Deprecated
			echo "Database not available ... reporting why.";
			// Put a nagios trigger here
			exit();
    } else {
	    // $this->connect_id = mysql_connect($host, $user, $password); - Deprecated
	    try {     	
		   	if (! empty ($sslkeys["srvkey"])) {
		   		$MYSQLOPTIONS = array(
		   			PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
		  			PDO::MYSQL_ATTR_SSL_KEY   => $sslkeys["srvkey"],
		  			PDO::MYSQL_ATTR_SSL_CERT	=> $sslkeys["srvcert"],
		  			PDO::MYSQL_ATTR_SSL_CA    => $sslkeys["srvca"]
			  	);
			  }       		
		   	$this->pdo = new PDO($this->type . ":host=$host;port=$port;dbname=$database", $user, $password, $MYSQLOPTIONS);
				  
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $this->pdo;
	    	
			}	catch( PDOException $e ) {
				$this->SaveError ($e->getMessage(), $sql, $sql_vars, $DebugInfo);
	   		if ( $DebugInfo["Flag"] > 0 ) {
					echo "Failed to get DB handle: " . $e->getMessage() . "\n";
				} else { 
					echo "Error with the Database. Admin already notified. Please try in one hour.<BR>";
				}
	   		exit;
			}
		}
  }
 
  function query($sql = "", $sql_vars = "", $return = 0, $DebugInfo = "") { 		
 		unset ($event_rows);
 		if ( $DebugInfo["Flag"] > 0 ) {
  		echo "<FONT COLOR=BROWN><I><B>SQL:</B> $sql</I></FONT><BR>";
  		echo "<FONT COLOR=BLUE><PRE>";
  		print_r($sql_vars);
  		echo "</PRE></FONT>";
  	}
   
    if(! empty($sql) && ! empty($this->pdo)) {
        	
      $sql_query = $this->pdo->prepare($sql);  
      
      try {
	      if ( ! empty ($sql_vars)) {         
	      	$result = $sql_query->execute($sql_vars);
	      } else {
	      	$result = $sql_query->execute();
	      }
	    }	catch( PDOException $e ) {
				$this->SaveError ($e->getMessage(), $sql, $sql_vars, $DebugInfo);
	    	if ( $DebugInfo["Flag"] > 0 ) {
					echo "Failed to get DB handle: " . $e->getMessage() . "\n";
				} else { 
					$this->SaveError ($e->getMessage(), $sql, $sql_vars, $DebugInfo);
					echo "Error with the Database. Admin already notified. Please try in one hour.<BR>";
				}
				// Put a nagios trigger here
	    	exit;
			}      

			if ( $return == 1 ) {

	     	$i = 0;
	   	 	try {
	    		while ($event_rows[$i] = $sql_query->fetch(PDO::FETCH_NAMED)) {
	    			$i++;
	    		}
	     	} catch( PDOException $e ) {
					$this->SaveError ($e->getMessage(), $sql, $sql_vars, $DebugInfo);
		    	if ( $DebugInfo["Flag"] > 0 ) {
						echo "Failed to get DB handle: " . $e->getMessage() . "\n";
					} else { 
						echo "Error with the Database. Admin already notified. Please try in one hour.<BR>";
					}
					// Put a nagios trigger here
		    	exit;
				}           	
     	
      	unset ($sql_query);
      	unset ($sql);
      	unset ($sql_vars);
      
	    	return $event_rows;	  	
    	}
    	
  		unset ($sql_query);
    	unset ($sql);
    	unset ($sql_vars);
    
    	return;	  	
    	
    }
 	}
 	
 	function SaveError ($Error, $sql, $sql_vars, $DebugInfo) {
 		
 		if ( ! empty ($DebugInfo["DBErrorsFilename"])) {
 		
			// SAVING THE INFORMATION - Exit Out if you can't
			$TransData = 	"0:" . microtime() . " " . $_SERVER["REMOTE_ADDR"] . " DebFlag: " . 
													$DebugInfo["Flag"] . ": DBFile: " . $DebugInfo["DBFile"] . "\n" . 
										"1:" . microtime() . 
										" " . $_SERVER["REMOTE_ADDR"] . " DebFlag: " . 
													$DebugInfo["Flag"] . ": " . $Error . "\n" . 
										"2:" . microtime() . 
										" " . $_SERVER["REMOTE_ADDR"] . " DebFlag: " . 
													$DebugInfo["Flag"] . ": " . preg_replace("/\n+/","", print_r($sql_vars, 1)) . "\n" . 
										"3:" . microtime() . 
										" " . $_SERVER["REMOTE_ADDR"] . " DebFlag: " . 
													$DebugInfo["Flag"] . ": " . $sql . "\n";
										
			if ( ! @file_put_contents ( $DebugInfo["DBErrorsFilename"] , $TransData ,  FILE_APPEND | LOCK_EX )) {
				echo "There was a problem with saving file and the transaction did not go trough<BR>";
				echo "Transaction: " . $DebugInfo["DBErrorsFilename"] . "<BR>";
				exit();
			}
		}
		echo "Error with the Database. Admin already notified. Please try in one hour.<BR>";
		exit();
	}

	/*
  function drop_sequence($sequence){
    // This function no longer used for MySQL
    return 0;
  }

  function reset_sequence($sequence, $newval){
    // This function no longer used for MySQL
    return 0;
  }

  function lastid(){
    // This function is only used for MySQL
    return mysqli_insert_id($this->connect_id);
  }

 function nextid($sequence) {
    // This function no longer used for MySQL
    return 0;
  }

  function close() {
  // Closes the database connection and frees any query results left.

    if ($this->query_id && is_array($this->query_id)) {
      while (list($key,$val)=each($this->query_id)) {
        mysql_free_result($val);
      }
    }
    $result=@mysqli_close($this->connect_id);
    return $result;
  }
  */

}; // End class
