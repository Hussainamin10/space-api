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

    public function getAllRockets(): mixed
    {
        $query = "SELECT * FROM {$this->table_name}";
        $rockets = $this->fetchAll($query);
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
    public function createRocket(array $newRocket): mixed
    {

        $newRocketID = $this->insert($this->table_name, $newRocket);
        return $newRocketID;
    }

    public function deleteRocket(string $rocketID): mixed
    {
        $delete = $this->delete($this->table_name, ["rocketID" => $rocketID]);
        return $delete;
    }
}
