<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class PlanetModel
 *
 * Handles CRUD operations and data retrieval for the `planet` table.
 */
class PlanetModel extends BaseModel
{

    /**
     * @var string $table_name The name of the database table associated with the model.
     */
    private string $table_name = "planet";

     /**
     * PlanetModel constructor.
     *
     * @param PDOService $dbo The PDO service instance for database operations.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Retrieves a list of planets with optional filtering and sorting.
     *
     * @param array $filter_params Array of filter parameters, including:
     *                             - 'name': Filter by planet name (string).
     *                             - 'minSideralRotation': Minimum sideral orbit value (float).
     *                             - 'maxSideralRotation': Maximum sideral orbit value (float).
     *                             - 'minMass': Minimum mass value (float).
     *                             - 'maxMass': Maximum mass value (float).
     *                             - 'minEquaRadius': Minimum equatorial radius value (float).
     *                             - 'maxEquaRadius': Maximum equatorial radius value (float).
     *                             - 'minGravity': Minimum gravity value (float).
     *                             - 'maxGravity': Maximum gravity value (float).
     *                             - 'discoveryDate': Filter by discovery date (string).
     *                             - 'sort_by': Column to sort by (string).
     *                             - 'order': Sort order ('asc' or 'desc').
     * @return array An array of planets matching the filters.
     */

    //? Get all Planets
    public function getPlanets(array $filter_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM planet WHERE 1 ";

        //? Apply the filters
        if (isset($filter_params['name'])) {
            $query .= " AND name LIKE
            CONCAT(:name, '%') ";
            $named_params_values['name'] = $filter_params['name'];
        }


        if (isset($filter_params['minSideralRotation'])) {
            $query .= " AND sideralOrbit >=  CONCAT(:minSideralRotation)";
            $named_params_values['minSideralRotation'] = $filter_params['minSideralRotation'];
        }
        if (isset($filter_params['maxSideralRotation'])) {
            $query .= " AND sideralOrbit <=  CONCAT(:maxSideralRotation)";
            $named_params_values['maxSideralRotation'] = $filter_params['maxSideralRotation'];
        }
        if (isset($filter_params['minMass'])) {
            $query .= " AND mass >=  CONCAT(:minMass)";
            $named_params_values['minMass'] = $filter_params['minMass'];
        }

        if (isset($filter_params['maxMass'])) {
            $query .= " AND mass <=  CONCAT(:maxMass)";
            $named_params_values['maxMass'] = $filter_params['maxMass'];
        }


        if (isset($filter_params['minEquaRadius'])) {
            $query .= " AND equaRadius >=  CONCAT(:minEquaRadius)";
            $named_params_values['minEquaRadius'] = $filter_params['minEquaRadius'];
        }

        if (isset($filter_params['maxEquaRadius'])) {
            $query .= " AND equaRadius <=  CONCAT(:maxEquaRadius)";
            $named_params_values['maxEquaRadius'] = $filter_params['maxEquaRadius'];
        }

        if (isset($filter_params['minGravity'])) {
            $query .= " AND gravity >=  CONCAT(:minGravity)";
            $named_params_values['minGravity'] = $filter_params['minGravity'];
        }

        if (isset($filter_params['maxGravity'])) {
            $query .= " AND gravity <=  CONCAT(:maxGravity)";
            $named_params_values['maxGravity'] = $filter_params['maxGravity'];
        }

        //TODO Change it later to filter by year, month, etc ...
        if (isset($filter_params['discoveryDate'])) {
            $query .= " AND discoveryDate =
            CONCAT(:discoveryDate) ";
            $named_params_values['discoveryDate'] = $filter_params['discoveryDate'];
        }

        //? Sorting
        $allowed_columns = ['name', 'mass', 'gravity'];
        $allowed_orders = ['asc', 'desc'];

        $sortBy = isset($filter_params['sort_by']) && in_array($filter_params['sort_by'], $allowed_columns) ?
            $filter_params['sort_by'] : 'planetID';

        $order = isset($filter_params['order']) && in_array($filter_params['order'], $allowed_orders) ?
            $filter_params['order'] : 'asc';

        $query .= " ORDER BY $sortBy $order";



        $planets = $this->paginate($query, $named_params_values);
        return $planets;
    }

    /**
     * Retrieves all planets without filters.
     *
     * @return mixed An array of all planets.
     */
    public function getAllPlanets(): mixed
    {
        $query = "SELECT * FROM {$this->table_name}";
        $planets = $this->fetchAll($query);
        return $planets;
    }

    //? Get planet by ID

    /**
     * Retrieves a single planet by its ID.
     *
     * @param string $planet_id The ID of the planet to retrieve.
     * @return mixed The planet data or null if not found.
     */
    public function getPlanetById(string $planet_id): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE planetID = :planet_id";
        $planet_info = $this->fetchSingle(
            $sql,
            ["planet_id" => $planet_id]
        );

        return $planet_info;
    }

    //?insert new planet

    /**
     * Inserts a new planet into the database.
     *
     * @param array $new_planet_info Associative array containing the new planet's data.
     * @return mixed The ID of the newly inserted planet.
     */
    public function insertPlanet(array $new_planet_info): mixed
    {
        $last_id = $this->insert($this->table_name, $new_planet_info);

        return $last_id;
    }

    /**
     * Updates the details of an existing planet.
     *
     * @param array $new_planet Associative array containing updated planet data.
     *                          Must include the 'planetID' key to identify the planet.
     * @return mixed The result of the update operation.
     */
    //? update planet
    public function updatePlanet(array $new_planet): mixed
    {

        $planet_id = $new_planet["planetID"];
        unset($new_planet["planetID"]);
        return $this->update($this->table_name, $new_planet, ["planetID" => $planet_id]);
    }

    /**
     * Deletes a planet from the database.
     *
     * @param string $planetID The ID of the planet to delete.
     * @return mixed The result of the delete operation.
     */
    public function deletePlanet(string $planetID): mixed
    {
        $delete = $this->delete($this->table_name, ["planetID" => $planetID]);
        return $delete;
    }
}
