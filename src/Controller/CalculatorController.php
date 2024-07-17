<?php

namespace App\Controller;

use App\Enum\Operation;
use App\Request\CalculatorPayloadRequest;
use App\Service\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CalculatorController extends AbstractController
{
    private Serializer $serializer;

    public function __construct(
        private readonly CalculatorService $calculatorService
    )
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    #[Route('/calc/{expr}', name: 'calc', methods: ['GET'])]
    public function simpleCalc(string $expr): JsonResponse
    {
        $result = '';
        eval('$result = $expr;');

        return new JsonResponse($result, Response::HTTP_OK);
    }

    #[Route('/simple/calculator', name: 'calculator', methods: ['POST'])]
    public function simpleCalcNew(#[MapRequestPayload] CalculatorPayloadRequest $calculatorPayloadRequest): JsonResponse
    {
        $result = $this->calculatorService->calculate($calculatorPayloadRequest);
        return new JsonResponse($result, Response::HTTP_OK);
    }
}