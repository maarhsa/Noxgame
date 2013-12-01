<?php
require ('PdoSendQuery.class.'. PHPEXT);

	class PdoConnect
	{
		public $StmtQry = NULL;
		public $config = NULL;
        public $dbHandle = NULL;
        public $dsn = NULL;
        public $UserBdd = NULL;
        public $UserPwd = NULL;
		public $Query = NULL;
		
		public $ArrayValues = NULL;
		public $ArrayKeys = NULL;
		public $Key = NULL;
		public $Value = NULL;
		
		public function __construct()
		{
			// Est ce qu'on a les informations de connexion
            if (!isset($this->config))
            {
                // Non, dans ce cas, on les récupère
                $this->config = require_once(CONNECT .'config.php');
            }
            
			// Est ce qu'une connexion à la base de données existe ?
			if (!isset($this->dbHandle))
			{
				// Non ???				
				// On prépare alors les variables pour se connecter à la base de données
				$this->dsn = "{$this->config['global']['database']['engine']}:host={$this->config['global']['database']['options']['hostname']};dbname={$this->config['global']['database']['options']['database']}";
				$this->UserBdd = $this->config['global']['database']['options']['username'];
				$this->UserPwd = $this->config['global']['database']['options']['password'];
				
				try
				{
					// On crée la connexion avec la base de données
					$this->dbHandle = new PDO($this->dsn, $this->UserBdd, $this->UserPwd);
					$this->dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
				catch(PDOException $e)
				{
					// Oups !!! On a rencontré un problème
					die("Error : " . $e->getMessage());
				}
			}
        }
		
		public function query($Qry)
		{
			$this->Query = $Qry;
			
			return $this;
		}
		
		public function table($TableName)
		{
			$this->Query = str_replace("{{table}}", $this->config['global']['database']['table_prefix'] . $TableName, $this->Query);
			
			return $this;
		}
		
		public function datas($datas = array())
		{
			if ( !empty($datas) )
			{
				$this->ArrayKeys = array_keys($datas);
				$this->ArrayValues = array_values($datas);
				
				foreach ($this->ArrayValues as $this->Key => $this->Value)
				{
					$this->ArrayValues[$this->Key] = $this->SecureData($this->ArrayValues[$this->Key]);
				}
					
				$this->Query = str_replace($this->ArrayKeys, $this->ArrayValues, $this->Query);
			}
			
			return new PdoSendQuery($this);
		}
		
		public function SecureData($data)
		{
			try
			{
				return substr($this->dbHandle->quote($data), 1, -1);
			}
			catch(PDOException $e)
			{
				// Oups !!! On a rencontré un problème
				die("Error : " . $e->getMessage());
			}
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
	
?>