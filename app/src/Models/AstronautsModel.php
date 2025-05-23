<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class AstronautsModel
 * 
 * This class manages the astronaut records, providing functionalities for filtering, retrieving, creating, updating, and deleting records in the database.
 */
class AstronautsModel extends BaseModel
{

    /**
     * @var string The name of the table containing astronaut records.
     */
    private string $table_name = "astronauts";

    /**
     * AstronautsModel constructor.
     * 
     * @param PDOService $dbo The database service object used for database interactions.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Retrieves a list of astronauts based on filter parameters.
     * 
     * @param array $filter_params Optional filter parameters for querying astronauts.
     * 
     * @return array The list of astronauts matching the filter criteria.
     */

    //! Get astronauts
    public function getAstronauts(array $filter_params = []): array
    {
        //! Filters
        $named_params_values = [];
        $query = "SELECT * FROM {$this->table_name} WHERE 1";

        //! firstName
        if (isset($filter_params['firstName'])) {
            $query .= " AND firstName LIKE
            CONCAT(:firstName, '%') ";
            $named_params_values['firstName'] = $filter_params['firstName'];
        }

        //! lastName
        if (isset($filter_params['lastName'])) {
            $query .= " AND lastName LIKE CONCAT(:lastName,'%')";
            $named_params_values['lastName'] = $filter_params['lastName'];
        }

        //! dateOfBirth
        //min
        if (isset($filter_params['minDateOfBirth'])) {
            $query .= " AND dateOfBirth >= :minDateOfBirth";
            $named_params_values['minDateOfBirth'] = $filter_params['minDateOfBirth'];
        }
        //max
        if (isset($filter_params['maxDateOfBirth'])) {
            $query .= " AND dateOfBirth <= :maxDateOfBirth";
            $named_params_values['maxDateOfBirth'] = $filter_params['maxDateOfBirth'];
        }

        //! numOfMissions
        //min
        if (isset($filter_params['minNumOfMissions'])) {
            $query .= " AND numOfMissions >= :minNumOfMissions";
            $named_params_values['minNumOfMissions'] = $filter_params['minNumOfMissions'];
        }
        //max
        if (isset($filter_params['maxNumOfMissions'])) {
            $query .= " AND numOfMissions <= :maxNumOfMissions";
            $named_params_values['maxNumOfMissions'] = $filter_params['maxNumOfMissions'];
        }

        //! nationality
        if (isset($filter_params['nationality'])) {
            $query .= " AND nationality LIKE CONCAT(:nationality,'%')";
            $named_params_values['nationality'] = $filter_params['nationality'];
        }

        //! inSpace
        if (isset($filter_params['inSpace'])) {
            $query .= " AND inSpace LIKE CONCAT(:inSpace,'%')";
            $named_params_values['inSpace'] = $filter_params['inSpace'];
        }

        //! dateOfDeath
        //min
        if (isset($filter_params['minDateOfDeath'])) {
            $query .= " AND dateOfDeath >= :minDateOfDeath";
            $named_params_values['minDateOfDeath'] = $filter_params['minDateOfDeath'];
        }
        //max
        if (isset($filter_params['maxDateOfDeath'])) {
            $query .= " AND dateOfDeath <= :maxDateOfDeath";
            $named_params_values['maxDateOfDeath'] = $filter_params['maxDateOfDeath'];
        }

        //! flightsCount
        //min
        if (isset($filter_params['minFlightsCount'])) {
            $query .= " AND flightsCount >= :minFlightsCount";
            $named_params_values['minFlightsCount'] = $filter_params['minFlightsCount'];
        }
        //max
        if (isset($filter_params['maxFlightsCount'])) {
            $query .= " AND flightsCount <= :maxFlightsCount";
            $named_params_values['maxFlightsCount'] = $filter_params['maxFlightsCount'];
        }

        //! Sorting
        
            $sortBy = isset($filter_params['sort_by']) ?
                $filter_params['sort_by'] : 'astronautID';

            $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

            $query .= " ORDER BY $sortBy $order";

        $astronauts = $this->paginate($query, $named_params_values);
        return $astronauts;
    }


    /**
     * Retrieves all astronauts from the database.
     * 
     * @return mixed A list of all astronauts.
     */

    //! Get all astronauts
    public function getAllAstronauts(): mixed
    {
        $query = "SELECT * FROM {$this->table_name}";
        $astronauts = $this->fetchAll($query);
        return $astronauts;
    }

    /**
     * Retrieves information for a specific astronaut by ID.
     * 
     * @param string $astronautId The ID of the astronaut to retrieve.
     * 
     * @return mixed The astronaut information, or `null` if not found.
     */

    //! Get astronaut by Id
    public function getAstronautByID(string $astronautId): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE astronautID = :astronautID";
        $astronaut_info = $this->fetchSingle(
            $sql,
            ["astronautID" => $astronautId]
        );
        return $astronaut_info;
    }


    /**
     * Creates a new astronaut record in the database.
     * 
     * @param array $new_astronaut_info The data for the new astronaut.
     * 
     * @return mixed The ID of the newly created astronaut.
     */

    //! Create new astronaut
    public function insertAstronaut(array $new_astronaut_info): mixed
    {
        $last_id = $this->insert($this->table_name, $new_astronaut_info);
        return $last_id;
    }

    //! Update astronaut
    // public function updateAstronaut(array $astronaut_info): int
    // {
    //     $astronaut_id = $astronaut_info["astronaut_id"];
    //     unset($astronaut_info["astronaut_id"]);
    //     return $this->update($this->table_name, $astronaut_info, ["astronaut_id" => $astronaut_id]);
    // }

    /**
     * Updates the information for a specific astronaut by ID.
     * 
     * @param string $astronautID The ID of the astronaut to update.
     * @param array $newAstronaut The updated data for the astronaut.
     * 
     * @return mixed The result of the update operation.
     */
    public function updateAstronaut(string $astronautID, array $newAstronaut): mixed
    {
        $update = $this->update($this->table_name, $newAstronaut, ["astronautID" => $astronautID]);
        return $update;
    }

    /**
     * Deletes a specific astronaut record by ID.
     * 
     * @param string $astronautID The ID of the astronaut to delete.
     * 
     * @return mixed The result of the delete operation.
     */

    //! Delete astronaut
    public function deleteAstronaut(string $astronautID): mixed
    {
        $delete = $this->delete($this->table_name, ["astronautID" => $astronautID]);
        return $delete;
    }
}
