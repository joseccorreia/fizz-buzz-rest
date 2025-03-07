# FizzBuzz REST API 

## Project Overview
The FizzBuzz REST API is a web server that implements the classic FizzBuzz algorithm.
The API allows users to request a FizzBuzz sequence with customizable parameters and
provides a statistics endpoint to track the most frequent requests.

## Prerequisites
- PHP 8.3 or higher
- Composer
- Docker (for containerized environment)

## Installation
1. **Clone the repository:**
   ```bash
   git clone https://github.com/joseccorreia/fizz-buzz-rest.git
   cd fizzbuzz-rest-api
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Set up the environment:**
   Copy the example environment file and update the environment variables as needed:
   ```bash
   cp .env .env.local
   ```

4. **Start the Docker containers:**
   ```bash
   docker-compose up -d
   ```

## Usage
1. **Run the Symfony server:**
   ```bash
   symfony server:start --port=8080
   ```

2. **Access the FizzBuzz endpoint:**
   ```bash
   wget 'http://127.0.0.1/fizzbuzz?int1=3&int2=5&limit=15&str1=fizz&str2=buzz'
   ```

3. **Access the statistics endpoint:**
   ```bash
   wget 'http://127.0.0.1/statistics'
   ```

## Running Tests
To run the tests, use the following command:
   ```bash
   php ./vendor/bin/phpunit
   ```

If you encounter any issues, try running PHPUnit with increased verbosity:
   ```bash
   php ./vendor/bin/phpunit --verbose
   ```

## Docker Setup
This project includes a Docker setup for a containerized environment.
The Docker configuration files are located in the `docker-fizzbuzzrest` directory.

1. **Build the Docker image:**
   ```bash
   docker-compose build
   ```

2. **Start the containers:**
   ```bash
   docker-compose up -d
   ```

3. **Access the application:**
   Open your browser and navigate to `http://localhost:8080`.

## Contributing
We welcome contributions! Please follow these steps to contribute to the project:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.

## Contact
For questions or support, please contact me at nd@email.pt
