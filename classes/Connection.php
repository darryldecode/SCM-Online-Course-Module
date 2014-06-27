<?php namespace SCM\Classes;

use \PDO;

class Connection {

    /**
     * the instance
     *
     * @var Connection
     */
    public static $instance;

    /**
     * DB HOST
     *
     * @var string
     */
    private $host;

    /**
     * the database name
     *
     * @var string
     */
    private $dbname;

    /**
     * the database username
     *
     * @var string
     */
    private $username;

    /**
     * the database password
     *
     * @var string
     */
    private $password;

    /**
     * the database prefix
     *
     * @var
     */
    private $prefix;

    /**
     * the db handler
     *
     * @var null
     */
    public $dbhandler = null;

    /**
     * the query
     *
     * @var
     */
    private $query;

    /**
     * process holder
     *
     * @var
     */
    private $stmt;

    /**
     * if transaction succeeds
     *
     * @var
     */
    public $isSuccess;

    public function __construct()
    {
        global $wpdb;

        $this->host 	= DB_HOST;
        $this->dbname	= DB_NAME;
        $this->username	= DB_USER;
        $this->password	= DB_PASSWORD;
        $this->prefix	= $wpdb->base_prefix;

        $this->dbhandler = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
        $this->dbhandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$instance = $this;
    }

    public static function getInstance()
    {
        if( !(self::$instance instanceof self) )
        {
            return self::$instance = new self();
        } else {
            return self::$instance;
        }
    }

    /**
     * get database prefix
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * sets the query
     *
     * @param $query
     * @return $this
     */
    public function query( $query )
    {
        $this->query = $query ;
        return $this;
    }

    /**
     * binds value
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function bindValue( $key , $value )
    {
        $this->stmt->bindValue( $key ,	$value );
        return $this;
    }

    /**
     * binds params
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function bindParam( $key , $value )
    {
        $this->stmt->bindParam( $key ,	$value );
        return $this;
    }

    /**
     * execute
     *
     * @return $this
     */
    public function execute()
    {
        $this->stmt = $this->dbhandler->prepare( $this->query );
        $this->isSuccess = $this->stmt->execute();
        return $this;
    }

    /**
     * check if the query was successful
     *
     * @return mixed
     */
    public function isSuccessful()
    {
        return $this->isSuccess;
    }

    /**
     * get row count
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * fetch assoc
     *
     * @return mixed
     */
    public function fetchAssoc()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * fetch num
     *
     * @return mixed
     */
    public function fetchNum()
    {
        return $this->stmt->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * fetch as obj
     *
     * @return mixed
     */
    public function fetchObj()
    {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * begin transaction
     *
     * @return $this
     */
    public function beginTransaction()
    {
        $this->dbhandler->beginTransaction();
        return $this;
    }

    /**
     * commits the transaction
     *
     * @return $this
     */
    public function commit(){
        $this->dbhandler->commit();
        return $this;
    }

    /**
     * rolls back a transaction
     *
     * @return $this
     */
    public function rollBack()
    {
        $this->dbhandler->rollBack();
        return $this;
    }

    /**
     * get last inserted ID
     *
     * @return mixed
     */
    public function lastInsertedID()
    {
        return $this->dbhandler->lastInsertId();
    }

    /**
     * resets data
     */
    public function resetData()
    {
        unset( $this->query );
        unset( $this->stmt );
        return $this;
    }

    /**
     * destroy connection
     *
     * @return $this
     */
    public function destroyConnection()
    {
        unset( $this->dbhandler );
        return $this;
    }

}