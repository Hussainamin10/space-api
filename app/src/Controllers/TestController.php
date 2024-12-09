<?php

namespace App\Controllers;

use App\Core\PDOService;
use App\Models\TestModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * TestController handles the test route and demonstrates the usage of the TestModel.
 */
class TestController extends BaseController
{

        /**
     * Constructor initializes the TestModel instance.
     *
     * @param TestModel $testModel The instance of the TestModel to be injected.
     */
    public function __construct(private TestModel $testModel) {}

     /**
     * Handles the test route.
     * This method calls the `sayHello()` method of the TestModel and outputs the result.
     *
     * @param Request  $request  The incoming request.
     * @param Response $response The outgoing response.
     *
     * @return Response The response object.
     */
    public function handleTest(Request $request, Response $response): Response
    {
        dd($this->testModel->sayHello());

        return $response;
    }
}
