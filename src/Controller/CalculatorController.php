<?php

namespace App\Controller;

use App\Enum\Operation;
use App\Service\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CalculatorController extends AbstractController
{
    private Serializer $serializer;

    public function __construct(private readonly CalculatorService $calculatorService)
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

//    #[Route('/simple/calculator', name: 'calculator', methods: ['POST'])]
//    public function simpleCalcNew(#[MapRequestPayload]Expression $expression): JsonResponse
//    {
//        return new JsonResponse($expression->operandOne);
//    }

//    #[Route('/simple/calculator', name: 'calculator', methods: ['POST'])]
//    public function simpleCalcNew(Request $request): JsonResponse
//    {
//        $payLoad = json_decode($request->getContent(), true);
//        $operandOne = $payLoad['operandOne'] ?? '';
//        $mathSign = $payLoad['operation'] ?? '';
//        $sign = Operation::tryFrom($mathSign);
//
//        if (null === $sign) {
//            return new JsonResponse('Invalid sign', Response::HTTP_BAD_REQUEST);
//        }
//        // [] === $arr => how to check the array is empty;
//
//        return new JsonResponse($operandOne);
//    }

    #[Route('/simple/calculator', name: 'calculator', methods: ['POST'])]
    public function simpleCalcNew(Request $request): JsonResponse
    {
        $payLoad = json_decode($request->getContent(), true);
        $mathSign = $payLoad['operation'] ?? '';
        $sign = Operation::tryFrom($mathSign);

        if (null === $sign) {
            return new JsonResponse('Invalid sign', Response::HTTP_BAD_REQUEST);
        }
        // [] === $arr => how to check the array is empty;

        $result = $this->calculatorService->calculate($payLoad['operandOne'], $payLoad['operandTwo'], $sign);

        return new JsonResponse($this->serializer->serialize($result, 'json'), Response::HTTP_OK);
    }
}