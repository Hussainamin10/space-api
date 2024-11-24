# Rockets

## Examples of Correct Inputs for GET /rockets

### GET /space-api/rockets

Return a list of all rockets paginated
```json
{
  "meta": {
    "total_items": 13,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 3
  },
  "data": [
    {
      "rocketID": 1,
      "rocketName": "Atlas-Agena",
      "companyName": "NASA",
      "rocketHeight": "32.00",
      "status": "Retired",
      "liftOfThrust": 1900,
      "rocketWeight": "58000.00",
      "numberOfStages": 2,
      "launchCost": "11000000.00"
    },
    {
      "rocketID": 2,
      "rocketName": "Falcon 9",
      "companyName": "SpaceX",
      "rocketHeight": "70.00",
      "status": "Active",
      "liftOfThrust": 7600,
      "rocketWeight": "54900.00",
      "numberOfStages": 2,
      "launchCost": "62000000.00"
    },
    {
      "rocketID": 3,
      "rocketName": "New Shepard",
      "companyName": "Blue Origin",
      "rocketHeight": "18.30",
      "status": "Active",
      "liftOfThrust": 7400,
      "rocketWeight": "15000.00",
      "numberOfStages": 2,
      "launchCost": "10000000.00"
    },
    {
      "rocketID": 4,
      "rocketName": "Saturn V",
      "companyName": "NASA",
      "rocketHeight": "110.00",
      "status": "Retired",
      "liftOfThrust": 7600,
      "rocketWeight": "297000.00",
      "numberOfStages": 3,
      "launchCost": "35000000.00"
    },
    {
      "rocketID": 5,
      "rocketName": "Soyuz FG",
      "companyName": "Roscosmos",
      "rocketHeight": "46.00",
      "status": "Active",
      "liftOfThrust": 4000,
      "rocketWeight": "30500.00",
      "numberOfStages": 2,
      "launchCost": "50000000.00"
    }
  ]
}
```

### Pagination

To paginate, in query add current_page = {number less or equal to total_pages}, and pageSize = the amount of items you wish to be displayed

```json
{
  "meta": {
    "total_items": 13,
    "offset": 0,
    "current_page": 1,
    "page_size": 7,
    "total_pages": 2
  },
  "data": [
    {
      "rocketID": 1,
      "rocketName": "Atlas-Agena",
      "companyName": "NASA",
      "rocketHeight": "32.00",
      "status": "Retired",
      "liftOfThrust": 1900,
      "rocketWeight": "58000.00",
      "numberOfStages": 2,
      "launchCost": "11000000.00"
    },
    {
      "rocketID": 2,
      "rocketName": "Falcon 9",
      "companyName": "SpaceX",
      "rocketHeight": "70.00",
      "status": "Active",
      "liftOfThrust": 7600,
      "rocketWeight": "54900.00",
      "numberOfStages": 2,
      "launchCost": "62000000.00"
    },
    {
      "rocketID": 3,
      "rocketName": "New Shepard",
      "companyName": "Blue Origin",
      "rocketHeight": "18.30",
      "status": "Active",
      "liftOfThrust": 7400,
      "rocketWeight": "15000.00",
      "numberOfStages": 2,
      "launchCost": "10000000.00"
    },
    {
      "rocketID": 4,
      "rocketName": "Saturn V",
      "companyName": "NASA",
      "rocketHeight": "110.00",
      "status": "Retired",
      "liftOfThrust": 7600,
      "rocketWeight": "297000.00",
      "numberOfStages": 3,
      "launchCost": "35000000.00"
    },
    {
      "rocketID": 5,
      "rocketName": "Soyuz FG",
      "companyName": "Roscosmos",
      "rocketHeight": "46.00",
      "status": "Active",
      "liftOfThrust": 4000,
      "rocketWeight": "30500.00",
      "numberOfStages": 2,
      "launchCost": "50000000.00"
    },
    {
      "rocketID": 6,
      "rocketName": "Space Shuttle",
      "companyName": "NASA",
      "rocketHeight": "56.00",
      "status": "Retired",
      "liftOfThrust": 2800,
      "rocketWeight": "204000.00",
      "numberOfStages": 2,
      "launchCost": "150000000.00"
    },
    {
      "rocketID": 7,
      "rocketName": "Vostok-K",
      "companyName": "Roscosmos",
      "rocketHeight": "29.00",
      "status": "Retired",
      "liftOfThrust": 2450,
      "rocketWeight": "29200.00",
      "numberOfStages": 2,
      "launchCost": "1000000.00"
    }
  ]
}
```

### Filters

Filter by 'rocketName', 'companyName', 'minHeight', 'maxHeight', 'minWeight', 'maxWeight', 'minThrust','maxThrust'

GET /space-api/rockets?rocketName=e&companyName=Blue

```json
{
  "meta": {
    "total_items": 3,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 1
  },
  "data": [
    {
      "rocketID": 3,
      "rocketName": "New Shepard",
      "companyName": "Blue Origin",
      "rocketHeight": "18.30",
      "status": "Active",
      "liftOfThrust": 7400,
      "rocketWeight": "15000.00",
      "numberOfStages": 2,
      "launchCost": "10000000.00"
    },
    {
      "rocketID": 13,
      "rocketName": "I LIKE CHEESE-SUS",
      "companyName": "Blue Origin",
      "rocketHeight": "0.00",
      "status": "Active",
      "liftOfThrust": 1232,
      "rocketWeight": "78000.00",
      "numberOfStages": 2,
      "launchCost": "100.01"
    },
    {
      "rocketID": 22,
      "rocketName": "Mate ewew",
      "companyName": "Blue Origin",
      "rocketHeight": "42.00",
      "status": "Retired",
      "liftOfThrust": 0,
      "rocketWeight": "0.00",
      "numberOfStages": 0,
      "launchCost": "0.00"
    }
  ]
}
```

### Sorting

Add 'sort_by' to the query list and the data field you want to be sorted by, only 3 are allowed:\
['rocketHeight', 'launchCost', 'companyName']\

GET /space-api/rockets?sort_by=rocketHeight,companyName

```json
{
  "meta": {
    "total_items": 13,
    "offset": 0,
    "current_page": 1,
    "page_size": 3,
    "total_pages": 5
  },
  "data": [
    {
      "rocketID": 13,
      "rocketName": "I LIKE CHEESE-SUS",
      "companyName": "Blue Origin",
      "rocketHeight": "0.00",
      "status": "Active",
      "liftOfThrust": 1232,
      "rocketWeight": "78000.00",
      "numberOfStages": 2,
      "launchCost": "100.01"
    },
    {
      "rocketID": 19,
      "rocketName": "I LIKE CHEESE",
      "companyName": "SpaceX",
      "rocketHeight": "0.00",
      "status": "Active",
      "liftOfThrust": 1232,
      "rocketWeight": "78000.00",
      "numberOfStages": 2,
      "launchCost": "100.01"
    },
    {
      "rocketID": 3,
      "rocketName": "New Shepard",
      "companyName": "Blue Origin",
      "rocketHeight": "18.30",
      "status": "Active",
      "liftOfThrust": 7400,
      "rocketWeight": "15000.00",
      "numberOfStages": 2,
      "launchCost": "10000000.00"
    }
  ]
}
```

You can also add 'order' in addition to 'sort_by' to determine if the sorting is ascending or descending by passing "ASC" or "DESC" to 'order'. It is ascending by default.

GET /space-api/rockets?current_page=1&pageSize=3&sort_by=rocketHeight&order=DESC
```json
{
  "meta": {
    "total_items": 13,
    "offset": 0,
    "current_page": 1,
    "page_size": 3,
    "total_pages": 5
  },
  "data": [
    {
      "rocketID": 4,
      "rocketName": "Saturn V",
      "companyName": "NASA",
      "rocketHeight": "110.00",
      "status": "Retired",
      "liftOfThrust": 7600,
      "rocketWeight": "297000.00",
      "numberOfStages": 3,
      "launchCost": "35000000.00"
    },
    {
      "rocketID": 2,
      "rocketName": "Falcon 9",
      "companyName": "SpaceX",
      "rocketHeight": "70.00",
      "status": "Active",
      "liftOfThrust": 7600,
      "rocketWeight": "54900.00",
      "numberOfStages": 2,
      "launchCost": "62000000.00"
    },
    {
      "rocketID": 6,
      "rocketName": "Space Shuttle",
      "companyName": "NASA",
      "rocketHeight": "56.00",
      "status": "Retired",
      "liftOfThrust": 2800,
      "rocketWeight": "204000.00",
      "numberOfStages": 2,
      "launchCost": "150000000.00"
    }
  ]
}
```

## Examples of Correct Inputs for POST PUT DELETE /rockets

### POST /space-api/rockets
-> everything is mandatory\
-> numeric values must be at least one\
-> status must be either "Active" or "Retired"\
-> company name must correspond with one of the existing company in the 'spacecompany' table\
-> rocket name must be unique\
-> only one rocket at a time
```json
[
  {
    "rocketName": "Mate",
    "companyName": "NASA",
    "rocketHeight": "42.0",
    "status": "Retired",
    "liftOfThrust": "1232",
    "rocketWeight": "78000.00",
    "numberOfStages": 2,
    "launchCost": 100002
  }
]
```

### PUT /space-api/rockets
-> rocketID is mandatory\
-> everything else is optional\
-> numeric values must be at least one\
-> status must be either "Active" or "Retired"\
-> company name must correspond with one of the existing company in the 'spacecompany' table\
-> rocket name must be unique\
-> only one rocket at a time
```json
[
  {
    "rocketID" : 22,
    "rocketName": "Mate",
    "companyName": "NASA",
    "rocketHeight": "42.0",
    "status": "Retired",
    "liftOfThrust": "1232",
    "rocketWeight": "78000.00",
    "numberOfStages": 2,
    "launchCost": 100002
  }
]
```

### DELETE /space-api/rockets
-> rocketID is mandatory\
-> only one rocket at a time\
```json
[
  {
    "rocketID": "26"
  }
]
```

## Examples of Incorrect Inputs for /rockets

### POST /space-api/rockets
```json
[
  {
    "rocketName": "Mate",
    "companyName": "AAAAA I DONT EXISTS",
    "rocketHeight": "42.0",
    "status": "Bring me a plate of cheese",
    "liftOfThrust": "-1232",
    "rocketWeight": "78000.00",
    "numberOfStages": 2,
    "launchCost": 100002
  }
]
```

### PUT /space-api/rockets
```json
[
  {
    "rocketID" : "no tengo cheese",
    "rocketName": "Mate",
    "companyName": "To be or not to be",
  }
]
```

### DELETE /space-api/rockets
```json
[
  "JACKKKKKKKKKKKKKKKKKKKK",
  "HELLO FROM THE OTHER SIDE"
]
```


## Examples of Correct Inputs for /rocket/calLift

### POST /space-api/rocket/calLift

-> everything is mandatory\
-> numeric value must be at least 0
-> massUnit must be "kg" or "lb"
```json
[
  {
    "mass": 22100,
    "massUnit": "kg",
    "gravity": 19.81
  }
]
```

# ACCOUNT

## Examples of Correct Inputs for /account

### POST /register

-> only one account at a time\
-> everything is mandatory\
-> email must be valid and unique\
-> password must be at least 8 characters
-> role must be "admin" or "general"

```json
[
  {
    "first_name": "space",
    "last_name": "space",
    "email": "space@gmail.com",
    "password": "space123",
    "role": "admin"
  }
]
```

## Examples of Incorrect Inputs for /account

POST /register

```json
[
  {
    "first_name": "Jordan",
    "email": "space@gmail.com",
    "password": "Web_Services",
    "role": "I am Elsa"
  },
]
```

## Example of Correct Inputs for /space-api/login

POST /space-api/login
-> everything is mandatory\
-> email must be valid\
-> password must be at least 8 characters\
-> the combination of email and password must exist in db

```json
[
  {
    "email": "space@gmail.com",
    "password": "space123"
  }
]
```
