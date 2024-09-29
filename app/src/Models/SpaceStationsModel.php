<?php

namespace App\Models;

use App\Core\PDOService;

class SpaceStationsModel extends BaseModel
{

    private string $table_name = "spacestation";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    public function getSpaceStations(array $filter_params = []): array
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
        // $players = (array)$this->fetchAll($query, $named_params_values);
        $spacestations = $this->paginate($query, $named_params_values);
        return $spacestations;
    }

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
