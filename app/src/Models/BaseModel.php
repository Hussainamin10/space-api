<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\PDOService;
use App\Helpers\PaginationHelper;
use PDO;
use Exception;

/**
 * A wrapper class for interacting with a MySQL DB using the PDO API.
 * This class can be extended for further customization.
 */
abstract class BaseModel
{

    /**
     * holds a handle to a database connection.
     */
    private ?PDO $db = null;

    /**
     * The index of the current page.
     * @var int
     */
    private $current_page = 1;

    /**
     * Holds the number of records per page.
     * @var int
     */
    private $records_per_page = 5;

    /**
     * Instantiates the PDO wrapper.
     *
     * @param PDOService $pdo A helper object that contains the
     *                        established DB connection.
     */
    public function __construct(PDOService $pdo)
    {
        $this->db = $pdo->getPDO();
    }

    /**
     * Executes an SQL query using a prepared statement.
     * Arguments can be also passed to further filter the obtained result set.
     * @param  string $sql       sql query
     * @param  array  $args      filtering options that can be added to the query.
     * @return object            returns a PDO object
     */
    private function run($sql, $args = [])
    {
        if (empty($args)) {
            return $this->db->query($sql);
        }
        $stmt = $this->db->prepare($sql);
        //check if args is associative or sequential?
        $is_assoc = (array() === $args) ? false : array_keys($args) !== range(0, count($args) - 1);
        if ($is_assoc) {
            foreach ($args as $key => $value) {
                if (is_int($value)) {
                    $stmt->bindValue(":$key", $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(":$key", $value);
                }
            }
            $stmt->execute();
        } else {
            $stmt->execute($args);
        }
        return $stmt;
    }

    /**
     * Executes the provided query.
     *
     * @param  string $sql       sql query
     * @param  array  $args      filtering options that can be added to the query.
     * @param  object $fetchMode set return mode ie object or array
     * @return object            returns an array containing the selected records.
     */
    protected function fetchAll($sql, $args = [], $fetchMode = PDO::FETCH_ASSOC): array
    {
        return (array) $this->run($sql, $args)->fetchAll($fetchMode);
    }

    //* OFFSET-BASED PAGINATION: limit, offset
    protected function paginate($sql, $args = [], $fetchMode = PDO::FETCH_ASSOC): array
    {
        //*step1) Count: Get the number of records/rows will be produced upon executing the supplied SQL query($sql)
        $rows_count = $this->count($sql, $args);


        //!Step2 Instantiate the PaginationHelper class, and pass the required inputs to its constructor.
        $pagination_helper = new PaginationHelper($this->current_page, $this->records_per_page, $rows_count);



        //? Step 3) Retreive the offset from the paginationHelper's instance.
        $offset = $pagination_helper->getOffset();


        //*-- Step 4) Constrain the number of records: Append the LIMIT directive to the SQL query: -> LIMIT and OFFSET
        $sql .= " LIMIT {$this->records_per_page} OFFSET {$offset}";

        //* Step 5) Execute the query: fetchAll?
        $data = $this->fetchAll($sql, $args);


        //* Step 6) Include/combine the metadata with data?

        $meta = $pagination_helper->getPaginationMetadata();

        $results = array(
            "meta" => $meta,
            "data" => $data
        );

        return $results;
    }

    /**
     * Finds a record matching the provided filtering options.
     * Can execute a query that joins two or more tables.
     * Should be used to fetch a single record from a table.
     *
     * @param  string $sql       sql query
     * @param  array  $args      filtering options that will be appended to the WHERE clause.
     * @param  object $fetchMode set return mode ie object or array
     * @return object            returns single record
     */
    protected function fetchSingle($sql, $args = [], $fetchMode = PDO::FETCH_ASSOC)
    {
        return $this->run($sql, $args)->fetch($fetchMode);
    }


    /**
     * Gets the number of records contained in the obtained result set.
     *
     * @param  string $sql       sql query
     * @param  array  $args      filtering options.
     * @param  object $fetchMode set return mode ie object or array
     * @return integer           returns number of records
     */
    protected function count($sql, $args = []): int
    {
        return $this->run($sql, $args)->rowCount();
    }

    /**
     * Gets primary key of last inserted record.
     * Note: should be used after a SELECT statement.
     */
    protected function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * Inserts a new record into the specified table.
     *
     * @param  string $table the table name where the new data should be inserted.
     * @param  array $data  an associative array of column names (fields) and values.
     *              For example, ["username"=>"frostybee", "email" =>"frostybee@me.com"]
     */
    protected function insert($table, $data)
    {
        //add columns into comma separated string
        $columns = implode(separator: ',', array: array_keys($data));


        //get values
        $values = array_values($data);

        $placeholders = array_map(function ($val) {
            return '?';
        }, array_keys($data));

        //convert array into comma separated string
        $placeholders = implode(',', array_values($placeholders));
        $this->run("INSERT INTO $table ($columns) VALUES ($placeholders)", $values);

        return $this->lastInsertId();
    }

    /**
     * updates one or more records contained in the specified table.
     *
     * @param  string $table table name
     * @param  array $data  an array containing the names of the field(s) to be updated along with the new value(s).
     *                      For example, ["username"=>"frostybee", "email" =>"frostybee@me.com"]
     * @param  array $where an array containing the filtering operations (it should consist of column names and values)
     *                      For example, ["user_id"=> 3]
     */
    protected function update($table, $data, $where)
    {
        //merge data and where together
        $collection = array_merge($data, $where);

        //collect the values from collection
        $values = array_values($collection);

        //setup fields
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key = ?,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        //setup where
        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            $whereDetails .= $i == 0 ? "$key = ?" : " AND $key = ?";
            $i++;
        }

        $stmt = $this->run("UPDATE $table SET $fieldDetails WHERE $whereDetails", $values);

        return $stmt->rowCount();
    }

    /**
     * Deletes one or more records.
     *
     * @param  string $table table name
     * @param  array $where an array containing the filtering operation.
     * Note that those operations will eb appeNded to the WHERE Clause of the DELETE query.
     * @param  integer $limit limit number of records
     */
    protected function delete($table, $where, $limit = 1)
    {
        //collect the values from collection
        $values = array_values($where);

        //setup where
        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            $whereDetails .= $i == 0 ? "$key = ?" : " AND $key = ?";
            $i++;
        }

        //if limit is a number use a limit on the query
        if (is_numeric($limit)) {
            $limit = "LIMIT $limit";
        }

        $stmt = $this->run("DELETE FROM $table WHERE $whereDetails $limit", $values);

        return $stmt->rowCount();
    }

    public function setPaginationOptions(int $current_page, int $records_per_page): void
    {
        $this->current_page = $current_page;
        $this->records_per_page = $records_per_page;
    }
}
