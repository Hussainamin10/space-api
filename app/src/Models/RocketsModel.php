<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class RocketsModel
 *
 * Handles CRUD operations and data retrieval for the `rocket` table.
 */

class RocketsModel extends BaseModel
{

    /**
     * @var string $table_name The name of the database table associated with the model.
     */
    private string $table_name = "rocket";

    /**
     * RocketsModel constructor.
     *
     * @param PDOService $dbo The PDO service instance for database operations.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Retrieves a list of rockets with optional filtering and sorting.
     *
     * @param array $filter_params Array of filter parameters, including:
     *                             - 'rocketName': Filter by rocket name (string).
     *                             - 'companyName': Filter by company name (string).
     *                             - 'status': Filter by status (string).
     *                             - 'minHeight', 'maxHeight': Filter by height range (numeric).
     *                             - 'minWeight', 'maxWeight': Filter by weight range (numeric).
     *                             - 'minCost', 'maxCost': Filter by cost range (numeric).
     *                             - 'minThrust', 'maxThrust': Filter by thrust range (numeric).
     *                             - 'numberOfStages': Filter by the number of stages (integer).
     * @param array $sort_params Array of sorting parameters, including:
     *                           - 'sortBy': An array of fields to sort by (array).
     *                           - 'order': Sort order, either 'ASC' or 'DESC' (string).
     * @return array A paginated array of rockets matching the filters and sort criteria.
     */

    public function getRockets(array $filter_params = [], array $sort_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM {$this->table_name} WHERE 1 ";

        //Filer Rocket Name
        if (isset($filter_params['rocketName'])) {
            $query .= " AND rocketName LIKE
            CONCAT('%', :rocketName, '%') ";
            $named_params_values['rocketName'] = $filter_params['rocketName'];
        }

        //Filter Company Name
        if (isset($filter_params['companyName'])) {
            $query .= " AND companyName LIKE CONCAT(:companyName,'%')";
            $named_params_values['companyName'] = $filter_params['companyName'];
        }

        //Filter Status
        if (isset($filter_params['status'])) {
            $query .= " AND status = :status";
            $named_params_values['status'] = $filter_params['status'];
        }

        //Filter Height Range
        //Min
        if (isset($filter_params['minHeight'])) {
            $query .= " AND rocketHeight >= :minHeight";
            $named_params_values['minHeight'] = $filter_params['minHeight'];
        }
        //Max
        if (isset($filter_params['maxHeight'])) {
            $query .= " AND rocketHeight <= :maxHeight";
            $named_params_values['maxHeight'] = $filter_params['maxHeight'];
        }

        //Filter Weight Range
        //Min
        if (isset($filter_params['minWeight'])) {
            $query .= " AND rocketWeight >= :minWeight";
            $named_params_values['minWeight'] = $filter_params['minWeight'];
        }
        //Max
        if (isset($filter_params['maxWeight'])) {
            $query .= " AND rocketWeight <= :maxWeight";
            $named_params_values['maxWeight'] = $filter_params['maxWeight'];
        }

        //Filter Cost Range
        //Min
        if (isset($filter_params['minCost'])) {
            $query .= " AND launchCost >= :minCost";
            $named_params_values['minCost'] = $filter_params['minCost'];
        }
        //Max
        if (isset($filter_params['maxCost'])) {
            $query .= " AND launchCost <= :maxCost";
            $named_params_values['maxCost'] = $filter_params['maxCost'];
        }

        //Filter Thrust Range
        //Min
        if (isset($filter_params['minThrust'])) {
            $query .= " AND liftOfThrust >= :minThrust";
            $named_params_values['minThrust'] = $filter_params['minThrust'];
        }
        //Max
        if (isset($filter_params['maxThrust'])) {
            $query .= " AND liftOfThrust <= :maxThrust";
            $named_params_values['maxThrust'] = $filter_params['maxThrust'];
        }

        if (isset($filter_params['numberOfStages'])) {
            $query .= " AND numberOfStages = :numberOfStages";
            $named_params_values['numberOfStages'] = $filter_params['numberOfStages'];
        }

        if (!empty($sort_params['sortBy'])) {
            $query .= " ORDER BY";
            foreach ($sort_params['sortBy'] as $field) {
                $query .= " $field " . $sort_params['order'];
                //*Check if the current value is the last element, to add ',' to seperate the sort params
                if (end($sort_params['sortBy']) !== $field) {
                    $query .= ",";
                }
            }
        }
        $rockets = $this->paginate($query, $named_params_values);
        return $rockets;
    }


    /**
     * Retrieves all rockets without filtering or sorting.
     *
     * @return mixed An array of all rockets.
     */
    public function getAllRockets(): mixed
    {
        $query = "SELECT * FROM {$this->table_name}";
        $rockets = $this->fetchAll($query);
        return $rockets;
    }

    /**
     * Retrieves a single rocket by its ID.
     *
     * @param string $rocketID The ID of the rocket to retrieve.
     * @return mixed The rocket data or null if not found.
     */
    public function getRocketByID(string $rocketID): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE rocketID = :rocketID";
        $rocket_info = $this->fetchSingle(
            $sql,
            ["rocketID" => $rocketID]
        );
        return $rocket_info;
    }

    /**
     * Retrieves a rocket and its associated missions by rocket ID.
     *
     * @param string $rocketID The ID of the rocket.
     * @return mixed An array containing the rocket data and its associated missions.
     */

    public function getMissionsByRocketID(string $rocketID): mixed
    {
        $rocket = $this->getRocketById($rocketID);

        $missions_query = <<<SQL
                        SELECT * FROM spacemissions s
                        JOIN rocketspacemission rs ON s.missionID = rs.missionID
                        WHERE rs.rocketID = :rocketID
                        SQL;

        $missions = $this->fetchAll(
            $missions_query,
            ["rocketID" => $rocketID]
        );

        $result = [
            "rocket" => $rocket,
            "missions" => $missions
        ];
        return $result;
    }

    /**
     * Creates a new rocket in the database.
     *
     * @param array $newRocket An associative array containing the new rocket's data.
     * @return mixed The ID of the newly created rocket.
     */
    public function createRocket(array $newRocket): mixed
    {
        $newRocketID = $this->insert($this->table_name, $newRocket);
        return $newRocketID;
    }

    /**
     * Deletes a rocket by its ID.
     *
     * @param string $rocketID The ID of the rocket to delete.
     * @return mixed The result of the delete operation.
     */
    public function deleteRocket(string $rocketID): mixed
    {
        $delete = $this->delete($this->table_name, ["rocketID" => $rocketID]);
        return $delete;
    }

     /**
     * Updates a rocket's information.
     *
     * @param string $rocketID The ID of the rocket to update.
     * @param array $newRocket An associative array of the updated rocket data.
     * @return mixed The result of the update operation.
     */
    public function updateRocket(string $rocketID, array $newRocket): mixed
    {
        $update = $this->update($this->table_name, $newRocket, ["rocketID" => $rocketID]);
        return $update;
    }
}
