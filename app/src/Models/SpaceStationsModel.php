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
