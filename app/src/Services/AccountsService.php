<?php

namespace App\Services;

use App\Core\Result;
use App\Models\AccountsModel;
use App\Models\RocketsModel;
use App\Models\SpaceCompaniesModel;
use App\Validation\Validator;

class AccountsService
{
    public function __construct(private AccountsModel $accountsModel)
    {
        $this->accountsModel = $accountsModel;
    }

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
