<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\AstronautsModel;
use App\Models\SpaceCompaniesModel;
use App\Validation\Validator;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

/**
 * SpaceCompaniesController handles HTTP requests related to space companies, such as retrieving company information,
 * getting rockets by company, and applying filters for pagination and sorting.
 */
class SpaceCompaniesController extends BaseController
{

     /**
     * Constructor initializes the SpaceCompaniesModel instance.
     *
     * @param SpaceCompaniesModel $spaceCompanies_model
     */
    public function __construct(private SpaceCompaniesModel $spaceCompanies_model)
    {
        parent::__construct();
    }

       /**
     * Handles the GET request to retrieve a list of space companies with optional filters for pagination.
     *
     * @param Request  $request  The incoming request.
     * @param Response $response The outgoing response.
     *
     * @return Response The JSON response containing the space companies data.
     */
    //! Get spaceCompanies
    public function handleGetSpaceCompanies(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();

        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->spaceCompanies_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }

        $spaceCompanies = $this->spaceCompanies_model->getSpaceCompanies(
            $filter_params
        );
        return $this->renderJson($response, $spaceCompanies);
    }

     /**
     * Handles the GET request to retrieve a space company by its name.
     *
     * @param Request  $request     The incoming request.
     * @param Response $response    The outgoing response.
     * @param array    $uri_args    The URI arguments (companyName).
     *
     * @return Response The JSON response containing the space company data.
     *
     * @throws HttpNotFoundException If no company is found with the provided name.
     */
    //! Get spaceCompany by Name
    public function handleGetCompanyByName(Request $request, Response $response, array $uri_args): Response
    {
        //* Step 1) Receive the received company name

        //* Step 2) Validate the company name
        if (!isset($uri_args['companyName'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No company name provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        $companyName = $uri_args["companyName"];

        //* Step 3) If valid, fetch the company's info from the DB
        $company = $this->spaceCompanies_model->getCompanyByName($companyName);

        if ($company === false) {
            throw new HttpNotFoundException($request, "No matching company found");
        }

        //* Step 4) Prepare valid JSON response
        return $this->renderJson($response, $company);
    }


       /**
     * Handles the GET request to retrieve rockets associated with a company by its name.
     *
     * @param Request  $request     The incoming request.
     * @param Response $response    The outgoing response.
     * @param array    $uri_args    The URI arguments (companyName).
     *
     * @return Response The JSON response containing the rockets data.
     *
     * @throws HttpInvalidInputsException If the company name is invalid.
     * @throws HttpNotFoundException If no rockets are found for the specified company.
     */
    //! Get rockets by companyName
    public function handleRocketsByCompanyName(Request $request, Response $response, array $uri_args): Response
    {
        // Extract the company name from the URI arguments
        $companyName = $uri_args["companyName"];
        $validator = new Validator(['Name' => $companyName]);

        $validator->rule('string', 'Name');

        //If Name provided is not a string
        if (!$validator->validate()) {
            throw new HttpInvalidInputsException($request, "Invalid company name provided");
        }

        // Fetch the rockets by company name using the model
        $results = $this->spaceCompanies_model->getRocketsByCompanyName($companyName);

        //If company doesn't exist
        if (!$results['company']) {
            throw new HttpNotFoundException($request, "No matching companies found");
        }

        // Return the results as a JSON response
        return $this->renderJson($response, $results);
    }
}
