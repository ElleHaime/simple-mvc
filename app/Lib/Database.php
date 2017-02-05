<?php

namespace Lib;

use Lib\Utils as U;

class Database
{
	protected $instance 	= false;
	private $_connection	= null;
	private $_adapter		= null;
	private $_host			= null;	
	private $_port			= null;
	private $_username		= null;
	private $_password		= null;
	private $_dbname		= null;
	private $_params		= [];
	private $_dbQuery		= '';



	public function __construct($config)
	{
		if (!$this -> instance) {
			$this -> _adapter = $config -> adapter;
			$this -> _dbname = $config -> dbname;
			$this -> _host = $config -> host;
			$this -> _port = $config -> port;
			$this -> _username = $config -> user;
			$this -> _password = $config -> password;

			$this -> _connect();
			$this -> instance = $this;
		}

		return $this -> instance;		
	}


	private function _connect()
	{
		$this -> _connection = new \PDO($this -> _adapter . 
											':host=' . $this -> _host . 
											';port=' . $this -> _port . 
											';dbname=' . $this -> _dbname . 
											';charset=utf8', 
										$this -> _username, 
										$this -> _password, 
										array(\PDO::ATTR_PERSISTENT => true));	
		$this -> _connection -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
		return $this;
	}


	public function disconnect()
	{
		$this -> _connection = null;
	}


	public function query($query, $params = [], $fetchMode = \PDO::FETCH_OBJ)
	{
		$this -> run($query, $params); 

		$rawStatement = explode(' ', preg_replace('/\s+|\t+|\n+/', ' ', $query));
		$statement = strtolower($rawStatement[0]);

		if ($statement === 'select' || $statement === 'show') {
			return $this -> dbQuery -> fetchAll($fetchMode);
		} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
			return $this -> dbQuery -> rowCount();
		} else {
			return NULL;
		}
	}


	public function bind($param, $value)
    {
        $this -> _params[] = [':' . $param, $value];
        return $this;
    }


    public function bindAll($params)
    {
        if (is_array($params)) {
            $columns = array_keys($params);

            foreach ($columns as $key => &$column) {
                $this -> bind($column, $params[$column]);
            }
        }

        return $this;
    }


    public function lastInsertId()
    {
        return $this -> _connection -> lastInsertId();
    }


    public function resetParams()
    {
    	$this -> _params = [];
    }


	public function getOne($query, $params = null, $fetchMode = \PDO::FETCH_OBJ)
    {
		$this -> run($query, $params);
		$result = $this -> dbQuery -> fetch($fetchMode);

        return $result;
    }


    private function run($query, $params = [])
    {
    	if (is_null($this -> _connection)) {
			throw new \Exception('Something wrong with your container, dude');
		}
		$this -> dbQuery = $this -> _connection -> prepare($query);
		if (!$this -> dbQuery) {
			throw new \Exception($this -> _connection -> errorInfo()[0]);	
		}	

		if (!empty($params)) {
			$this -> bindAll($params);
		}

		if (!empty($this -> _params)) {
			foreach ($this -> _params as $param => $val) {
				if(is_int($val[1])) {
					$type = \PDO::PARAM_INT;
				} else if(is_bool($val[1])) {
					$type = \PDO::PARAM_BOOL;
				} else if(is_null($val[1])) {
					$type = \PDO::PARAM_NULL;
				} else {
					$type = \PDO::PARAM_STR;
				}

				$this -> dbQuery -> bindValue($val[0], $val[1], $type);
			}
		}

		$this -> dbQuery -> execute();
		$this -> resetParams();

		return $this;
    }


	public function composeValsFromArray($data)
	{
		$bindVals = [];

		foreach (array_keys($data) as $i => $v) {
			$bindVals[] = ':' . $v;
		}

		return implode(',', $bindVals);
	}
}
