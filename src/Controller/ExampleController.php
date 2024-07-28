<?php

namespace App\Controller;

use App\Form\PurchaseType;
use App\Factory\PaymentServiceFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    private PaymentServiceFactory $paymentServiceFactory;

    public function __construct(PaymentServiceFactory $paymentServiceFactory)
    {
        $this->paymentServiceFactory = $paymentServiceFactory;
    }

    /**
     * @Route("/app/example/{system}", name="app_example", methods={"POST"})
     */
    final public function example(Request $request, string $system): JsonResponse
    {
        $form = $this->createForm(PurchaseType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse([
                'error' => 'Invalid input data',
                'details' => $form->getErrors(true, false)->__toString()
            ], 400);
        }

        $params = $form->getData();

        try {
            $service = $this->paymentServiceFactory->getService($system);
            $response = $service->makePurchase($params);

            return new JsonResponse($this->unifyResponse($response));
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    private function unifyResponse(array $response): array
    {
        // Unify the response format
        return [
            'transaction_id' => $response['id'] ?? $response['transaction_id'],
            'amount' => $response['amount'],
            'currency' => $response['currency'],
            'card_number' => $response['card']['number'],
            'card_bin' => substr($response['card']['number'], 0, 6),
            'card_exp_month' => $response['card']['expiry_month'],
            'card_exp_year' => $response['card']['expiry_year'],
            'card_cvv' => $response['card']['cvv'],
            'date_of_creating' => $response['created'],
        ];
    }
}
