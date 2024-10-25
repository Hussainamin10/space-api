<?php

namespace App\Models;

use App\Core\PDOService;

class PlanetModel extends BaseModel
{
    private string $table_name = "planet";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

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
        if (isset($filter_params['sort_by']) && isset($filter_params['order'])) {

            $sortBy = isset($filter_params['sort_by']) ?
                $filter_params['sort_by'] : 'astronautID';

            $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

            $query .= " ORDER BY $sortBy $order";
        }

        $planets = $this->paginate($query, $named_params_values);
        return $planets;
    }

    //? Get planet by ID

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

    public function insertPlanet(array $new_planet_info): mixed
    {
        $last_id = $this->insert($this->table_name, $new_planet_info);

        return $last_id;
    }

    //? update planet
    public function updatePlanet(array $new_planet): mixed
    {

        $planet_id = $new_planet["planet_id"];
        unset($new_planet["player_id"]);
        return $this->update($this->table_name, $new_planet, ["planet_id" => $planet_id]);
    }
}
