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
        //* Astronaut full name must be unique
        $astronauts = $this->astronautsModel->getAllAstronauts();

        $firstName = [];



        //* Validate data passed
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
            'integer' => ['numOfMissions', 'flightsCount']
        ]);


        //* If invalid return fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        // Check if new full name already exists
        foreach ($astronauts as $astronaut) {
            if (isset($astronaut['firstName']) && isset($astronaut['lastName'])) {
                if (
                    $astronaut['firstName'] === $newAstronaut['firstName'] &&
                    $astronaut['lastName'] === $newAstronaut['lastName']
                ) {
                    $data['data'] = "An astronaut with this full name already exists.";
                    $data['status'] = 400;
                    return Result::fail("Provided value(s) is(are) not valid", $data);
                }
            }
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

        //* If Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not Valid", $data);
        }

        //* Delete Astronaut
        $delete = $this->astronautsModel->deleteAstronaut($astronautID);

        //* If No Item Deleted
        if ($delete == 0) {
            $data['data'] = $delete;
            $data['status'] = 400;
            return Result::success("No astronaut deleted.", $data);
        }

        //*Item Deleted
        $data['data'] = $delete;
        $data['status'] = 200;
        return Result::success("Astronaut Deleted", $data);
    }

    //! Update Astronaut
    public function updateAstronaut(mixed $astronautID, array $newAstronaut): Result
    {
        $data = [];
        //* Check if astronaut id provided is Valid
        $validator = new Validator(["astronautID" => $astronautID]);
        $validator->rule("integer", "astronautID");
        $validator->rule("required", "astronautID");
        if (!$validator->validate()) {
            $data['data'] = "ID provided: " . $astronautID;
            $data['status'] = 400;
            return Result::fail("Astronaut ID is invalid", $data);
        }
        //* Check if Astronaut exist
        $astronaut = $this->astronautsModel->getAstronautByID($astronautID);
        if (!$astronaut) {
            $data['data'] = "ID provided: " . $astronautID;
            $data['status'] = 404;
            return Result::fail("Astronaut does not exist", $data);
        }

        //* Validate if the fields to be updated exist
        $updateFields = [
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
        ];
        foreach ($newAstronaut as $key => $value) {
            if (!in_array($key, $updateFields)) {
                $data['data'] = "Invalid Field: " . $key;
                $data['status'] = 400;
                return Result::fail("No existing field to update", $data);
            }
        }

        $validator = new Validator($newAstronaut);

        //* Astronaut full name must be unique
        $astronauts = $this->astronautsModel->getAllAstronauts();

        $existingFullNames = [];

        foreach ($astronauts as $astronaut) {
            if (isset($astronaut['firstName']) && isset($astronaut['lastName'])) {
                $existingFullNames[] = $astronaut['firstName'] . ' ' . $astronaut['lastName'];
            }
        }

        $validator->rules([
            'in' => [
                ['inSpace', ['0', '1']]
            ],
            'notIn' => [
                ['fullName', $existingFullNames]
            ],
            'integer' => ['numOfMissions', 'flightsCount']
        ]);
        //* If invalid return fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        $update = $this->astronautsModel->updateAstronaut($astronautID, $newAstronaut);
        //* Item Deleted
        $data['data'] = $update;
        $data['status'] = 200;
        return Result::success("Astronaut Updated", $data);
    }
}
