<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class PlayersModel
 *
 * Handles CRUD operations and data retrieval for the `players` table.
 */
class PlayersModel extends BaseModel
{

    /**
     * @var string $table_name The name of the database table associated with the model.
     */
    private string $table_name = "players";

    /**
     * PlayersModel constructor.
     *
     * @param PDOService $dbo The PDO service instance for database operations.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }


    /**
     * Retrieves a list of players with optional filtering and pagination.
     *
     * @param array $filter_params Array of filter parameters, including:
     *                             - 'given_name': Filter by player's given name (string).
     *                             - 'family_name': Filter by player's family name (string).
     * @return array An array of players matching the filters.
     */
    public function getPlayers(array $filter_params = []): array
    {
        $named_params_values = [];
        $query = "SELECT * FROM players WHERE 1 ";

        //! Apply the filter
        if (isset($filter_params['given_name'])) {
            $query .= " AND given_name LIKE
            CONCAT(:given_name, '%') ";
            $named_params_values['given_name'] = $filter_params['given_name'];
        }


        if (isset($filter_params['family_name'])) {
            $query .= " AND family_name LIKE CONCAT(:family_name,'%')";
            $named_params_values['family_name'] = $filter_params['family_name'];
        }
        // $players = (array)$this->fetchAll($query, $named_params_values);
        $players = $this->paginate($query, $named_params_values);
        return $players;
    }

    /**
     * Retrieves a single player by their ID.
     *
     * @param string $player_id The ID of the player to retrieve.
     * @return mixed The player data or null if not found.
     */

    public function getPlayerById(string $player_id): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE player_id = :player_id";
        $player_info = $this->fetchSingle(
            $sql,
            ["player_id" => $player_id]
        );

        return $player_info;
    }
}
