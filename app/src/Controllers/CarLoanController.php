<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class CarLoanController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

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
