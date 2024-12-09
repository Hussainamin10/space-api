<?php

namespace App\Services;

use App\Core\Result;
use App\Models\RocketsModel;
use App\Models\SpaceCompaniesModel;
use App\Validation\Validator;

/**
 * Service class for handling rocket-related operations, including:
 * - Adding, updating, deleting, and retrieving rocket information.
 * - Validating rocket data based on company names and rocket name uniqueness.
 * - Calculating lift force for rockets based on mass and gravity.
 */
class RocketsService
{
    /**
     * RocketsService constructor.
     *
     * @param RocketsModel $rocketsModel Model to interact with rockets data.
     * @param SpaceCompaniesModel $spaceCompaniesModel Model to interact with space companies data.
     */
    public function __construct(private RocketsModel $rocketsModel, private SpaceCompaniesModel $spaceCompaniesModel)
    {
        $this->rocketsModel = $rocketsModel;
        $this->spaceCompaniesModel = $spaceCompaniesModel;
    }


    /**
     * Creates a new rocket with the provided data.
     * Validates rocket data before insertion into the database.
     *
     * @param array $newRocket Data for the new rocket.
     * @return Result A result object containing the status and any relevant data.
     */
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

    /**
     * Deletes a rocket by its ID.
     * Validates the rocket ID before deletion.
     *
     * @param string $rocketID The ID of the rocket to be deleted.
     * @return Result A result object containing the status of the deletion.
     */
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

     /**
     * Updates an existing rocket with the provided data.
     * Validates rocket data before updating the database.
     *
     * @param array $newRocket Data for updating the rocket.
     * @return Result A result object containing the status and any relevant data.
     */

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


    /**
     * Retrieves a rocket by its ID.
     * Validates the rocket ID before retrieval.
     *
     * @param string $rocketID The ID of the rocket to be retrieved.
     * @return Result A result object containing the status and the retrieved rocket data.
     */
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

    /**
     * Retrieves missions associated with a rocket by its ID.
     *
     * @param string $rocketID The ID of the rocket whose missions are to be retrieved.
     * @return Result A result object containing the status and the associated missions.
     */

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


    /**
     * Retrieves launches associated with a rocket by its ID.
     *
     * @param string $rocketID The ID of the rocket whose launches are to be retrieved.
     * @return Result A result object containing the status and the associated launches.
     */
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

    /**
     * Calculates the lift force based on mass and gravity.
     * Converts mass from pounds to kilograms if necessary.
     *
     * @param array $inputs The inputs for calculating the lift force, including mass, mass unit, and gravity.
     * @return Result A result object containing the status and the calculated lift force.
     */
    public function getLiftCalculation(array $inputs): Result
    {
        $validator = new Validator($inputs);
        $validator->rules([
            'required' => [
                'mass',
                'massUnit',
                'gravity',
            ],
            'numeric' => [
                'mass',
                'gravity',
            ],
            'min' => [
                ['mass', 0],
                ['gravity', 0],
            ],
            'in' => [
                ['massUnit', ['lb', 'kg']]
            ],
        ]);

        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }
        //*Convert to kg if in lb
        if ($inputs['massUnit'] == 'lb') {
            $inputs['mass'] = $inputs['mass'] * 0.45359237;
        }

        $lift = round($inputs['mass'] * $inputs['gravity'], 2);
        $data['data'] = "Lift force must be larger than " . $lift . " N";
        $data['status'] = 200;
        return Result::success("Lift calculation returned", $data);
    }
}
