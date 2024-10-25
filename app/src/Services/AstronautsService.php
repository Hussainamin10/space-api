<?php

namespace App\Services;

use App\Core\Result;
use App\Models\AstronautsModel;

class AstronautsService
{
    public function __construct(private AstronautsModel $astronautsModel)
    {
        $this->astronautsModel = $astronautsModel;
    }
    public function createAstronaut(array $new_astronaut): Result
    {

        /*

        errors[]

        LOOP:
        TODO 1) Validate the data of the new [your collection resource] using Valtron

        - If valid INSERT it into the DB
        - If not an error message related the the current item

        //* 2) INSERT into the DB


    END_LOOP
    if errors not empty -> return fail
        */
        $id = $this->astronautsModel->insertAstronaut($new_astronaut);



        return Result::success("The astronaut has been created!", $id);
    }
}
