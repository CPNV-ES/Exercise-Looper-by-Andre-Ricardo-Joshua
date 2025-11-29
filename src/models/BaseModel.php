<?php

namespace App\Models;

use App\Controllers\DatabaseController;

#[AllowDynamicProperties]
abstract class BaseModel
{
    /**
     * Executes a prepared SQL statement.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     * @return \PDOStatement The executed statement.
     */
    protected static function executeQuery(string $sql, array $params = []): \PDOStatement
    {
        $pdo = DatabaseController::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Gets the ID of the last inserted row.
     *
     * @return int The last insert ID.
     */
    protected static function getLastInsertId(): int
    {
        return (int)DatabaseController::getInstance()->lastInsertId();
    }

    /**
     * Executes a query and maps the results to the calling class.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     * @param bool $single Whether to fetch a single record.
     * @return array|static|null An array of objects, a single object, or null.
     */
    protected static function queryAndMap(string $sql, array $params = [], bool $single = false)
    {
        $stmt = static::executeQuery($sql, $params);

        $className = static::class;

        return $single ? $stmt->fetchObject($className) ?: null : $stmt->fetchAll(\PDO::FETCH_CLASS, $className);
    }
}