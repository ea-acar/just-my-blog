<?php
require_once 'constants.php';
// DATABASE QUERY
function sqlQueryBuilder (string $query) {
    try {
        $dsnString = "mysql:hostname=".DBHOST.";dbname=". DBNAME;
        $con = new PDO($dsnString, DBUSER, DBPASS,);
        $statement = $con->prepare($query);
        $statement->execute();
    } catch (Exception $e) {
        var_dump($e->getMessage());
        die();
    }
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(is_array($result) && !empty($result))
    {
        return $result;
    }
    return false;
}
