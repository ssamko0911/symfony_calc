<?php

namespace App\Controller;

use App\Service\CalculatorService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalculatorController extends AbstractController
{
    #[Route('/calculator/{numberOne}/{numberTwo}', name: 'calculator', methods: ['GET'])]
    public function calc(int $numberOne, int $numberTwo): JsonResponse
    {
        $calculator = new CalculatorService();
        try {
            $result = $calculator->calculate($numberOne, $numberTwo);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($result, Response::HTTP_OK);
    }
}