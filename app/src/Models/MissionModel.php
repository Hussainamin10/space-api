<?php

namespace App\Models;

use App\Core\PDOService;

class MissionModel extends BaseModel
{


    private string $table_name = "spacemissions";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    public function getMissions(array $filter_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM spacemissions WHERE 1 ";

        //! Apply the filter
        if (isset($filter_params['companyName'])) {
            $query .= " AND companyName LIKE
            CONCAT(:companyName, '%') ";
            $named_params_values['companyName'] = $filter_params['companyName'];
        }


        if (isset($filter_params['spaceStationId'])) {
            $query .= " AND spaceStationId =
            CONCAT(:spaceStationId) ";
            $named_params_values['spaceStationId'] = $filter_params['spaceStationId'];
        }

        if (isset($filter_params['rocketName'])) {

            $query = "
                SELECT sm.*, r.rocketName
                FROM spacemissions sm
                JOIN rocketspacemission rsm ON sm.missionID = rsm.missionID
                JOIN rocket r ON rsm.rocketID = r.rocketID
                WHERE r.rocketName LIKE CONCAT(:rocketName, '%')
            ";
            $named_params_values['rocketName'] = $filter_params['rocketName'];
        }

        if (isset($filter_params['locationCountryCode'])) {

            $query = "
                SELECT sm.*, l.countryCode
                FROM spacemissions sm
                JOIN locations l ON sm.location_id = l.id
                WHERE l.countryCode = :locationCountryCode
            ";
            $named_params_values['locationCountryCode'] = $filter_params['locationCountryCode'];
        }


        //TODO Change it later to filter by year, month, etc ...
        if (isset($filter_params['launchDate'])) {
            $query .= " AND launchDate =
            CONCAT(:launchDate) ";
            $named_params_values['launchDate'] = $filter_params['launchDate'];
        }


        //! discuss wiht team (might have to remove it)
        if (isset($filter_params['status'])) {
            $query .= " AND status =
            CONCAT(:status) ";
            $named_params_values['status'] = $filter_params['status'];
        }


        if (isset($filter_params['minCostOfMission'])) {
            $query .= " AND costOfTheMissions >=  CONCAT(:minCostOfMission)";
            $named_params_values['minCostOfMission'] = $filter_params['minCostOfMission'];
        }

        if (isset($filter_params['maxCostOfMission'])) {
            $query .= " AND costOfTheMissions <=  CONCAT(:maxCostOfMission)";
            $named_params_values['maxCostOfMission'] = $filter_params['maxCostOfMission'];
        }

        if (isset($filter_params['minMissionDuration'])) {
            $query .= " AND missionDuration >=  CONCAT(:minMissionDuration)";
            $named_params_values['minMissionDuration'] = $filter_params['minMissionDuration'];
        }

        if (isset($filter_params['maxMissionDuration'])) {
            $query .= " AND missionDuration <=  CONCAT(:maxMissionDuration)";
            $named_params_values['maxMissionDuration'] = $filter_params['maxMissionDuration'];
        }

        if (isset($filter_params['minCrewSize'])) {
            $query .= " AND crewSize >=  CONCAT(:minCrewSize)";
            $named_params_values['minCrewSize'] = $filter_params['minCrewSize'];
        }


        if (isset($filter_params['maxCrewSize'])) {
            $query .= " AND crewSize <=  CONCAT(:maxCrewSize)";
            $named_params_values['maxCrewSize'] = $filter_params['maxCrewSize'];
        }



        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'missionID';

        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        $query = "SELECT * FROM {$this->table_name} ORDER BY $sortBy $order";





        $missions = $this->paginate($query, $named_params_values);
        return $missions;
    }

    public function getMissionById(string $mission_id): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE missionID = :mission_id";
        $mission_info = $this->fetchSingle(
            $sql,
            ["mission_id" => $mission_id]
        );

        return $mission_info;
    }

    public function getAstronautsByMissionID(string $mission_id): mixed
    {

        //1) fetch the player info

        $mission = $this->getMissionById($mission_id);

        //2) fetch the list of goals along with the tournament and match info.

        $Astronauts_query = <<<SQL
        SELECT * FROM astronauts a, spacemissions s,astronautspacemission am
        WHERE  s.missionID= :missionID
        AND s.missionID = am.missionID
        AND am.astronautID = a.astronautID
        SQL;
        //3) Fetch the list of goals
        $astronauts = $this->fetchAll(
            $Astronauts_query,
            ["missionID" => $mission_id]
        );
        //4) Produce a well structured response
        $result = [
            "mission" => $mission,
            "astronauts" => $astronauts
        ];
        return $result;
    }
}
