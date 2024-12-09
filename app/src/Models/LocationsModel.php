<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class LocationsModel
 *
 * This class handles operations related to the "locations" table, such as CRUD operations,
 * filtering, sorting, and pagination.
 */
class LocationsModel extends BaseModel
{

    /**
     * @var string The name of the database table for locations.
     */
    private string $table_name = "locations";

    /**
     * Constructor.
     *
     * @param PDOService $dbo The database service object.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Fetches a list of locations with optional filtering, sorting, and pagination.
     *
     * @param array $filter_params Associative array of filters (e.g., name, countryCode, description, etc.).
     * @param array $sort_params Associative array for sorting with 'sortBy' (array of fields) and 'order' (ASC/DESC).
     * @return array List of filtered, sorted, and paginated locations.
     */

    public function getLocations(array $filter_params = [], array $sort_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM {$this->table_name} WHERE 1 ";


        if (isset($filter_params['name'])) {
            $query .= " AND name LIKE
            CONCAT('%', :name, '%') ";
            $named_params_values['name'] = $filter_params['name'];
        }

        if (isset($filter_params['countryCode'])) {
            $query .= " AND countryCode LIKE CONCAT(:countryCode,'%')";
            $named_params_values['countryCode'] = $filter_params['countryCode'];
        }

        if (isset($filter_params['description'])) {
            $query .= " AND description LIKE CONCAT('%',:countryCode,'%')";
            $named_params_values['description'] = $filter_params['description'];
        }

        if (isset($filter_params['timezone'])) {
            $query .= " AND timezone LIKE CONCAT('%',:timezone,'%')";
            $named_params_values['timezone'] = $filter_params['timezone'];
        }

        //Filter launch count Range
        //Min
        if (isset($filter_params['minLaunchCount'])) {
            $query .= " AND launchCount >= :minLaunchCount";
            $named_params_values['minLaunchCount'] = $filter_params['minLaunchCount'];
        }
        //Max
        if (isset($filter_params['maxLaunchCount'])) {
            $query .= " AND launchCount <= :maxLaunchCount";
            $named_params_values['maxLaunchCount'] = $filter_params['maxLaunchCount'];
        }

        //Filter landing count Range
        //Min
        if (isset($filter_params['minLandingCount'])) {
            $query .= " AND landingCount >= :minLandingCount";
            $named_params_values['minLandingCount'] = $filter_params['minLandingCount'];
        }
        //Max
        if (isset($filter_params['maxLandingCount'])) {
            $query .= " AND landingCount <= :maxLandingCount";
            $named_params_values['maxLandingCount'] = $filter_params['maxLandingCount'];
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
        $locations = $this->paginate($query, $named_params_values);
        return $locations;
    }

    /**
     * Fetches a specific location by its ID.
     *
     * @param string $locationID The ID of the location to retrieve.
     * @return mixed The location data as an associative array, or null if not found.
     */
    public function getLocationByID(string $locationID): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE id = :locationID";
        $location_info = $this->fetchSingle(
            $sql,
            ["locationID" => $locationID]
        );
        return $location_info;
    }

    /**
     * Creates a new location in the database.
     *
     * @param array $newLocation Associative array containing the location data to insert.
     * @return mixed The ID of the newly created location.
     */
    public function createLocation(array $newLocation): mixed
    {
        $locationID = $this->insert($this->table_name, $newLocation);
        return $locationID;
    }

    /**
     * Deletes a location by its ID.
     *
     * @param string $id The ID of the location to delete.
     * @return mixed The result of the delete operation (e.g., number of affected rows).
     */

    public function deleteLocation(string $id): mixed
    {
        $delete = $this->delete($this->table_name, ["id" => $id]);
        return $delete;
    }

    /**
     * Retrieves all locations from the database.
     *
     * @return mixed A list of all locations as an array of associative arrays.
     */
    public function getAllLocations(): mixed
    {
        $query = "SELECT * FROM {$this->table_name}";
        $rockets = $this->fetchAll($query);
        return $rockets;
    }

    /**
     * Updates an existing location by its ID.
     *
     * @param string $id The ID of the location to update.
     * @param array $newLocation Associative array containing the updated location data.
     * @return mixed The result of the update operation (e.g., number of affected rows).
     */
    public function updateLocation(string $id, array $newLocation): mixed
    {
        $update = $this->update($this->table_name, $newLocation, ["id" => $id]);
        return $update;
    }
}
