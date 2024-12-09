<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class MissionModel
 *
 * Handles operations related to the "spacemissions" table, such as fetching, filtering, and managing missions.
 */
class MissionModel extends BaseModel
{

    /**
     * @var string The name of the database table for space missions.
     */
    private string $table_name = "spacemissions";

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
     * Retrieves a list of missions with optional filtering and sorting.
     *
     * @param array $filter_params Associative array of filters (e.g., companyName, rocketName, launchDate, etc.).
     * @return array List of filtered and sorted missions.
     */

    //? Get all Missions

    public function getMissions(array $filter_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM spacemissions WHERE 1 ";

        //? Apply the filters
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


        //! discuss with team (might have to remove it)
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

        //? Sorting
        $allowed_columns = ['companyName', 'costOfMission', 'missionDuration'];
        $allowed_orders = ['asc', 'desc'];

        $sortBy = isset($filter_params['sort_by'])  && in_array($filter_params['sort_by'], $allowed_columns) ?
            $filter_params['sort_by'] : 'missionID';

        $order = isset($filter_params['order']) && in_array($filter_params['order'], $allowed_orders) ? $filter_params['order'] : 'asc';

        $query .= " ORDER BY $sortBy $order";


        $missions = $this->paginate($query, $named_params_values);
        return $missions;
    }


     /**
     * Retrieves a mission by its ID.
     *
     * @param string $mission_id The ID of the mission to retrieve.
     * @return mixed Mission data as an associative array, or null if not found.
     */
    //? Get mission by ID
    public function getMissionById(string $mission_id): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE missionID = :mission_id";
        $mission_info = $this->fetchSingle(
            $sql,
            ["mission_id" => $mission_id]
        );

        return $mission_info;
    }

    /**
     * Retrieves the details of a mission along with the associated astronauts by mission ID.
     *
     * @param string $mission_id The ID of the mission to retrieve.
     * @return mixed An associative array containing mission details and a list of astronauts.
     */

    //? Get astronauts by mission ID
    public function getAstronautsByMissionID(string $mission_id): mixed
    {

        //1) fetch the missions info

        $mission = $this->getMissionById($mission_id);

        //2) fetch the list of astronauts.

        $Astronauts_query = <<<SQL
        SELECT * FROM astronauts a, spacemissions s,astronautspacemission am
        WHERE  s.missionID= :missionID
        AND s.missionID = am.missionID
        AND am.astronautID = a.astronautID
        SQL;
        //3) Fetch the list of astronauts
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
