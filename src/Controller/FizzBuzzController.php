<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FizzBuzzController extends AbstractController
{
    private array $requestStatistics = [];

    #[Route('/fizzbuzz', name: 'fizzbuzz', methods: ['GET'])]
    public function fizzbuzz(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $int1 = $request->query->getInt('int1');
        $int2 = $request->query->getInt('int2');
        $limit = $request->query->getInt('limit');
        $str1 = $request->query->get('str1');
        $str2 = $request->query->get('str2');

        $constraints = new Assert\Collection([
            'int1' => new Assert\Required([new Assert\Type('integer')]),
            'int2' => new Assert\Required([new Assert\Type('integer')]),
            'limit' => new Assert\Required([new Assert\Type('integer')]),
            'str1' => new Assert\Required([new Assert\Type('string')]),
            'str2' => new Assert\Required([new Assert\Type('string')]),
        ]);

        $violations = $validator->validate([
            'int1' => $int1,
            'int2' => $int2,
            'limit' => $limit,
            'str1' => $str1,
            'str2' => $str2,
        ], $constraints);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], 400);
        }

        $result = [];
        for ($i = 1; $i <= $limit; $i++) {
            $output = '';
            if ($i % $int1 === 0) {
                $output .= $str1;
            }
            if ($i % $int2 === 0) {
                $output .= $str2;
            }
            $result[] = $output ?: (string) $i;
        }

        $requestKey = "int1=$int1&int2=$int2&limit=$limit&str1=$str1&str2=$str2";
        $this->requestStatistics[$requestKey] = ($this->requestStatistics[$requestKey] ?? 0) + 1;

        return new JsonResponse($result);
    }
}
