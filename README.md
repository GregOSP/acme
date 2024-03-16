# Acme Widget Co

This is a demo program for a shopping cart application written in php. The application consists of a Basket that is initialized with a catalog of products, a delivery charge calculator based on the sum of goods purchased, and any offers that might exist at the time.

## Assumptions

- Total sums are based on unrounded numbers through all calculations but returned rounded to two decimal points with halves rounded down
    - Based on the examples in the prompt
- While data should be coming from DB tables I assumed this was out of scope for this project and hard-coded the test cases.
- I assumed any offer could only be added once.
    - I use the class name of the offer as a key in an associative array to ensure the class was added to the Basket only once.
- I assumed it was okay to have offers be kept in code.
    - While this requires code changes to push any new offers to production, the alternative of defining offer rulesets as data and writing a generic function to interpret them felt too time consuming for this test.


## Running with Docker

Download the repository then create a docker image and run it to get the output of the test cases.

To see the output of phpstan and phpunit do the following from the directory of this repo:

```shell
docker build -t acme-test .
docker run acme-test ./vendor/bin/phpstan analyse -l 9 src tests ; ./vendor/bin/phpunit tests/
```