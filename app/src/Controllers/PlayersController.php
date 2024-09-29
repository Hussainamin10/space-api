<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\PlayersModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class PlayersController extends BaseController
{


    public function __construct(private PlayersModel $players_model)
    {
        parent::__construct();
    }
    //Route:GET /players
    public function handleGetPlayers(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        //dd(data: $filter_params);

        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->players_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }

        $players = $this->players_model->getPlayers(
            $filter_params
        );
        //dd($players);
        /*$json_paylod = json_encode($players);

        $response->getBody()->write("$json_paylod");


        return $response->withHeader(
            "Content-Type",
            "application/json"
        )->withStatus(201);
        */
        return $this->renderJson($response, $players);
    }
    public function handleGetPlayerId(Request $request, Response $response, array $uri_args): Response
    {
        //dd($uri_args["player_id"]);
        //* Step 1) Receive the received player ID

        //* Step 2) Validate the player ID

        if (!isset($uri_args['player_id'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No player ID provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        $player_id_pattern = "/^P-\d{5,6}$/";
        $player_id = $uri_args["player_id"];

        if (preg_match($player_id_pattern, $player_id) === 0) {

            throw new HttpInvalidInputsException($request, "Invalid player id provided");
        }
        //* Step 3) if Valid, fetch the player's info from the DB
        $player = $this->players_model->getPlayerById($player_id);
        // dd($player);
        if ($player === false) {
            throw new HttpNotFoundException($request, "No matching players found");
        }
        //* Step 4) Prepare valid json response

        return $this->renderJson($response, $player);
    }
}
