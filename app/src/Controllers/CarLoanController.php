<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * CarLoanController handles calculations and responses related to car loans.
 */
class CarLoanController extends BaseController
{

      /**
     * Constructor for the CarLoanController.
     * Calls the parent constructor to initialize the controller.
     */
    public function __construct()
    {
        parent::__construct();
    }

      /**
     * Handles the car loan calculation request.
     *
     * This method calculates the loan amount, monthly payment, total amount paid,
     * and total interest paid for a car loan based on the input parameters provided
     * in the request body.
     *
     * @param Request $request The incoming HTTP request containing the car loan details in the body.
     * @param Response $response The outgoing HTTP response to send back the calculation results.
     * @param array $uri_args Additional URI arguments (not used in this method).
     *
     * @return Response A JSON response containing:
     * - Loan Amount: The total loan amount after down payment and trade-in value deductions.
     * - Monthly Payment: The calculated monthly payment.
     * - Total Interest Paid: The total interest paid over the term of the loan.
     *
     * @example Input JSON Body:
     * {
     *     "priceOfCar": 30000,
     *     "downPayment": 5000,
     *     "tradeInValue": 2000,
     *     "salesTax": 8.5,
     *     "interestRate": 3.5,
     *     "loanTerm": 5
     * }
     * @example Response JSON:
     * {
     *     "Loan Amount": "23000.00",
     *     "Monthly Payment": "417.08",
     *     "Total Interest Paid": "1702.80"
     * }
     */
    public function handleCarLoan(Request $request, Response $response, array $uri_args): Response
    {
        $body = $request->getParsedBody();

        $priceOfCar = $body['priceOfCar'];
        $downPayment = $body['downPayment'];
        $tradeInValue = $body['tradeInValue'];
        $salesTax = $body['salesTax'] / 100;
        $interestRate = $body['interestRate'] / 100;
        $loanTerm = $body['loanTerm'];

        $loanAmount = $priceOfCar - $downPayment - $tradeInValue;

        $loanAmount += $tradeInValue * $salesTax;

        // Monthly interest rate
        $monthlyInterestRate = $interestRate / 12;


        if ($monthlyInterestRate == 0) {
            // If interest rate is 0, simply divide the loan amount by the term
            $monthlyPayment = $loanAmount / ($loanTerm * 12);
        } else {
            // Standard formula for monthly payment
            $monthlyPayment = $loanAmount * ($monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$loanTerm * 12));
        }

        // Calculate total amount paid over the term
        $totalPaid = $monthlyPayment * $loanTerm * 12;

        // Calculate total interest paid
        $totalInterestPaid = $totalPaid - $loanAmount;

        // Return results as JSON
        return $this->renderJson(
            $response,
            [
                "Loan Amount" => number_format($loanAmount, 2),
                "Monthly Payment" => number_format($monthlyPayment, 2),
                "Total Interest Paid" => number_format($totalInterestPaid, 2)
            ]
        );
    }
}
