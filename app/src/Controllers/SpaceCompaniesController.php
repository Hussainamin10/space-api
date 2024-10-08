<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\AstronautsModel;
use App\Models\SpaceCompaniesModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class SpaceCompaniesController extends BaseController
{
    public function __construct(private SpaceCompaniesModel $spaceCompanies_model)
    {
        parent::__construct();
    }

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

    //! Get rockets by companyName
    public function handleRocketsByCompanyName(Request $request, Response $response, array $uri_args): Response
    {
        // Extract the company name from the URI arguments
        $companyName = $uri_args["companyName"];

        // Fetch the rockets by company name using the model
        $results = $this->spaceCompanies_model->getRocketsByCompanyName($companyName);

        // Return the results as a JSON response
        return $this->renderJson($response, $results);
    }
}
