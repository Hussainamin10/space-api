<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class SpaceStationsModel
 *
 * This class provides methods for interacting with the 'spacestation' table in the database.
 * It allows for querying, filtering, sorting, and retrieving space station information.
 *
 * @package App\Models
 */

class SpaceStationsModel extends BaseModel
{

    /**
     * The name of the database table for space stations.
     *
     * @var string
     */

    private string $table_name = "spacestation";

    /**
     * SpaceStationsModel constructor.
     * 
     * Initializes the model with the provided database service instance.
     *
     * @param PDOService $dbo The database service instance.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Retrieves a list of space stations based on optional filter and sort parameters.
     * 
     * This method allows for filtering the space stations by name, type, description,
     * owners, status, and founded date range. Sorting can also be applied based on the
     * specified fields and order.
     *
     * @param array $filter_params An associative array of filter parameters (e.g., 'name', 'type').
     * @param array $sort_params An associative array of sorting parameters (e.g., 'sortBy', 'order').
     *
     * @return array An array of space stations that match the filter and sort criteria.
     */

    public function getSpaceStations(array $filter_params = [],  array $sort_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM {$this->table_name} WHERE 1 ";


        if (isset($filter_params['name'])) {
            $query .= " AND name LIKE
            CONCAT('%', :name, '%') ";
            $named_params_values['name'] = $filter_params['name'];
        }

        if (isset($filter_params['type'])) {
            $query .= " AND type LIKE CONCAT(:type,'%')";
            $named_params_values['type'] = $filter_params['type'];
        }

        if (isset($filter_params['description'])) {
            $query .= " AND description LIKE CONCAT('%',:description,'%')";
            $named_params_values['description'] = $filter_params['description'];
        }

        if (isset($filter_params['owners'])) {
            $query .= " AND owners LIKE CONCAT('%',:owners,'%')";
            $named_params_values['owners'] = $filter_params['owners'];
        }

        if (isset($filter_params['status'])) {
            $query .= " AND status = :status";
            $named_params_values['status'] = $filter_params['status'];
        }

        //Filter Date Range
        //Min
        if (isset($filter_params['minFounded'])) {
            $query .= " AND founded >= :minFounded";
            $named_params_values['minFounded'] = $filter_params['minFounded'];
        }
        //Max
        if (isset($filter_params['maxFounded'])) {
            $query .= " AND founded <= :maxFounded";
            $named_params_values['maxFounded'] = $filter_params['maxFounded'];
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

        // $players = (array)$this->fetchAll($query, $named_params_values);
        $spacestations = $this->paginate($query, $named_params_values);
        return $spacestations;
    }

    /**
     * Retrieves a space station by its ID.
     *
     * This method fetches the details of a space station based on its unique station ID.
     *
     * @param string $stationID The ID of the space station to retrieve.
     *
     * @return mixed The space station's data, or null if no station is found with the given ID.
     */

    public function getSpaceStationByID(string $stationID): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE stationID = :stationID";
        $station_info = $this->fetchSingle(
            $sql,
            ["stationID" => $stationID]
        );
        return $station_info;
    }
}
