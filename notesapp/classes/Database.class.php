<?php
class Database
{
    private $dbHost = 'localhost'; /** Database Host */
    private $dbUser = 'root'; /** Database Root */
    private $dbPass = ''; /** Databse Password */
    private $dbName = 'ipwebapp'; /** Database Name */
	private $connection; // Database Connection

    /**
      * @param null|void
      * @return null|void
      * @desc Creates or resume an existing database connection...
    **/
    public function __construct()
    {
		$this->dbHost;
		$this->dbUser;
		$this->dbPass;
		$this->dbName;

		$this->connect();
    }

	// Connect to Database
	private function connect()
	{
		// Create a DSN Resource...
		$DSN = "mysql:host=" . $this->dbHost . ';dbname=' . $this->dbName;

		//create a pdo options array
		$options = [
			PDO:: ATTR_ERRMODE            => PDO:: ERRMODE_EXCEPTION,
			PDO:: ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC,
			PDO:: ATTR_EMULATE_PREPARES   => false,
		];

		try {
			$this->connection = new PDO( $DSN, $this->dbUser, $this->dbPass, $options );
		}
		catch (PDOException $e){
			die("ERROR: Could not connect. " . $e->getMessage());
		}
	}

	// Returns Database Connection
	public function getConnection() {
        return $this->connection;
    }

	// Perform Database Queries [SELECT, INSERT, UPDATE, DELETE]
	public function query( $sql, $params = [] )
	{
		try {
			$statement = $this->connection->prepare( $sql );
			$statement->execute( $params );
			return $statement;
		}
		catch (PDOException $e){
			die("ERROR: Database Query Failed. " . $e->getMessage());
		}
	}

}