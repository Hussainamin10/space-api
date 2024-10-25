<?php

namespace App\Services;

use App\Core\Result;
use App\Models\AstronautsModel;
use App\Validation\Validator;

class AstronautsService
{
    public function __construct(private AstronautsModel $astronautsModel)
    {
        $this->astronautsModel = $astronautsModel;
    }

    //! Create Astronaut
    public function createAstronaut(array $new_astronaut): Result
    {
        $data = [];
        //! Astronaut full name must be unique

        //! Validate Data

        //! If invalid return fail result


        $id = $this->astronautsModel->insertAstronaut($new_astronaut);



        return Result::success("The astronaut has been created!", $id);
    }

    //! Delete Astronaut
    public function deleteAstronaut(string $astronautID): Result
    {

    }
}
