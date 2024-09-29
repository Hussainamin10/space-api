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

    public function getLocations(array $filter_params = []): array
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
}
