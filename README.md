# Symfony Payment API

## Overview

This project is a Symfony application that provides an API endpoint and a CLI command to handle payment requests through two external systems, Shift4 and ACI. The application accepts input parameters, sends requests to the appropriate external system based on the input, and returns a unified response.

## Features

- API endpoint to handle payment requests
- CLI command to handle payment requests
- Supports Shift4 and ACI payment systems
- Unified response format
- Dockerized environment
- PHPUnit tests

## Prerequisites

- Docker installed on your machine
- Docker Compose installed on your machine

### Running PHPUnit Tests
To ensure your application works as expected, you can run PHPUnit tests.

Step 1: Write Tests
Write your PHPUnit tests in the tests directory. Example test files have already been created:

Unit Test for PaymentServiceFactory: tests/Service/PaymentServiceFactoryTest.php

Integration Test for ExampleController: tests/Controller/ExampleControllerTest.php

### Documentation
API Endpoint Example
The API endpoint can be accessed as follows:

Shift4: POST /app/example/shift4

ACI: POST /app/example/aci

### Request Body Example

```
{
"amount": 100,
"currency": "USD",
"card_number": "4242424242424242",
"card_exp_month": 12,
"card_exp_year": 2024,
"card_cvv": "123"
}
```

### CLI Command Example
```
docker-compose exec app bin/console app:example shift4
docker-compose exec app bin/console app:example aci
```
