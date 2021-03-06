<?php

namespace Telecube;

#-- The PDO Connection Functions --#
class Db{
	
	public function query($q,$data=array(),$link){
	    
	    $query_type = substr(strtolower($q), 0, 6);
		
		try{
			$res = array();
	    	
	    	$rec = $link->prepare($q);  
	    	
	    	if($query_type == "select"){
	    		$rec->execute($data); 
				$rec->setFetchMode(\PDO::FETCH_ASSOC);  
				while($rs = $rec->fetch()){
					$res[] = $rs;
				}
	    	}else{
	    		$res = $rec->execute($data); 
	    	}

			$rec->closeCursor();
			//return $query_type == "insert" ? $link->lastinsertid() : $res;
			return $res;

	    }catch(\PDOException $ex){
			return $ex->getMessage();
	    } 
	}

	function pdo_query($q,$data=array(),$link){
		return $this->query($q,$data,$link);
	}
}

?>