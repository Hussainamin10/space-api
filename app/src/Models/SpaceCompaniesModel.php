<?php

namespace App\Models;

use App\Core\PDOService;


/**
 * Class SpaceCompaniesModel
 *
 * This class handles CRUD operations and data retrieval for the `spacecompany` table in the database.
 * It provides filtering, sorting, and pagination functionalities, as well as methods to fetch related data.
 */
class SpaceCompaniesModel extends BaseModel
{

    /**
     * @var string The name of the table this model interacts with.
     */
    private string $table_name = "spacecompany";

    /**
     * SpaceCompaniesModel constructor.
     *
     * @param PDOService $dbo The database connection service.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Retrieves space companies based on specified filters and sorting parameters.
     *
     * @param array $filter_params An associative array of filters for querying the space companies.
     *                             Supported filters include:
     *                             - companyName
     *                             - minFoundedDate, maxFoundedDate
     *                             - founder
     *                             - location
     *                             - minTotalNumOfMissions, maxTotalNumOfMissions
     *                             - minMissionSuccessRate, maxMissionSuccessRate
     *                             - minAnnualRevenue, maxAnnualRevenue
     *                             - minNumberOfEmployees, maxNumberOfEmployees
     *                             - sort_by, order (for sorting results)
     * @return array The filtered, sorted, and paginated list of space companies.
     */
    //! Get spaceCompanies
    public function getSpaceCompanies(array $filter_params = []): array
    {
        //! Filters
        $named_params_values = [];
        $query = "SELECT * FROM {$this->table_name} WHERE 1 ";

        // //! companyName
        if (isset($filter_params['companyName'])) {
            $query .= " AND companyName LIKE CONCAT(:companyName,'%') ";
            $named_params_values['companyName'] = $filter_params['companyName'];
        }

        //! foundedDate
        //min
        if (isset($filter_params['minFoundedDate'])) {
            $query .= " AND foundedDate >= :minFoundedDate";
            $named_params_values['minFoundedDate'] = $filter_params['minFoundedDate'];
        }
        //max
        if (isset($filter_params['maxFoundedDate'])) {
            $query .= " AND foundedDate <= :maxFoundedDate";
            $named_params_values['maxFoundedDate'] = $filter_params['maxFoundedDate'];
        }

        //! founder
        if (isset($filter_params['founder'])) {
            $query .= " AND founder LIKE CONCAT(:founder,'%')";
            $named_params_values['founder'] = $filter_params['founder'];
        }

        //! location
        if (isset($filter_params['location'])) {
            $query .= " AND location LIKE CONCAT(:location,'%')";
            $named_params_values['location'] = $filter_params['location'];
        }


        //! totalNumOfMissions
        //min
        if (isset($filter_params['minTotalNumOfMissions'])) {
            $query .= " AND totalNumOfMissions >= :minTotalNumOfMissions";
            $named_params_values['minTotalNumOfMissions'] = $filter_params['minTotalNumOfMissions'];
        }
        //max
        if (isset($filter_params['maxTotalNumOfMissions'])) {
            $query .= " AND totalNumOfMissions <= :maxTotalNumOfMissions";
            $named_params_values['maxTotalNumOfMissions'] = $filter_params['maxTotalNumOfMissions'];
        }

        //! missionSuccessRate
        //min
        if (isset($filter_params['minMissionSuccessRate'])) {
            $query .= " AND missionSuccessRate >= :minMissionSuccessRate";
            $named_params_values['minMissionSuccessRate'] = $filter_params['minMissionSuccessRate'];
        }
        //max
        if (isset($filter_params['maxMissionSuccessRate'])) {
            $query .= " AND missionSuccessRate <= :maxMissionSuccessRate";
            $named_params_values['maxMissionSuccessRate'] = $filter_params['maxMissionSuccessRate'];
        }

        //! annualRevenue
        //min
        if (isset($filter_params['minAnnualRevenue'])) {
            $query .= " AND annualRevenue >= :minAnnualRevenue";
            $named_params_values['minAnnualRevenue'] = $filter_params['minAnnualRevenue'];
        }
        //max
        if (isset($filter_params['maxAnnualRevenue'])) {
            $query .= " AND annualRevenue <= :maxAnnualRevenue";
            $named_params_values['maxAnnualRevenue'] = $filter_params['maxAnnualRevenue'];
        }

        //! numberOfEmployees
        //min
        if (isset($filter_params['minNumberOfEmployees'])) {
            $query .= " AND numberOfEmployees >= :minNumberOfEmployees";
            $named_params_values['minNumberOfEmployees'] = $filter_params['minNumberOfEmployees'];
        }
        //max
        if (isset($filter_params['maxNumberOfEmployees'])) {
            $query .= " AND numberOfEmployees <= :maxNumberOfEmployees";
            $named_params_values['maxNumberOfEmployees'] = $filter_params['maxNumberOfEmployees'];
        }

        //! Sorting
        $sortBy = isset($filter_params['sort_by']) ?
            $filter_params['sort_by'] : 'companyName';

        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        $query .= " ORDER BY $sortBy $order";

        $spaceCompanies_info = $this->paginate($query, $named_params_values);
        return $spaceCompanies_info;
    }


    /**
     * Retrieves a specific space company by its name.
     *
     * @param string $companyName The name of the company to retrieve.
     * @return mixed The company information or null if not found.
     */
    //! Get a space company by name
    public function getCompanyByName(string $companyName): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE companyName = :companyName";

        $spaceCompanies_info = $this->fetchSingle($sql, ['companyName' => $companyName]);

        return $spaceCompanies_info;
    }


     /**
     * Retrieves rockets associated with a specific space company.
     *
     * @param string $companyName The name of the company whose rockets are to be fetched.
     * @return mixed An array containing company information and a list of its rockets.
     */
    //! Get rockets by companyName
    public function getRocketsByCompanyName(string $companyName): mixed
    {
        // 1) Fetch the company info
        $company = $this->getCompanyByName($companyName);

        // 2) Query to fetch rockets related to the company
        $query = <<<SQL
    SELECT r.* FROM rocket r
    JOIN spacecompany sc ON r.companyName = sc.companyName
    WHERE sc.companyName = :companyName
    SQL;

        // 3) Execute the query to fetch the rockets
        $rockets = $this->fetchAll($query, ['companyName' => $companyName]);

        // 4) Structure the response
        $result = [
            "company" => $company,
            "rockets" => $rockets
        ];

        return $result;
    }

    /**
     * Retrieves all space companies in the database.
     *
     * @return mixed An array of all space companies.
     */

    public function getAllCompanies(): mixed
    {
        $query = "SELECT * FROM {$this->table_name}";
        $companies = $this->fetchAll($query);
        return $companies;
    }
}
