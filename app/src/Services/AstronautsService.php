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
    public function createAstronaut(array $newAstronaut): Result
    {
        $data = [];
        //! Astronaut full name must be unique
        $astronauts = $this->astronautsModel->getAllAstronauts();

        $existingFirstNames = [];
        $existingLastNames = [];

        foreach ($astronauts as $astronaut) {

            if (isset($astronaut['firstName'])) {
                $existingFirstNames[] = $astronaut['firstName'];
            }
            if (isset($astronaut['lastName'])) {
                $existingLastNames[] = $astronaut['lastName'];
            }
        }
        //! Validate data passed
        $validator = new Validator($newAstronaut);
        $validator->rules([
            'required' => [
                'firstName',
                'lastName',
                'numOfMissions',
                'nationality',
                'inSpace',
                'dateOfDeath',
                'flightsCount',
                'dateOfBirth',
                'bio',
                'wiki',
                'image',
                'thumbnail'
            ],
            'in' => [
                ['inSpace', ['0', '1']]
            ],
            'notIn' => [
                ['firstName', $existingFirstNames],
                ['lastName', $existingLastNames]
            ],
            'integer' => ['numOfMissions', 'flightsCount']
        ]);
        //! If invalid return fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        $id = $this->astronautsModel->insertAstronaut($newAstronaut);
        $data['data'] = $this->astronautsModel->getAstronautByID($id);
        $data['status'] = 200;

        return Result::success("The astronaut has been created!", $id);
    }

    //! Delete Astronaut
    public function deleteAstronaut(string $astronautID): Result
    {
        $validator = new Validator(['ID' => $astronautID]);
        $validator->rule('integer', 'ID');
        $data = [];

        //*If Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not Valid", $data);
        }

        //*Delete Rocket
        $delete = $this->astronautsModel->deleteAstronaut($astronautID);

        //*If No Item Deleted
        if ($delete == 0) {
            $data['data'] = $delete;
            $data['status'] = 200;
            return Result::success("No astronaut deleted.", $data);
        }

        //*Item Deleted
        $data['data'] = $delete;
        $data['status'] = 200;
        return Result::success("Astronaut Deleted", $data);
    }
}
