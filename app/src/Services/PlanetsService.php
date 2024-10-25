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
        $planets = $this->planetModel->getPlanets();
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
        $data['status'] = 200;
        return Result::success("Planet Added", $data);
    }
}
