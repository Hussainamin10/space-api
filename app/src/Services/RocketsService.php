<?php

namespace App\Services;

use App\Core\Result;
use App\Models\RocketsModel;
use App\Models\SpaceCompaniesModel;
use App\Validation\Validator;

class RocketsService
{
    public function __construct(private RocketsModel $rocketsModel, private SpaceCompaniesModel $spaceCompaniesModel)
    {
        $this->rocketsModel = $rocketsModel;
        $this->spaceCompaniesModel = $spaceCompaniesModel;
    }

    public function createRocket(array $newRocket): Result
    {
        $data = [];
        //*Company name must exist in Space Company Table
        //*Get All names of space company
        $spaceCompanies = $this->spaceCompaniesModel->getAllCompanies();
        $companyNames = [];
        foreach ($spaceCompanies as $spaceCompany) {
            $companyNames[] = $spaceCompany['companyName'];
        }
        //*Rocket Name Must be Unique
        $rockets = $this->rocketsModel->getAllRockets();
        $rocketNames = [];
        foreach ($rockets as $rocket) {
            $rocketNames[] = $rocket['rocketName'];
        }
        //*Validate Data Passed
        $validator = new Validator($newRocket);
        $validator->rules([
            'required' => [
                'rocketName',
                'companyName',
                'rocketHeight',
                'status',
                'liftOfThrust',
                'rocketWeight',
                'numberOfStages',
                'launchCost'
            ],
            'numeric' => [
                'rocketHeight',
                'liftOfThrust',
                'rocketWeight',
                'launchCost'
            ],
            'in' => [
                ['companyName', $companyNames],
                ['status', ['Active', 'Retired', 'active', 'retired']]
            ],
            'min' => [
                ['launchCost', 0],
                ['rocketHeight', 0],
                ['liftOfThrust', 0],
                ['rocketWeight', 0],
                ['numberOfStages', 0]
            ],
            'notIn' => [['rocketName', $rocketNames]],
            'integer' => ['numberOfStages']
        ]);

        //*If Invalid Return Fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        //*Round the numerical value to 2 decimal before adding
        $newRocket["rocketHeight"] = round($newRocket["rocketHeight"], 2);
        $newRocket["liftOfThrust"] = round($newRocket["liftOfThrust"], 2);
        $newRocket["rocketWeight"] = round($newRocket["rocketWeight"], 2);
        $newRocket["launchCost"] = round($newRocket["launchCost"], 2);

        $id = $this->rocketsModel->createRocket($newRocket);
        $data['data'] = $this->rocketsModel->getRocketByID($id);
        $data['status'] = 201;
        return Result::success("Rocket Added", $data);
    }

    //*Rocket Delete
    public function deleteRocket(string $rocketID): Result
    {
        $validator = new Validator(['ID' => $rocketID]);
        $validator->rule('integer', 'ID');
        $data = [];

        //*If Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not Valid", $data);
        }

        //*Delete Rocket
        $delete = $this->rocketsModel->deleteRocket($rocketID);

        //*If No Item Deleted
        if ($delete == 0) {
            $data['data'] = $delete;
            $data['status'] = 404;
            return Result::fail("No rocket found", $data);
        }

        //*Item Deleted
        $data['data'] = $delete;
        $data['status'] = 200;
        return Result::success("Rocket Deleted", $data);
    }

    public function updateRocket(array $newRocket): Result
    {
        $data = [];

        //* Validate if the fields to be updated exist
        $updateFields = [
            'rocketID',
            'rocketName',
            'companyName',
            'rocketHeight',
            'status',
            'liftOfThrust',
            'rocketWeight',
            'numberOfStages',
            'launchCost'
        ];
        foreach ($newRocket as $key => $value) {
            if (!in_array($key, $updateFields)) {
                $data['data'] = "Invalid Field: " . $key;
                $data['status'] = 400;
                return Result::fail("No existing field to update", $data);
            }
        }

        $validator = new Validator($newRocket);
        //Company name must exist in Space Company Table
        //Get All names of space company
        $spaceCompanies = $this->spaceCompaniesModel->getAllCompanies();
        $companyNames = [];
        foreach ($spaceCompanies as $spaceCompany) {
            $companyNames[] = $spaceCompany['companyName'];
        }
        //Rocket Name Must be Unique
        $rockets = $this->rocketsModel->getAllRockets();
        $rocketNames = [];
        foreach ($rockets as $rocket) {
            $rocketNames[] = $rocket['rocketName'];
        }
        $validator->rules([
            'numeric' => [
                'rocketHeight',
                'liftOfThrust',
                'rocketWeight',
                'launchCost'
            ],
            'in' => [
                ['companyName', $companyNames],
                ['status', ['Active', 'Retired', 'active', 'retired']]
            ],
            'min' => [
                ['launchCost', 0],
                ['rocketHeight', 0],
                ['liftOfThrust', 0],
                ['rocketWeight', 0],
                ['numberOfStages', 0]
            ],
            'notIn' => [['rocketName', $rocketNames]],
            'integer' => ['numberOfStages', 'rocketID'],
            'required' => ['rocketID']
        ]);
        //*If Invalid Return Fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        //* Check if Rocket exist
        $rocket = $this->rocketsModel->getRocketByID($newRocket['rocketID']);
        if (!$rocket) {
            $data['data'] = "ID provided: " . $newRocket['rocketID'];
            $data['status'] = 404;
            return Result::fail("Rocket does not exist", $data);
        }
        $rocketID = $newRocket['rocketID'];
        unset($newRocket['rocketID']);

        if (!$newRocket) {
            $data['data'] = "";
            $data['status'] = 400;
            return Result::fail("Please provide at least one valid field to update", $data);
        }


        $update = $this->rocketsModel->updateRocket($rocketID, $newRocket);
        //*Item Deleted
        $data['data'] = $update;
        $data['status'] = 200;
        return Result::success("Rocket Updated", $data);
    }

    public function getRocketByID(string $rocketID): Result
    {
        $validator = new Validator(['ID' => $rocketID]);
        $validator->rule('integer', 'ID');

        //*IF Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not valid", $data);
        }

        $rocket = $this->rocketsModel->getRocketByID($rocketID);
        //*IF rocket doesn't exist
        if (!$rocket) {
            $data['data'] = "";
            $data['status'] = 404;
            return Result::fail("No rocket found", $data);
        }

        $data['data'] = $rocket;
        $data['status'] = 200;
        return Result::success("Rocket returned", $data);
    }

    public function getMissionsByRocketID(string $rocketID): Result
    {
        $result = $this->getRocketByID($rocketID);
        if ($result->isSuccess()) {
            $missions = $this->rocketsModel->getMissionsByRocketID($rocketID);
            $data['data'] = $missions;
            $data['status'] = 200;
            return Result::success("Rocket returned", $data);
        } else {
            return $result;
        }
    }

    public function getLaunchesByRocketID(string $rocketID)
    {
        $result = $this->getRocketByID($rocketID);
        if ($result->isSuccess()) {
            //*Have a rocket, get the rocket name, search by its name
            $rocketName = $result->getData()['data']["rocketName"];
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://lldev.thespacedevs.com/2.3.0/launches/?rocket__configuration__name=$rocketName", [
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ]);

            //*If status is 200 process, else return error
            if ($response->getStatusCode() == 200) {
                $responseBody = json_decode($response->getBody(), true);
                $data['data'] = [
                    "rocket" => $result->getData()["data"],
                    "launches" => $responseBody["results"]
                ];
                $data['status'] = 200;
                return Result::success("Return launches by rocket ID", $data);
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }
}
