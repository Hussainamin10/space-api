<?php

namespace App\Services;

use App\Core\Result;
use App\Models\PlanetModel;
use App\Validation\Validator;

/**
 * PlanetsService class provides methods to manage planet-related operations such as 
 * retrieving, creating, updating, and deleting planets, as well as fetching additional 
 * information from an external API.
 */
class PlanetsService
{

     /**
     * PlanetsService constructor.
     *
     * @param PlanetModel $planetModel The planet model to interact with the database.
     */
    public function __construct(private PlanetModel $planetModel)
    {
        $this->planetModel = $planetModel;
    }


    /**
     * Get a planet by its ID.
     *
     * @param string $planetID The unique identifier of the planet.
     *
     * @return Result The result of the operation, either success with planet data or failure with error details.
     */
    public function getPlanetByID(string $planetID): Result
    {
        $validator = new Validator(['ID' => $planetID]);
        $validator->rule('integer', 'ID');

        //*IF Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not valid", $data);
        }

        $planet = $this->planetModel->getPlanetById($planetID);
        //*IF planet doesn't exist
        if (!$planet) {
            $data['data'] = "";
            $data['status'] = 404;
            return Result::fail("No Planet found", $data);
        }

        $data['data'] = $planet;
        $data['status'] = 200;
        return Result::success("Planet returned", $data);
    }

    /**
     * Create a new planet.
     *
     * @param array $new_planet The new planet data.
     *
     * @return Result The result of the creation operation, either success with planet data or failure with validation errors.
     */

    public function createPlanet(array $new_planet): Result
    {
        //?planet Name Must be Unique
        $planets = $this->planetModel->getAllPlanets();
        $planetNames = [];
        foreach ($planets as $planet) {
            $planetNames[] = $planet['name'];
        }

        //?Validate Data Passed
        $validator = new Validator($new_planet);
        $validator->rules([
            'required' => [
                'name',
                'sideralOrbit',
                'sideralRotation',
                'mass',
                'equaRadius',
                'gravity',
                'discoveryDate',
                'discoveredBy'
            ],
            'numeric' => [
                'sideralOrbit',
                'sideralRotation',
                'mass',
                'equaRadius',
                'gravity'
            ],
            'notIn' => [['name', $planetNames]]
        ]);

        //?If Invalid Return Fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        //?Round the numerical value to 2 decimal before adding
        $new_planet["sideralOrbit"] = round($new_planet["sideralOrbit"], 2);
        $new_planet["sideralRotation"] = round($new_planet["sideralRotation"], 2);
        $new_planet["mass"] = round($new_planet["mass"], 2);
        $new_planet["equaRadius"] = round($new_planet["equaRadius"], 2);
        $new_planet["gravity"] = round($new_planet["gravity"], 2);

        $id = $this->planetModel->insertPlanet($new_planet);
        $data['data'] = $this->planetModel->getPlanetById($id);
        $data['status'] = 201;
        return Result::success("Planet Added", $data);
    }

    /**
     * Delete a planet by its ID.
     *
     * @param string $planetID The unique identifier of the planet to be deleted.
     *
     * @return Result The result of the deletion operation, either success or failure.
     */
    public function deletePlanet(string $planetID): Result
    {
        $validator = new Validator(['ID' => $planetID]);
        $validator->rule('integer', 'ID');
        $data = [];

        //?If Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not Valid", $data);
        }

        //?Delete planet
        $delete = $this->planetModel->deletePlanet($planetID);

        //?If No Item Deleted
        if ($delete == 0) {
            $data['data'] = $delete;
            $data['status'] = 400;
            return Result::fail("No planet deleted.", $data);
        }

        //?Item Deleted
        $data['data'] = $delete;
        $data['status'] = 200;
        return Result::success("Planet Deleted", $data);
    }


    /**
     * Update the details of a planet.
     *
     * @param array $newPlanet The updated planet data, including the planet ID.
     *
     * @return Result The result of the update operation, either success with updated data or failure with validation errors.
     */
    //TODO execute put without passing the id in the uri
    public function updatePlanet(array $newPlanet): Result
    {
        $data = [];
        //? Validate if the fields to be updated exist
        $updateFields = [
            'planetID',
            'name',
            'sideralOrbit',
            'sideralRotation',
            'mass',
            'equaRadius',
            'gravity',
            'discoveryDate',
            'discoveredBy'
        ];
        foreach ($newPlanet as $key => $value) {
            if (!in_array($key, $updateFields)) {
                $data['data'] = "Invalid Field: " . $key;
                $data['status'] = 400;
                return Result::fail("No existing field to update", $data);
            }
        }

        $planetID = $newPlanet["planetID"];
        //? Check if planet id provided is Valid
        $validator = new Validator(["planetID" => $planetID]);
        $validator->rule("integer", "planetID");
        $validator->rule("required", "planetID");
        if (!$validator->validate()) {
            $data['data'] = "ID provided: " . $planetID;
            $data['status'] = 400;
            return Result::fail("Planet ID is invalid", $data);
        }
        //? Check if planet exist
        $planet = $this->planetModel->getPlanetById($planetID);
        if (!$planet) {
            $data['data'] = "ID provided: " . $planetID;
            $data['status'] = 404;
            return Result::fail("Planet does not exist", $data);
        }


        $validator = new Validator($newPlanet);

        //?planet Name Must be Unique
        $planets = $this->planetModel->getAllPlanets();
        $planetNames = [];
        foreach ($planets as $planet) {
            $planetNames[] = $planet['name'];
        }

        $validator->rules([
            'numeric' => [
                'sideralOrbit',
                'sideralRotation',
                'mass',
                'equaRadius',
                'gravity'
            ],
            'notIn' => [['name', $planetNames]]
        ]);
        //?If Invalid Return Fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        if (!$newPlanet) {
            $data['data'] = "";
            $data['status'] = 400;
            return Result::fail("Please provide at least one valid field to update", $data);
        }


        $update = $this->planetModel->updatePlanet($newPlanet);
        //?Item Deleted
        $data['data'] = $update;
        $data['status'] = 200;
        return Result::success("Planet Updated", $data);
    }

    /**
     * Fetch extra information about a planet from an external API.
     *
     * @param string $planetID The unique identifier of the planet.
     *
     * @return Result The result of the operation, either success with additional data or failure if the planet does not exist.
     */

    public function getExtraPlanetInfo(string $planetID)
    {
        $result = $this->getPlanetByID($planetID);
        if ($result->isSuccess()) {
            //*Have a planet, get the planet name, search by its name
            $planetName = $result->getData()['data']["name"];
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://api.le-systeme-solaire.net/rest/bodies/?filter%5b%5d=isPlanet,eq,true&filter%5b%5d=englishName,eq,$planetName", [
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ]);

            //*If status is 200 process, else return error
            if ($response->getStatusCode() == 200) {
                $responseBody = json_decode($response->getBody(), true);
                $data['data'] = [
                    "Planet" => $result->getData()["data"],
                    "Extra Info From APi" => $responseBody["bodies"]
                ];
                $data['status'] = 200;
                return Result::success("Return Extra Info by planet ID", $data);
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }
}
