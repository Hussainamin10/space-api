<?php

namespace App\Services;

use App\Core\Result;
use App\Models\RocketsModel;

class RocketsService
{
    public function __construct(private RocketsModel $rocketsModel)
    {
        $this->rocketsModel = $rocketsModel;
    }

    public function createRocket(array $newRocket): Result
    {
        /*LOOP:
            //TODO Validate the newRocket with Valitron
            - if all valid, insert the newRocket into Rocket Table
            - if not, add an error message about the current item into errors array
        END_LOOP
        if errors not empty -> return fail
        */
        //return Result::fail("I BIRTHED A ROCKET", ["Missing ME"]);
        $this->rocketsModel->createRocket($newRocket);
        return Result::success("I BIRTHED A ROCKET");
    }
}
