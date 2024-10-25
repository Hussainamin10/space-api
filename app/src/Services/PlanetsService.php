<?php

namespace App\Services;

use App\Core\Result;
use App\Models\PlanetModel;

class PlanetsService
{
    public function __construct(private PlanetModel $planetModel)
    {
        $this->planetModel = $planetModel;
    }

    public function createPlanet(array $new_planet): Result
    {

        /*

        TODO 1) Validate the data of the new planet using valitron
         - if valid INSERT it into the DB
         - if not, an error message related to the current item to the errors array
         *2) INSERT into the db

         End_LOOP

         if errors not empty -> return fail.

         $this->planets_model->insertPlayer()

         return Result:: success(the new planet was added successfully)
l

     */
        $id = $this->planetModel->insertPlanet($new_planet);
        return Result::success("RANDOM failure MESSAGE!", $id);
    }
}
