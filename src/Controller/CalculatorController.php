<?php

namespace App\Controller;

use App\Entity\Expression;
use App\Enum\Operation;
use App\Exception\MathSignException;
use App\Service\CalculatorService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CalculatorController extends AbstractController
{
    public array $mathSigns = [
        '+' => 'add',
        '-' => 'sub',
        '*' => 'mul',
        '/' => 'div',
    ];

    public function __construct(private readonly CalculatorService $calculatorService)
    {
    }

    #[Route('/calculator/{numberOne}/{numberTwo}', name: 'calculator', methods: ['GET'])]
    public function calc(int $numberOne, int $numberTwo, Request $request): JsonResponse
    {
        $mathSign = $request->get('mathSign') ?? '';
        //try {
            if (!array_key_exists($mathSign, $this->mathSigns)) {
                //throw new MathSignException($mathSign);
                return new JsonResponse('This sign is not valid', Response::HTTP_BAD_REQUEST);
            }

            $result = $this->calculatorService->calculate($numberOne, $numberTwo, $this->mathSigns[$mathSign]);
//        } catch (InvalidArgumentException|MathSignException $exception) {
//            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
//        }
        return new JsonResponse($result, Response::HTTP_OK);
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

    #[Route('/simple/calculator', name: 'calculator', methods: ['POST'])]
    public function simpleCalcNew(Request $request): JsonResponse
    {
        $payLoad = json_decode($request->getContent(), true);
        $operandOne = $payLoad['operandOne'] ?? '';
        $mathSign = $payLoad['operation'] ?? '';
        $sign = Operation::tryFrom($mathSign);

        if (null === $sign) {
            return new JsonResponse('Invalid sign', Response::HTTP_BAD_REQUEST);
        }
        // [] === $arr => how to check the array is empty;

        return new JsonResponse($operandOne);
    }
}