<?php

namespace App\Services;

use App\Core\Result;
use App\Models\PlanetModel;
use App\Validation\Validator;

class PlanetsService
{
    public function __construct(private PlanetModel $planetModel)
    {
        $this->planetModel = $planetModel;
    }

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
}
