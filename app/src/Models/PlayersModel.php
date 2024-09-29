<?php

namespace App\Models;

use App\Core\PDOService;

class PlayersModel extends BaseModel
{

    private string $table_name = "players";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

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
