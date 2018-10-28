<?php
declare(strict_types=1);

namespace MVQN\Data;

/**
 * Class Database
 *
 * @package MVQN\Data
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 * @final
 */
final class Database
{
    private static $databaseHost;
    private static $databasePort;
    private static $databaseUser;
    private static $databasePass;
    private static $databaseName;

    private static $dsn;

    private static $pdo;

    public static function connect(string $host = "", int $port = 0, string $dbname = "", string $user = "",
        string $pass = "", bool $reconnect = false): ?\PDO
    {
        if(self::$pdo !== null && !$reconnect)
            return self::$pdo;

        if($host === "" && (self::$databaseHost === null || self::$databaseHost === ""))
            throw new Exceptions\DatabaseConnectionException("A valid host name was not provided!");
        $host = $host ?: self::$databaseHost;

        if($port === 0 && (self::$databasePort === null || self::$databasePort === 0))
            throw new Exceptions\DatabaseConnectionException("A valid port number was not provided!");
        $port = $port ?: self::$databasePort;

        if($dbname === "" && (self::$databaseName === null || self::$databaseName === ""))
            throw new Exceptions\DatabaseConnectionException("A valid database name was not provided!");
        $dbname = $dbname ?: self::$databaseName;

        if($user === "" && (self::$databaseUser === null || self::$databaseUser === ""))
            throw new Exceptions\DatabaseConnectionException("A valid username was not provided!");
        $user = $user ?: self::$databaseUser;

        if($pass === "" && (self::$databasePass === null || self::$databasePass === ""))
            throw new Exceptions\DatabaseConnectionException("A valid password was not provided!");
        $pass = $pass ?: self::$databasePass;

        self::$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        try
        {
            self::$pdo = new \PDO(self::$dsn, $user, $pass, [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);

            if(self::$pdo)
                return self::$pdo;
        }
        catch(\PDOException $e)
        {
            throw new Exceptions\DatabaseConnectionException($e->getMessage());
        }

        return null;
    }


    public static function select(string $table, array $columns = [], string $orderBy = ""): array
    {
        $pdo = self::connect();

        $sql =
            "SELECT ".($columns === [] ? "*" : implode(", ", $columns))." FROM $table".
            ($orderBy !== "" ? " ORDER BY $orderBy" : "");

        $results = $pdo->query($sql)->fetchAll();

        return $results;
    }

    public static function where(string $table, string $where = "", array $columns = [], string $orderBy = ""): array
    {
        $pdo = self::connect();

        $sql =
            "SELECT ".($columns === [] ? "*" : implode(", ", $columns))." FROM $table".
            ($where !== "" ? " WHERE $where"  : "").
            ($orderBy !== "" ? " ORDER BY $orderBy" : "");

        $results = $pdo->query($sql)->fetchAll();

        return $results;
    }





}