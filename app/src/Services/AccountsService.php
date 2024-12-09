<?php

namespace App\Services;

use App\Core\Result;
use App\Models\AccountsModel;
use App\Models\RocketsModel;
use App\Models\SpaceCompaniesModel;
use App\Validation\Validator;

/**
 * Class AccountsService
 *
 * This service class handles the business logic related to user accounts.
 * It provides methods for creating an account, validating account information,
 * and retrieving an account based on email and password.
 *
 * @package App\Services
 */
class AccountsService
{

    /**
     * AccountsService constructor.
     *
     * Initializes the service with the provided AccountsModel instance.
     *
     * @param AccountsModel $accountsModel The model responsible for database interactions related to accounts.
     */
    public function __construct(private AccountsModel $accountsModel)
    {
        $this->accountsModel = $accountsModel;
    }


    /**
     * Creates a new user account.
     *
     * This method validates the provided account data, checks for uniqueness of the email,
     * hashes the password, and then creates the account in the database. If any validation fails,
     * it returns an error result.
     *
     * @param array $newAccount An associative array containing the new account details.
     * 
     * @return Result A Result object representing the outcome of the account creation process.
     */
    public function createAccount(array $newAccount): Result
    {
        $data = [];
        //*Validate Data Passed
        $validator = new Validator($newAccount);
        $validator->rules([
            'required' => [
                'first_name',
                'last_name',
                'email',
                'password',
                'role',
            ],
            'in' => [
                ['role', ['Admin', 'General', 'admin', 'general']]
            ],
            'lengthMin' => [
                ['password', 8],
            ],
            'email' => [
                ['email']
            ]
        ]);

        //*If Invalid Return Fail result
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided value(s) is(are) not valid", $data);
        }

        //*Email Must be Unique
        $account = $this->accountsModel->getAccountByEmail($newAccount['email']);
        if ($account) {
            $data['data'] = $newAccount['email'];
            $data['status'] = 400;
            return Result::fail("There exists an account linked to this email, please login using it", $data);
        }

        $newAccount['password'] = password_hash($newAccount['password'], PASSWORD_DEFAULT);
        $id = $this->accountsModel->createAccount($newAccount);
        $account = $this->accountsModel->getAccountByEmail($newAccount['email']);
        unset($account['user_id']);
        unset($account['password']);
        $data['data'] = $account;
        $data['status'] = 201;
        return Result::success("Account Created", $data);
    }

    /**
     * Retrieves an account based on the provided email and password.
     *
     * This method validates the provided email and password, checks if an account exists for the given email,
     * and verifies the password. If any validation fails or the account does not exist, an error result is returned.
     *
     * @param array $account An associative array containing the email and password.
     *
     * @return Result A Result object representing the outcome of the account retrieval process.
     */

    public function getAccountByEmailPassword(array $account): Result
    {
        $validator = new Validator($account);
        $validator->rules([
            'required' => [
                'email',
                'password',
            ],
            'lengthMin' => [
                ['password', 8],
            ],
            'email' => [
                ['email']
            ]
        ]);

        //*If provide email is not valid
        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return Result::fail("Provided email is not valid", $data);
        }
        $given_password = $account['password'];
        $account = $this->accountsModel->getAccountByEmail($account['email']);
        //*IF rocket doesn't exist
        if (!$account) {
            $data['data'] = "";
            $data['status'] = 404;
            return Result::fail("No account found", $data);
        }
        if (!password_verify($given_password, $account['password'])) {
            $data['data'] = "";
            $data['status'] = 403;
            return Result::fail("Wrong user info", $data);
        }
        unset($account['user_id']);
        unset($account['password']);
        $data['data'] = $account;
        $data['status'] = 200;
        return Result::success("Account returned", $data);
    }
}
