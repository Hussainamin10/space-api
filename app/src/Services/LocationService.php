<?php

namespace App\Services;

use App\Core\Result;
use App\Models\LocationsModel;
use App\Models\SpaceCompaniesModel;
use App\Validation\Validator;


/**
 * Service class for managing locations.
 * Handles creation, deletion, and update of location data.
 */
class LocationService
{

    /**
     * LocationService constructor.
     * 
     * @param LocationsModel $locationsModel The model to interact with location data.
     */
    public function __construct(private LocationsModel $locationsModel)
    {
        $this->locationsModel = $locationsModel;
    }


    /**
     * Creates a new location.
     *
     * Validates input data, checks if location name is unique, and then stores the new location.
     * 
     * @param array $newLocation The new location data.
     * 
     * @return Result The result of the operation, including success or failure message and status code.
     */
    public function createLocation(array $newLocation): Result
    {
        $data = [];
        //*Validate Data Passed
        $validator = new Validator($newLocation);

        //*Rocket Name Must be Unique
        $locations = $this->locationsModel->getAllLocations();
        $locationNames = [];
        foreach ($locations as $location) {
            $locationNames[] = $location['name'];
        }

        $validator->rules([
            'required' => [
                'name',
                'countryCode',
                'description',
                'mapImage',
                'timezone',
                'launchCount',
                'landingCount',
                'url'
            ],
            'integer' => ['launchCount', 'landingCount', 'id'],
            'notIn' => [['name', $locationNames]],
            'lengthBetween' => [
                ['countryCode', 2, 3]
            ],
            'min' => [
                ['launchCount', 0],
                ['landingCount', 0]
            ],
            'regex' => [
                ['timezone', '/^[A-Za-z]+\/[A-Za-z_]+$/']
            ]


        ]);

        //*If Invalid Return Fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        $id = $this->locationsModel->createLocation($newLocation);
        $data['data'] = $this->locationsModel->getLocationByID($id);
        $data['status'] = 201;
        return Result::success("Location Added", $data);
    }

    /**
     * Deletes a location by ID.
     *
     * Validates the ID, checks if the location exists, and then deletes it.
     * 
     * @param string $id The ID of the location to delete.
     * 
     * @return Result The result of the deletion, including success or failure message and status code.
     */

    //*Location Delete
    public function deleteLocation(string $id): Result
    {
        $validator = new Validator(['ID' => $id]);
        $validator->rule('integer', 'ID');
        $data = [];

        //*If Id Provided is not an integer
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided ID is not Valid", $data);
        }

        //*Delete Location
        $delete = $this->locationsModel->deleteLocation($id);

        //*If No Item Deleted
        if ($delete == 0) {
            $data['data'] = $delete;
            $data['status'] = 404;
            return Result::fail("No location found.", $data);
        }

        //*Item Deleted
        $data['data'] = $delete;
        $data['status'] = 200;
        return Result::success("Location Deleted", $data);
    }


    /**
     * Updates an existing location.
     *
     * Validates the input data, checks if the location exists, and then updates it.
     * 
     * @param array $newLocation The updated location data.
     * 
     * @return Result The result of the operation, including success or failure message and status code.
     */
    public function updateLocation(array $newLocation): Result
    {
        $data = [];

        //* Validate if the fields to be updated exist
        $updateFields = [
            'id',
            'name',
            'countryCode',
            'description',
            'mapImage',
            'timezone',
            'launchCount',
            'landingCount',
            'numberOfStages',
            'url'
        ];

        foreach ($newLocation as $key => $value) {
            if (!in_array($key, $updateFields)) {
                $data['data'] = "Invalid Field: " . $key;
                $data['status'] = 400;
                return Result::fail("No existing field to update", $data);
            }
        }

        $validator = new Validator($newLocation);
        //Country Name Must be Unique
        $locations = $this->locationsModel->getAllLocations();
        $locationNames = [];
        foreach ($locations as $location) {
            $locationNames[] = $location['name'];
        }

        $validator->rules([
            'notIn' => [['name', $locationNames]],
            'integer' => ['launchCount', 'landingCount', 'id'],
            'lengthBetween' => [
                ['countryCode', 2, 3]
            ],
            'min' => [
                ['launchCount', 0],
                ['landingCount', 0]
            ],
            'required' => ['id'],
            'regex' => [
                ['timezone', '/^[A-Za-z]+\/[A-Za-z_]+$/']
            ]


        ]);

        //*If Invalid Return Fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        //* Check if location exist
        $location = $this->locationsModel->getLocationByID($newLocation['id']);
        if (!$location) {
            $data['data'] = "ID provided: " . $newLocation['id'];
            $data['status'] = 404;
            return Result::fail("Location does not exist", $data);
        }

        $locationId = $newLocation['id'];
        unset($newLocation['id']);

        if (!$newLocation) {
            $data['data'] = "";
            $data['status'] = 400;
            return Result::fail("Please provide at least one valid field to update", $data);
        }


        $update = $this->locationsModel->updateLocation($locationId, $newLocation);
        //*Item Deleted
        $data['data'] = $update;
        $data['status'] = 200;
        return Result::success("Location Updated", $data);
    }
}
