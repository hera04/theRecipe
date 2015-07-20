<?php

	class messages {
		
		//SINGLETON------------------------------------------------------
		private static $instance;
 		public static function getInstance()
	    {
			if(self::$instance == null) self::$instance = new messages();
			return self::$instance;
	    }
	 	//---------------------------------------------------------------
		
	    private $errors = array ();
		private $num = 0;
	
		public function addError($message) {
			$this->errors[] = $message;
			$this->num ++;
		}
	
		public function isError() {
			return count ( $this->errors ) > 0;
		}
		
		public function getErrors() {
			return $this->errors;
		}
		
		private $infos = array ();
		private $num1 = 0;
	
		public function addInfo($message) {
			$this->infos[] = $message;
			$this->num1 ++;
		}
	
		public function isInfo() {
			return count ( $this->infos ) > 0;
		}
		
		public function getInfos() {
			return $this->infos;
		}
	}
	
?>