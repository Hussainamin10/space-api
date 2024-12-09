<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class AccountsModel
 * 
 * This class handles account-related operations, including retrieving account details and creating new accounts.
 */

class AccountsModel extends BaseModel
{

    /**
     * @var string The name of the table containing user account information.
     */
    private string $table_name = "ws_users";

     /**
     * AccountsModel constructor.
     * 
     * @param PDOService $dbo The database service object used for database interactions.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Retrieves account information by email address.
     * 
     * @param string $email The email address of the account to retrieve.
     * 
     * @return mixed The account information, or `null` if no account is found.
     */
    public function getAccountByEmail(string $email): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE email = :email";
        $account_info = $this->fetchSingle(
            $sql,
            [
                "email" => $email
            ]
        );
        return $account_info;
    }

    /**
     * Retrieves the user ID associated with the given email address.
     * 
     * @param string $email The email address of the account to retrieve the user ID for.
     * 
     * @return mixed The user ID, or `null` if no account is found.
     */

    public function getUserIDByEmail(string $email): mixed
    {
        $sql = "SELECT user_id FROM {$this->table_name} WHERE email = :email";
        $account_info = $this->fetchSingle(
            $sql,
            [
                "email" => $email
            ]
        );
        return $account_info;
    }

    /**
     * Creates a new account with the provided account details.
     * 
     * @param array $newAccount The data for the new account.
     * 
     * @return mixed The ID of the newly created account.
     */

    public function createAccount(array $newAccount): mixed
    {
        $newID = $this->insert($this->table_name, $newAccount);
        return $newID;
    }
}
