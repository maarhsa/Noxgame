<?php
	
	class PdoSendQuery
	{
		public $StmtQry = NULL;
		public $Query = NULL;
		public $dbHandle = NULL;
		
		function __construct($obj)
		{
			$this->Query = $obj->Query;
			$this->dbHandle = $obj->dbHandle;
		}
		
		public function select()
		{			
			try
			{
				$this->StmtQry = $this->dbHandle->query($this->Query);
			}
			catch(PDOException $e)
			{
				// Oups !!! On a rencontré un problème
				die("Error : " . $e->getMessage());
			}
			
			return $this;
		}
		
		public function update()
		{
			try
			{
				$this->dbHandle->exec($this->Query);
			}
			catch(PDOException $e)
			{
				// Oups !!! On a rencontré un problème
				die("Error : " . $e->getMessage());
			}
		}
		
		public function insert()
		{
			try
			{
				$this->dbHandle->exec($this->Query);
			}
			catch(PDOException $e)
			{
				// Oups !!! On a rencontré un problème
				die("Error : " . $e->getMessage());
			}
		}
		
		public function fetch()
		{
			return $this->StmtQry->fetch(PDO::FETCH_ASSOC);
		}
		
		public function fetchAll()
		{
			return $this->StmtQry;
		}
	}