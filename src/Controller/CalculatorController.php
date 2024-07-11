<?php

namespace App\Controller;

use App\Exception\MathSignException;
use App\Service\CalculatorService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        try {
            if (!array_key_exists($mathSign, $this->mathSigns)) {
                throw new MathSignException($mathSign);
            }

            $result = $this->calculatorService->calculate($numberOne, $numberTwo, $this->mathSigns[$mathSign]);
        } catch (InvalidArgumentException|MathSignException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($result, Response::HTTP_OK);
    }
}