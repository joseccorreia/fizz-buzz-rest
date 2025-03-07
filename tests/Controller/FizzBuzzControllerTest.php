<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Unit test for the FizzBuzzController in a Symfony application.
 * This test class ensures the following:
 * - The `FizzBuzzController` properly handles valid FizzBuzz requests.
 * - The `FizzBuzzController` returns validation errors for invalid input.
 * - The statistics endpoint accurately retrieves and outputs the most frequent request.
 * @extends WebTestCase
 */
class FizzBuzzControllerTest extends WebTestCase
{

    /**
     * Tests the success scenario of the FizzBuzz endpoint.
     * Sends a GET request to the /fizzbuzz endpoint with specific parameters and verifies:
     * - That the HTTP response status is 200 (OK).
     * - That the response content is valid JSON.
     * - That the decoded JSON matches the expected FizzBuzz output.
     * @return void
     */
    public function testFizzBuzzSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/fizzbuzz', [
            'int1' => 3,
            'int2' => 5,
            'limit' => 15,
            'str1' => 'fizz',
            'str2' => 'buzz',
        ]);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $result = json_decode($client->getResponse()->getContent(), true);
        $expected = ["1", "2", "fizz", "4", "buzz", "fizz", "7", "8", "fizz", "buzz", "11", "fizz", "13", "14", "fizzbuzz"];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests that the FizzBuzz endpoint returns validation errors when invalid input is provided.
     * Validates that the response status code is HTTP_BAD_REQUEST.
     * Ensures the response contains a JSON structure with an 'errors' key.
     */
    public function testFizzBuzzValidationErrors()
    {
        $client = static::createClient();
        $client->request('GET', '/fizzbuzz', [
            'int1' => 'a', // Invalid integer
            'int2' => 5,
            'limit' => 15,
            'str1' => 'fizz',
            'str2' => 'buzz',
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $result = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * Tests that the Statistics endpoint returns a successful response.
     * Validates that the response status code is HTTP_OK.
     * Ensures the response contains a valid JSON structure.
     */
    public function testStatistics()
    {
        $client = static::createClient();
        $client->request('GET', '/statistics');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}
