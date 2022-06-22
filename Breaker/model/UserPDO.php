
<?php

class UserPDO
{
  private string $DB_HOST;
  private string $DB_PORT;
  private string $DB_NAME;
  private string $DB_USERNAME;
  private string $DB_PASSWORD;

  function __construct($DB_HOST, $DB_PORT, $DB_NAME, $DB_USERNAME, $DB_PASSWORD)
  {
    $this->DB_HOST = $DB_HOST;
    $this->DB_PORT = $DB_PORT;
    $this->DB_NAME = $DB_NAME;
    $this->DB_USERNAME = $DB_USERNAME;
    $this->DB_PASSWORD = $DB_PASSWORD;
  }

  public function dbConnect(): PDO
  {
    return new PDO(  // on récupère la base de données dans laquelle on souhaite rentrer des informations
      'mysql:host=' . $this->DB_HOST . ';port=' . $this->DB_PORT . ';dbname=' . $this->DB_NAME, // on concatene les infos a mettre obligatoire avec celles qui sont modifiables
      $this->DB_USERNAME,
      $this->DB_PASSWORD
    );
  }
}

$connection = new UserPDO('db.3wa.io', '3306', 'danielchea_thebreaker', 'danielchea', '336eabfd8b2fffef3fa3cf40abe54ff9');

$pdo = $connection->dbConnect();
