### Requirements
 - docker
 - make

### Installation
 - cp .env.example into .env
 - run `make install`

### Usage
 - place any amount of csv files with transaction into "input" folder (there is already a file with data from task)
 - run `make run-math`

### Testing
 - run `make run-test`

### Configuration
For API rates use next env variables (default):
 - `RATES_STRATEGY=api`

For locally stored mock data with rates used from task description:
 - `RATES_STRATEGY=local`

`R`
`OPERATIONS_PATH` is used to determine where to look for input data. It can be a directory (all csv files inside will be parsed one by one), or it can be a path to 1 file