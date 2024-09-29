<?php

namespace App\Models;

use App\Core\PDOService;

class RocketsModel extends BaseModel
{

    private string $table_name = "rocket";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    public function getRockets(array $filter_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM {$this->table_name} WHERE 1 ";


        if (isset($filter_params['rocketName'])) {
            $query .= " AND rocketName LIKE
            CONCAT('%', :rocketName, '%') ";
            $named_params_values['rocketName'] = $filter_params['rocketName'];
        }

        if (isset($filter_params['companyName'])) {
            $query .= " AND companyName LIKE CONCAT(:companyName,'%')";
            $named_params_values['companyName'] = $filter_params['companyName'];
        }
        // $players = (array)$this->fetchAll($query, $named_params_values);
        $rockets = $this->paginate($query, $named_params_values);
        return $rockets;
    }

    public function getRocketByID(string $rocketID): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE rocketID = :rocketID";
        $rocket_info = $this->fetchSingle(
            $sql,
            ["rocketID" => $rocketID]
        );
        return $rocket_info;
    }
}
