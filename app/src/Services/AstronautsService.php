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
            return Result::fail("No astronaut deleted.", $data);
        }

        //*Item Deleted
        $data['data'] = $delete;
        $data['status'] = 200;
        return Result::success("Astronaut Deleted", $data);
    }

    //! Update Astronaut
    public function updateAstronaut(array $newAstronaut): Result
    {
        $data = [];

        //* Validate if the fields to be updated exist
        $updateFields = [
            'astronautID',
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
            if (isset($astronaut['firstName']) && isset($astronaut['lastName']) && isset($newAstronaut['firstName']) && isset($newAstronaut['lastName'])) {
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

        //* Check if Astronaut exist
        $astronaut = $this->astronautsModel->getAstronautByID($newAstronaut['astronautID']);
        if (!$astronaut) {
            $data['data'] = "ID provided: " . $newAstronaut['astronautID'];
            $data['status'] = 404;
            return Result::fail("Astronaut does not exist", $data);
        }

        $astronautID = $newAstronaut['astronautID'];
        unset($newAstronaut['astronautID']);

        if (!$newAstronaut) {
            $data['data'] = "";
            $data['status'] = 400;
            return Result::fail("Please provide at least one valid field to update", $data);
        }

        $update = $this->astronautsModel->updateAstronaut($astronautID, $newAstronaut);
        //* Item Deleted
        $data['data'] = $update;
        $data['status'] = 200;
        return Result::success("Astronaut Updated", $data);
    }

    public function getAstronautByID(string $astronautID): Result
    {
        $validator = new Validator(['ID' => $astronautID]);
        $validator->rule('integer', 'ID');

        //*IF Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not valid", $data);
        }

        $rocket = $this->astronautsModel->getAstronautByID($astronautID);
        //*IF rocket doesn't exist
        if (!$rocket) {
            $data['data'] = "";
            $data['status'] = 404;
            return Result::fail("No astronaut found", $data);
        }

        $data['data'] = $rocket;
        $data['status'] = 200;
        return Result::success("Astronaut returned", $data);
    }

    //! Composite Resource
    public function getAstronautInfoByAstronautID(string $astronautID)
    {
        $result = $this->getAstronautByID($astronautID);
        if ($result->isSuccess()) {
            //*Have a astronaut, get the astronaut name, search by its name
            $astronautDateOfBirth = $result->getData()['data']["dateOfBirth"];
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://ll.thespacedevs.com/2.2.0/astronaut/?date_of_birth=$astronautDateOfBirth", [
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ]);

            //*If status is 200 process, else return error
            if ($response->getStatusCode() == 200) {
                $responseBody = json_decode($response->getBody(), true);
                $data['data'] = [
                    "astronaut" => $result->getData()["data"],
                    "astronautInfo" => $responseBody["results"]
                ];
                $data['status'] = 200;
                return Result::success("Return astronaut by astronaut ID", $data);
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }
}
