<?php

namespace App\Controllers;


use App\Validation\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ZakatController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function  handleZakat(Request $request, Response $response, array $uri_args): Response
    {

        $body = $request->getParsedBody();
        //dd($body);

        $validator = new Validator($body);
        $validator->rules([
            'required' => [
                'currentRateOfGold',
                'cashInBank',
                'cashInHand',
                'loansGivenOut',
                'cashForFuture',
                'investments',
                'loanTaken',
                'givenWages',
                'payableBills',
                'valuableGoods'
            ],
            'numeric' => [
                'currentRateOfGold',
                'cashInBank',
                'cashInHand',
                'loansGivenOut',
                'cashForFuture',
                'investments',
                'loanTaken',
                'givenWages',
                'payableBills',
                'valuableGoods'
            ]
        ]);

        if (!$validator->validate()) {
            $data['data'] = $validator->errorsToString();
            $data['status'] = 400;
            return $this->renderJson(
                $response,
                [
                    "data" => $data,
                    "Message" => "invalid values provided"
                ],
                400
            );
        }
        $currentRateOfGold = $body['currentRateOfGold'];
        $cashInBank = $body['cashInBank'];
        $cashInHand = $body['cashInHand'];
        $loansGivenOut = $body['loansGivenOut'];
        $cashForFuture = $body['cashForFuture'];
        $investments = $body['investments'];
        $loanTaken = $body['loanTaken'];
        $givenWages = $body['givenWages'];
        $payableBills = $body['payableBills'];
        $valuableGoods = $body['valuableGoods'];



        $threshold = $currentRateOfGold * 7.5;

        $cash = $cashInBank + $cashInHand + $loansGivenOut + $cashForFuture + $investments + $valuableGoods;

        $liability = $loanTaken + $givenWages + $payableBills;

        $netWorth = $cash - $liability;

        if ($netWorth < $threshold) {
            return $this->renderJson(
                $response,
                [
                    "Eligible" => "You're not eligible to pay zakat because your income is less than the nisab (7.5 * the rate of gold)",
                ]
            );
        } else {
            $zakat = round(0.025 * $netWorth, 2);
        }


        return $this->renderJson(
            $response,
            [
                "Eligible" => "You're eligible to pay zakat",
                "Net Worth" => $netWorth,
                "Zakat Payable" => $zakat
            ]
        );
    }
}
