<?php

namespace App\Controller;

use App\UseCase\ExecutePaymentUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController
{
    /**
     * Get battle by token
     *
     * @Route("/execute-payment", methods={"POST"})
     *
     * @param ExecutePaymentUseCase $useCase
     * @param Request               $request
     *
     * @return JsonResponse
     */
    public function executePayment(ExecutePaymentUseCase $useCase, Request $request)
    {
        return new JsonResponse(
            $useCase->execute($request->request->all())
        );
    }
}
