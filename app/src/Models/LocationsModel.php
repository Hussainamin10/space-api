<?php

namespace App\Models;

use App\Core\PDOService;

class LocationsModel extends BaseModel
{

    private string $table_name = "locations";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

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

    public function getLocationByID(string $locationID): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE id = :locationID";
        $location_info = $this->fetchSingle(
            $sql,
            ["locationID" => $locationID]
        );
        return $location_info;
    }

    public function createLocation(array $newLocation): mixed
    {
        $locationID = $this->insert($this->table_name, $newLocation);
        return $locationID;
    }

    public function deleteLocation(string $id): mixed
    {
        $delete = $this->delete($this->table_name, ["id" => $id]);
        return $delete;
    }

    public function getAllLocations(): mixed
    {
        $query = "SELECT * FROM {$this->table_name}";
        $rockets = $this->fetchAll($query);
        return $rockets;
    }

    public function updateLocation(string $id, array $newLocation): mixed
    {
        $update = $this->update($this->table_name, $newLocation, ["id" => $id]);
        return $update;
    }
}
