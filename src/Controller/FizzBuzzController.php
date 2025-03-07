<?php

namespace App\Controller;

use App\Repository\FizzBuzzStatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Controller managing the FizzBuzz functionality and related statistics.
 */
class FizzBuzzController extends AbstractController
{
    /**
     *
     */
    public function __construct(private readonly FizzBuzzStatsRepository $fizzBuzzStatsRepository)
    {
    }

    /**
     * Handles the FizzBuzz functionality by generating a sequence based on input parameters
     * and returning the result as a JSON response.
     * Accepts five parameters: three integers int1, int2 and limit, and two strings str1 and str2.
     * @param Request $request HTTP request object to retrieve query parameters.
     * @param ValidatorInterface $validator Validation service to enforce constraints on input data.
     * @return JsonResponse The generated FizzBuzz sequence as a JSON response or validation errors. A list of strings
     * with numbers from 1 to limit, where: all multiples of int1 are replaced by str1, all multiples of int2 are
     * replaced by str2, all multiples of int1 and int2 are replaced by str1str2.
     */
    #[Route('/fizzbuzz', name: 'fizzbuzz', methods: ['GET'])]
    public function fizzbuzz(Request            $request,
                             ValidatorInterface $validator): JsonResponse
    {
        $int1 = $request->query->getInt('int1'); // The first divisor for the FizzBuzz algorithm
        $int2 = $request->query->getInt('int2'); // The second divisor for the FizzBuzz algorithm
        $limite = $request->query->getInt('limit'); // The upper limit of the numbers to iterate through in the FizzBuzz algorithm
        $str1 = $request->query->get('str1'); // The string associated with the first divisor
        $str2 = $request->query->get('str2'); // The string associated with the second divisor

        $constraints = new Assert\Collection([
            'int1' => new Assert\Required([new Assert\Type('integer'), new Assert\GreaterThan(0)]),
            'int2' => new Assert\Required([new Assert\Type('integer'), new Assert\GreaterThan(0)]),
            'limit' => new Assert\Required([new Assert\Type('integer'), new Assert\GreaterThan(0)]),
            'str1' => new Assert\Required([new Assert\Type('string'), new Assert\NotNull()]),
            'str2' => new Assert\Required([new Assert\Type('string'), new Assert\NotNull()]),
        ]);

        $violations = $validator->validate([
            'int1' => $int1,
            'int2' => $int2,
            'limit' => $limite,
            'str1' => $str1,
            'str2' => $str2,
        ], $constraints);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], 400);
        } else {
            if (($limite < $int1) || ($limite < $int2)) {
                $errors['limit'] = 'This value should be greater than int1 and int2';
                return new JsonResponse(['errors' => $errors], 400);
            }
        }

        $result = [];
        for ($i = 1; $i <= $limite; $i++) {
            $output = '';
            if ($i % $int1 === 0) {
                $output .= $str1;
            }
            if ($i % $int2 === 0) {
                $output .= $str2;
            }
            $result[] = $output ?: (string)$i;
        }

        $this->fizzBuzzStatsRepository->saveRequest($int1, $int2, $limite, $str1, $str2);

        return new JsonResponse($result);
    }

    /**
     * Statistics endpoint allowing users to know what the most frequent request has been
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/statistics', name: 'statistics', methods: ['GET'])]
    public function statistics(): JsonResponse
    {
        $mostFrequent = $this->fizzBuzzStatsRepository->getMostFrequentRequest();
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        return new JsonResponse($mostFrequent ? $serializer->normalize($mostFrequent) : ['message' => 'No data available']);
    }
}
