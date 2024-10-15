<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AppSettings;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AboutController extends BaseController
{
    private const API_NAME = 'Planeto';

    private const API_VERSION = '1.0.0';

    public function handleAboutWebService(Request $request, Response $response): Response
    {
        $resources  = [
            'Rockets' => '/space-api/rockets',
            'Space Stations' => '/space-api/spacestations',
            'Locations' => '/space-api/locations',
            'RocketsSpaceMission' => '/space-api/rockets/{rocketID}/missions',
            'Space Companies' => '/space-api/spaceCompanies',
            'Astronauts' => '/space-api/astronauts',
            'SpaceCompaniesRockets' => '/spaceCompanies/{companyName}/rockets',
            'Planets' => '/space-api/planets',
            'Space Missions' => '/space-api/missions',
            'MissionsAstronauts' => '/space-api/missions/{mission_id}/astronauts',

        ];

        $data = array(
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'about' => 'Welcome! This i a Web service that provides information about space,planets, astronauts, missions, rockets, etc..',
            'authors' => 'Ali Ilyas, Amin Hussain, Gia Thien Bui',
            'resources' => $resources
        );

        return $this->renderJson($response, $data);
    }
}
