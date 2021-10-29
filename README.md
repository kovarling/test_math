### Requirements
 - docker
 - make

### Installation
 - cp .env.example into .env
 - cd to /docker folder
 - run `make install`

### Usage
 - place any amount of csv files with transaction into "input" folder (there is already a file with data from task)
 - run `make run-math`

### Testing
 - run `make run-test`

### Configuration
For API rates please use next env variables (default):
 - `RATES_LOCATION=http://api.exchangeratesapi.io/v1/`
 - `RATES_STRATEGY=api`

For locally stored mock data with rates used from task description:
 - `RATES_LOCATION=rates/rates.json`
 - `RATES_STRATEGY=local`
