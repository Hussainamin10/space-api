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

#### GET /space-api/rockets?current_page=1&pageSize=7

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

#### GET /space-api/rockets?rocketName=e&companyName=Blue

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

### POST /space-api/register

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

### POST /space-api/login

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

# Location

## Examples of Correct Inputs for GET /locations

### GET /space-api/locations

Return a list of all locations paginated

```json
{
  "meta": {
    "total_items": 14,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 3
  },
  "data": [
    {
      "id": 4,
      "name": "Palmachim Airbase, State of Israel",
      "countryCode": "ISR",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_4_20200803142418.jpg",
      "timezone": "Asia/Jerusalem",
      "launchCount": 12,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/4/"
    },
    {
      "id": 12,
      "name": "Cape Canaveral, FL",
      "countryCode": "USA",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_12_20200803142519.jpg",
      "timezone": "America/New_York",
      "launchCount": 974,
      "landingCount": 56,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/12/"
    },
    {
      "id": 13,
      "name": "Guiana Space Centre, French Guiana",
      "countryCode": "GUF",
      "description": "The Guiana Space Centre is a European spaceport to the northwest of Kourou in French Guiana, a region of France in South America. Kourou is located at a latitude of 5°. In operation since 1968, it is a suitable location for a spaceport because of its equatorial location and open sea to the east.",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_13_20200803142412.jpg",
      "timezone": "America/Cayenne",
      "launchCount": 322,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/13/"
    },
    {
      "id": 15,
      "name": "Baikonur Cosmodrome",
      "countryCode": "KAZ",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_15_20200803142517.jpg",
      "timezone": "Asia/Qyzylorda",
      "launchCount": 1551,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/15/"
    },
    {
      "id": 18,
      "name": "Vostochny Cosmodrome, Siberia, Russian Federation",
      "countryCode": "RUS",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_18_20200803142401.jpg",
      "timezone": "Asia/Yakutsk",
      "launchCount": 17,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/18/"
    }
  ]
}
```

### Pagination

To paginate, in query add current_page = {number less or equal to total_pages}, and pageSize = the amount of items you wish to be displayed

#### GET /space-api/locations?current_page=1&pageSize=2

```json
{
  "meta": {
    "total_items": 14,
    "offset": 0,
    "current_page": 1,
    "page_size": 2,
    "total_pages": 7
  },
  "data": [
    {
      "id": 4,
      "name": "Palmachim Airbase, State of Israel",
      "countryCode": "ISR",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_4_20200803142418.jpg",
      "timezone": "Asia/Jerusalem",
      "launchCount": 12,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/4/"
    },
    {
      "id": 12,
      "name": "Cape Canaveral, FL",
      "countryCode": "USA",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_12_20200803142519.jpg",
      "timezone": "America/New_York",
      "launchCount": 974,
      "landingCount": 56,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/12/"
    }
  ]
}
```

### Filters

Filter by 'name', 'countryCode', 'description', 'timezone', 'minLaunchCount', 'maxLaunchCount', 'minLandingCount','maxLandingCount'

#### GET /space-api/locations?timezone=Asia/J

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
      "id": 4,
      "name": "Palmachim Airbase, State of Israel",
      "countryCode": "ISR",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_4_20200803142418.jpg",
      "timezone": "Asia/Jerusalem",
      "launchCount": 12,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/4/"
    },
    {
      "id": 157,
      "name": "Cheese",
      "countryCode": "qwq",
      "description": "ewqewqe",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_4_20200803142418.jpg",
      "timezone": "Asia/Jerusalem",
      "launchCount": 142,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/4/"
    },
    {
      "id": 160,
      "name": "lol",
      "countryCode": "qwq",
      "description": "ewqewqe",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_4_20200803142418.jpg",
      "timezone": "Asia/Jerusalem",
      "launchCount": 12,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/4/"
    }
  ]
}
```

### Sorting

Add 'sort_by' to the query list and the data field you want to be sorted by, only 3 are allowed:\
['name', 'launchCount', 'countryCode']\

#### GET /space-api/locations?sort_by=launchCount&order=desc

```json
{
  "meta": {
    "total_items": 14,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 3
  },
  "data": [
    {
      "id": 15,
      "name": "Baikonur Cosmodrome",
      "countryCode": "KAZ",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_15_20200803142517.jpg",
      "timezone": "Asia/Qyzylorda",
      "launchCount": 1551,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/15/"
    },
    {
      "id": 12,
      "name": "Cape Canaveral, FL",
      "countryCode": "USA",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_12_20200803142519.jpg",
      "timezone": "America/New_York",
      "launchCount": 974,
      "landingCount": 56,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/12/"
    },
    {
      "id": 13,
      "name": "Guiana Space Centre, French Guiana",
      "countryCode": "GUF",
      "description": "The Guiana Space Centre is a European spaceport to the northwest of Kourou in French Guiana, a region of France in South America. Kourou is located at a latitude of 5°. In operation since 1968, it is a suitable location for a spaceport because of its equatorial location and open sea to the east.",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_13_20200803142412.jpg",
      "timezone": "America/Cayenne",
      "launchCount": 322,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/13/"
    },
    {
      "id": 27,
      "name": "Kennedy Space Center, FL",
      "countryCode": "USA",
      "description": "",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_27_20200803142447.jpg",
      "timezone": "America/New_York",
      "launchCount": 243,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/27/"
    },
    {
      "id": 157,
      "name": "Cheese",
      "countryCode": "qwq",
      "description": "ewqewqe",
      "mapImage": "https://thespacedevs-prod.nyc3.digitaloceanspaces.com/media/map_images/location_4_20200803142418.jpg",
      "timezone": "Asia/Jerusalem",
      "launchCount": 142,
      "landingCount": 0,
      "url": "https://lldev.thespacedevs.com/2.2.0/location/4/"
    }
  ]
}
```


# Space Stations

## Examples of Correct Inputs for GET /spacestations

### GET /space-api/spacestations

Return a list of all space stations paginated

```json
{
  "meta": {
    "total_items": 8,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 2
  },
  "data": [
    {
      "stationID": 1,
      "name": "International Space Station",
      "status": 1,
      "type": "Space Station",
      "founded": "1998-11-20",
      "description": "The International Space Station is a large spacecraft in low Earth orbit that serves as a home and research laboratory for astronauts.",
      "owners": "International cooperation among NASA, Roscosmos, ESA, JAXA, and CSA"
    },
    {
      "stationID": 2,
      "name": "Tiangong space station",
      "status": 1,
      "type": "Government",
      "founded": "2021-04-29",
      "description": "The Tiangong space station is a space station placed in Low Earth orbit between 340 and 450 km above the surface. It will be roughly one-fifth the mass of the International Space Station and about the size of the Mir space station.",
      "owners": "China Aerospace Science and Technology Corporation"
    },
    {
      "stationID": 3,
      "name": "Mir Space Station",
      "status": 0,
      "type": "Government",
      "founded": "1986-02-20",
      "description": "The Mir Space Station was a Soviet space station that operated in low Earth orbit from 1986 to 2001. It served as a pioneering modular space station.",
      "owners": "Soviet Space Program, Russian Space Agency"
    },
    {
      "stationID": 4,
      "name": "Skylab",
      "status": 0,
      "type": "Government",
      "founded": "1973-05-14",
      "description": "Skylab was the United States' first space station, orbiting Earth from 1973 to 1979. It was used for scientific research and solar observations.",
      "owners": "NASA"
    },
    {
      "stationID": 5,
      "name": "Almaz",
      "status": 0,
      "type": "Military",
      "founded": "1973-04-03",
      "description": "Almaz was a series of military space stations developed by the Soviet Union in the 1970s for reconnaissance and research purposes.",
      "owners": "Soviet Space Program"
    }
  ]
}
```

### Pagination

To paginate, in query add current_page = {number less or equal to total_pages}, and pageSize = the amount of items you wish to be displayed

#### GET /space-api/spacestations?pageSize=2&current_page=1

```json
{
  "meta": {
    "total_items": 8,
    "offset": 0,
    "current_page": 1,
    "page_size": 2,
    "total_pages": 4
  },
  "data": [
    {
      "stationID": 1,
      "name": "International Space Station",
      "status": 1,
      "type": "Space Station",
      "founded": "1998-11-20",
      "description": "The International Space Station is a large spacecraft in low Earth orbit that serves as a home and research laboratory for astronauts.",
      "owners": "International cooperation among NASA, Roscosmos, ESA, JAXA, and CSA"
    },
    {
      "stationID": 2,
      "name": "Tiangong space station",
      "status": 1,
      "type": "Government",
      "founded": "2021-04-29",
      "description": "The Tiangong space station is a space station placed in Low Earth orbit between 340 and 450 km above the surface. It will be roughly one-fifth the mass of the International Space Station and about the size of the Mir space station.",
      "owners": "China Aerospace Science and Technology Corporation"
    }
  ]
}
```

### Filters

Filter by 'name', 'type', 'description', 'owners', 'status', 'minFounded', 'maxFounded'

#### GET /space-api/spacestations?type=government

```json
{
  "meta": {
    "total_items": 5,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 1
  },
  "data": [
    {
      "stationID": 2,
      "name": "Tiangong space station",
      "status": 1,
      "type": "Government",
      "founded": "2021-04-29",
      "description": "The Tiangong space station is a space station placed in Low Earth orbit between 340 and 450 km above the surface. It will be roughly one-fifth the mass of the International Space Station and about the size of the Mir space station.",
      "owners": "China Aerospace Science and Technology Corporation"
    },
    {
      "stationID": 3,
      "name": "Mir Space Station",
      "status": 0,
      "type": "Government",
      "founded": "1986-02-20",
      "description": "The Mir Space Station was a Soviet space station that operated in low Earth orbit from 1986 to 2001. It served as a pioneering modular space station.",
      "owners": "Soviet Space Program, Russian Space Agency"
    },
    {
      "stationID": 4,
      "name": "Skylab",
      "status": 0,
      "type": "Government",
      "founded": "1973-05-14",
      "description": "Skylab was the United States' first space station, orbiting Earth from 1973 to 1979. It was used for scientific research and solar observations.",
      "owners": "NASA"
    },
    {
      "stationID": 9,
      "name": "Buran Space Station",
      "status": 0,
      "type": "Government",
      "founded": "0000-00-00",
      "description": "The Buran Space Station was a proposed Soviet space station that would have supported the Buran space shuttle program. It was ultimately never built.",
      "owners": "Soviet Space Program"
    },
    {
      "stationID": 10,
      "name": "Salyut 1",
      "status": 0,
      "type": "Government",
      "founded": "1971-04-19",
      "description": "Salyut 1 was the world's first space station, launched by the Soviet Union in 1971. It paved the way for future modular space stations.",
      "owners": "Soviet Space Program"
    }
  ]
}
```

### Sorting

Add 'sort_by' to the query list and the data field you want to be sorted by, only 3 are allowed:\
['name', 'founded' (yyyy-mm-dd), 'owners']\

#### GET /space-api/spacestations?sort_by=founded

```json
{
  "meta": {
    "total_items": 8,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 2
  },
  "data": [
    {
      "stationID": 6,
      "name": "Freedom Space Station",
      "status": 0,
      "type": "International",
      "founded": "0000-00-00",
      "description": "Freedom was a proposed modular space station that was a precursor to the International Space Station. It was a collaborative project involving NASA, ESA, JAXA, and Canada, but was never launched.",
      "owners": "NASA, ESA, JAXA, CSA"
    },
    {
      "stationID": 9,
      "name": "Buran Space Station",
      "status": 0,
      "type": "Government",
      "founded": "0000-00-00",
      "description": "The Buran Space Station was a proposed Soviet space station that would have supported the Buran space shuttle program. It was ultimately never built.",
      "owners": "Soviet Space Program"
    },
    {
      "stationID": 10,
      "name": "Salyut 1",
      "status": 0,
      "type": "Government",
      "founded": "1971-04-19",
      "description": "Salyut 1 was the world's first space station, launched by the Soviet Union in 1971. It paved the way for future modular space stations.",
      "owners": "Soviet Space Program"
    },
    {
      "stationID": 5,
      "name": "Almaz",
      "status": 0,
      "type": "Military",
      "founded": "1973-04-03",
      "description": "Almaz was a series of military space stations developed by the Soviet Union in the 1970s for reconnaissance and research purposes.",
      "owners": "Soviet Space Program"
    },
    {
      "stationID": 4,
      "name": "Skylab",
      "status": 0,
      "type": "Government",
      "founded": "1973-05-14",
      "description": "Skylab was the United States' first space station, orbiting Earth from 1973 to 1979. It was used for scientific research and solar observations.",
      "owners": "NASA"
    }
  ]
}
```

## Ali Ilyas





# Planet

## Examples of Correct Inputs for GET /Planet

### GET /space-api/planets

Return a list of all planets paginated
```json
{
  "meta": {
    "total_items": 20,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 4
  },
  "data": [
    {
      "planetID": 1,
      "name": "Mercury",
      "sideralOrbit": 87.969,
      "sideralRotation": 58.646,
      "mass": "0.33000000",
      "equaRadius": 2439.7,
      "gravity": "3.70000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 2,
      "name": "Venus",
      "sideralOrbit": 224.701,
      "sideralRotation": 243.018,
      "mass": "4.87000000",
      "equaRadius": 6051.8,
      "gravity": "8.87000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 3,
      "name": "Earth",
      "sideralOrbit": 365.256,
      "sideralRotation": 0.997,
      "mass": "5.97000000",
      "equaRadius": 6371,
      "gravity": "9.81000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 4,
      "name": "Mars",
      "sideralOrbit": 686.971,
      "sideralRotation": 1.026,
      "mass": "0.64200000",
      "equaRadius": 3389.5,
      "gravity": "3.71000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 5,
      "name": "Jupiter",
      "sideralOrbit": 4332.59,
      "sideralRotation": 0.415,
      "mass": "1898.00000000",
      "equaRadius": 69911,
      "gravity": "24.79000000",
      "discoveryDate": null,
      "discoveredBy": null
    }
  ]
}
```

### Pagination

To paginate, in query add current_page = {number less or equal to total_pages}, and pageSize = the amount of items you wish to be displayed

#### GET /space-api/planets?current_page=1&pageSize=7

```json
{
  "meta": {
    "total_items": 20,
    "offset": 9,
    "current_page": 2,
    "page_size": 9,
    "total_pages": 3
  },
  "data": [
    {
      "planetID": 10,
      "name": "Ceres",
      "sideralOrbit": 1680,
      "sideralRotation": 0.379,
      "mass": "0.00093000",
      "equaRadius": 473,
      "gravity": "0.27000000",
      "discoveryDate": "1801-01-01",
      "discoveredBy": "Giuseppe Piazzi"
    },
    {
      "planetID": 11,
      "name": "Haumea",
      "sideralOrbit": 1030,
      "sideralRotation": 0,
      "mass": "0.00006000",
      "equaRadius": 632,
      "gravity": "0.44000000",
      "discoveryDate": "2004-07-07",
      "discoveredBy": "Mike Brown and team"
    },
    {
      "planetID": 12,
      "name": "Makemake",
      "sideralOrbit": 1110,
      "sideralRotation": 0,
      "mass": "0.00004800",
      "equaRadius": 715,
      "gravity": "0.44000000",
      "discoveryDate": "2005-03-31",
      "discoveredBy": "Mike Brown and team"
    },
    {
      "planetID": 13,
      "name": "Eris",
      "sideralOrbit": 12200,
      "sideralRotation": 0,
      "mass": "0.00017000",
      "equaRadius": 1163,
      "gravity": "0.82000000",
      "discoveryDate": "2005-01-05",
      "discoveredBy": "Mike Brown and team"
    },
    {
      "planetID": 14,
      "name": "Pallas",
      "sideralOrbit": 1680,
      "sideralRotation": 0.379,
      "mass": "0.00093000",
      "equaRadius": 512,
      "gravity": "0.28000000",
      "discoveryDate": "1802-03-28",
      "discoveredBy": "Wilhelm Olbers"
    },
    {
      "planetID": 15,
      "name": "Juno",
      "sideralOrbit": 1430,
      "sideralRotation": 0.4,
      "mass": "0.00040000",
      "equaRadius": 258,
      "gravity": "0.24000000",
      "discoveryDate": "1804-09-01",
      "discoveredBy": "Karl Ludwig Harding"
    },
    {
      "planetID": 16,
      "name": "Vesta",
      "sideralOrbit": 1320,
      "sideralRotation": 0.36,
      "mass": "0.00025000",
      "equaRadius": 525,
      "gravity": "0.28000000",
      "discoveryDate": "1807-03-29",
      "discoveredBy": "Wilhelm Olbers"
    },
    {
      "planetID": 17,
      "name": "Hygiea",
      "sideralOrbit": 1850,
      "sideralRotation": 0.365,
      "mass": "0.00020000",
      "equaRadius": 434,
      "gravity": "0.32000000",
      "discoveryDate": "1849-04-12",
      "discoveredBy": "Annibale de Gasparis"
    },
    {
      "planetID": 18,
      "name": "Psyche",
      "sideralOrbit": 2500,
      "sideralRotation": 0.4,
      "mass": "0.00028000",
      "equaRadius": 200,
      "gravity": "0.20000000",
      "discoveryDate": "1852-03-17",
      "discoveredBy": "Ippolito Zuccal"
    }
  ]
}
```

### Filters

Filter by 'name', 'minSideralRotation', 'maxSideralRotation', 'minMass', 'maxMass', 'minEquaRadius', 'maxEquaRadius','minGravity',
'maxGravity', 'discoveryDate'

#### GET /space-api/planets?name=M&minGravity=0.3

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
      "planetID": 1,
      "name": "Mercury",
      "sideralOrbit": 87.969,
      "sideralRotation": 58.646,
      "mass": "0.33000000",
      "equaRadius": 2439.7,
      "gravity": "3.70000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 4,
      "name": "Mars",
      "sideralOrbit": 686.971,
      "sideralRotation": 1.026,
      "mass": "0.64200000",
      "equaRadius": 3389.5,
      "gravity": "3.71000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 12,
      "name": "Makemake",
      "sideralOrbit": 1110,
      "sideralRotation": 0,
      "mass": "0.00004800",
      "equaRadius": 715,
      "gravity": "0.44000000",
      "discoveryDate": "2005-03-31",
      "discoveredBy": "Mike Brown and team"
    }
  ]
}
```

### Sorting

Add 'sort_by' to the query list and the data field you want to be sorted by, only name, mass and gravity are allowed:
['name', 'mass', 'gravity']

GET /space-api/planets?sort_by=name

```json
{
  "meta": {
    "total_items": 20,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 4
  },
  "data": [
    {
      "planetID": 10,
      "name": "Ceres",
      "sideralOrbit": 1680,
      "sideralRotation": 0.379,
      "mass": "0.00093000",
      "equaRadius": 473,
      "gravity": "0.27000000",
      "discoveryDate": "1801-01-01",
      "discoveredBy": "Giuseppe Piazzi"
    },
    {
      "planetID": 3,
      "name": "Earth",
      "sideralOrbit": 365.256,
      "sideralRotation": 0.997,
      "mass": "5.97000000",
      "equaRadius": 6371,
      "gravity": "9.81000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 13,
      "name": "Eris",
      "sideralOrbit": 12200,
      "sideralRotation": 0,
      "mass": "0.00017000",
      "equaRadius": 1163,
      "gravity": "0.82000000",
      "discoveryDate": "2005-01-05",
      "discoveredBy": "Mike Brown and team"
    },
    {
      "planetID": 19,
      "name": "Eros",
      "sideralOrbit": 1270,
      "sideralRotation": 0.1,
      "mass": "0.00008000",
      "equaRadius": 16.84,
      "gravity": "0.00200000",
      "discoveryDate": "1898-08-13",
      "discoveredBy": "Gustav Witt"
    },
    {
      "planetID": 11,
      "name": "Haumea",
      "sideralOrbit": 1030,
      "sideralRotation": 0,
      "mass": "0.00006000",
      "equaRadius": 632,
      "gravity": "0.44000000",
      "discoveryDate": "2004-07-07",
      "discoveredBy": "Mike Brown and team"
    }
  ]
}
```

You can also add 'order' in addition to 'sort_by' to determine if the sorting is ascending or descending by passing "ASC" or "DESC" to 'order'. It is ascending by default.

GET /space-api/planets?sort_by=name&order=desc
```json
{
  "meta": {
    "total_items": 20,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 4
  },
  "data": [
    {
      "planetID": 16,
      "name": "Vesta",
      "sideralOrbit": 1320,
      "sideralRotation": 0.36,
      "mass": "0.00025000",
      "equaRadius": 525,
      "gravity": "0.28000000",
      "discoveryDate": "1807-03-29",
      "discoveredBy": "Wilhelm Olbers"
    },
    {
      "planetID": 2,
      "name": "Venus",
      "sideralOrbit": 224.701,
      "sideralRotation": 243.018,
      "mass": "4.87000000",
      "equaRadius": 6051.8,
      "gravity": "8.87000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 7,
      "name": "Uranus",
      "sideralOrbit": 30687.2,
      "sideralRotation": 0.718,
      "mass": "86.80000000",
      "equaRadius": 25362,
      "gravity": "8.69000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 6,
      "name": "Saturn",
      "sideralOrbit": 10759.2,
      "sideralRotation": 0.444,
      "mass": "568.00000000",
      "equaRadius": 58232,
      "gravity": "10.44000000",
      "discoveryDate": null,
      "discoveredBy": null
    },
    {
      "planetID": 18,
      "name": "Psyche",
      "sideralOrbit": 2500,
      "sideralRotation": 0.4,
      "mass": "0.00028000",
      "equaRadius": 200,
      "gravity": "0.20000000",
      "discoveryDate": "1852-03-17",
      "discoveredBy": "Ippolito Zuccal"
    }
  ]
}
```

## Examples of Correct Inputs for POST PUT DELETE /planets

### POST /space-api/planets
-> everything is mandatory\
-> 'sideralOrbit','sideralRotation',
   'mass','equaRadius','gravity' must be numeric values
-> planet name must be unique
```json
[
    {
      "name": "Ali",
      "sideralOrbit": 87.969,
      "sideralRotation": 58.646,
      "mass": "0.33000000",
      "equaRadius": 2439.7,
      "gravity": "3.70000000",
      "discoveryDate": "11/25/2024",
      "discoveredBy": "ALII"
    }
]
```

### PUT /space-api/planets
-> planetID is mandatory\
-> everything else is optional\
-> 'sideralOrbit','sideralRotation',
   'mass','equaRadius','gravity' must be numeric values
-> planet name must be unique\
```json
[
    {
      "planetID" : 21,
      "gravity": "4",
      "discoveryDate": "11/30/2024",
      "discoveredBy": "Rizzz"
    }
]
```

### DELETE /space-api/planets
-> planetID is mandatory\
```json
[
    {
      "planetID" : 21
    }
]
```

## Examples of Incorrect Inputs for /planets

### POST /space-api/planets
```json
[
    {
      "name": "Ali",
      "sideralOrbit": "Shoudl be NUmerICCCCC",
      "sideralRotation": 58.646,
      "mass": "0.33000000",
      "equaRadius": 2439.7,
      "gravity": "3.70000000",
      "discoveryDate": "11/25/2024",
      "discoveredBy": "ALII"
    }
]
```

### PUT /space-api/planets
```json
[
    {
      "planetID" : "Doesnt exist",
      "gravity": "Should be Numeric",
      "discoveryDate": "11/25/2024",
      "discoveredBy": "ALII"
    }
]
```

### DELETE /space-api/rockets
```json
[
    {
      "planetID" : "Doesn't exist and must be integer"
    }
]
```


## Examples of Correct Inputs for /zakat

### POST /space-api/zakat

-> everything is mandatory\
-> everything must be numeric
```json
{
  "currentRateOfGold" : 1340,
  "cashInBank" : 254,
  "cashInHand" : 500,
  "loansGivenOut" : 5000,
  "cashForFuture" : 8000,
  "investments" : 2000,
  "loanTaken" : 1220,
  "givenWages" : 0,
  "payableBills" : 500,
  "valuableGoods" : 1220
}
```

# Missions

## Examples of Correct Inputs for GET /missions

### GET /space-api/missions

Return a list of all missions paginated

```json
{
  "meta": {
    "total_items": 32,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 7
  },
  "data": [
    {
      "missionID": 1,
      "companyName": "Roscosmos",
      "spaceStationId": null,
      "launchDate": "1961-04-12",
      "status": 1,
      "costOfTheMissions": "100000.00",
      "missionDuration": "1.00",
      "crewSize": 1,
      "location_id": 15
    },
    {
      "missionID": 2,
      "companyName": "NASA",
      "spaceStationId": null,
      "launchDate": "1969-07-16",
      "status": 1,
      "costOfTheMissions": "355000000.00",
      "missionDuration": "8.00",
      "crewSize": 3,
      "location_id": 27
    },
    {
      "missionID": 3,
      "companyName": "NASA",
      "spaceStationId": null,
      "launchDate": "1969-07-16",
      "status": 1,
      "costOfTheMissions": "355000000.00",
      "missionDuration": "8.00",
      "crewSize": 3,
      "location_id": 27
    },
    {
      "missionID": 4,
      "companyName": "NASA",
      "spaceStationId": null,
      "launchDate": "1966-11-11",
      "status": 1,
      "costOfTheMissions": "19000000.00",
      "missionDuration": "5.00",
      "crewSize": 2,
      "location_id": 12
    },
    {
      "missionID": 5,
      "companyName": "NASA",
      "spaceStationId": null,
      "launchDate": "1983-06-18",
      "status": 1,
      "costOfTheMissions": "150000000.00",
      "missionDuration": "6.00",
      "crewSize": 5,
      "location_id": 27
    }
  ]
}
```

### Pagination

To paginate, in query add current_page = {number less or equal to total_pages}, and pageSize = the amount of items you wish to be displayed

#### GET /space-api/missions?current_page=1&pageSize=2

```json
{
  "meta": {
    "total_items": 32,
    "offset": 4,
    "current_page": 2,
    "page_size": 4,
    "total_pages": 8
  },
  "data": [
    {
      "missionID": 5,
      "companyName": "NASA",
      "spaceStationId": null,
      "launchDate": "1983-06-18",
      "status": 1,
      "costOfTheMissions": "150000000.00",
      "missionDuration": "6.00",
      "crewSize": 5,
      "location_id": 27
    },
    {
      "missionID": 6,
      "companyName": "Roscosmos",
      "spaceStationId": null,
      "launchDate": "1963-06-16",
      "status": 1,
      "costOfTheMissions": "100000.00",
      "missionDuration": "3.00",
      "crewSize": 1,
      "location_id": 15
    },
    {
      "missionID": 7,
      "companyName": "NASA",
      "spaceStationId": null,
      "launchDate": "1962-02-20",
      "status": 1,
      "costOfTheMissions": "50000000.00",
      "missionDuration": "1.00",
      "crewSize": 1,
      "location_id": 12
    },
    {
      "missionID": 8,
      "companyName": "NASA",
      "spaceStationId": null,
      "launchDate": "1998-10-29",
      "status": 1,
      "costOfTheMissions": "150000000.00",
      "missionDuration": "9.00",
      "crewSize": 7,
      "location_id": 27
    }
  ]
}
```

### Filters

Filter by 'companyName', 'spaceStationId', 'rocketName', 'locationCountryCode', 'launchDate', 'status', 'minCostOfMission','maxCostOfMission',
'minMissionDuration','maxMissionDuration',
'minCrewSize','maxCrewSize'

#### GET /space-api/missions?rocketName=Falcon 9

```json
{
  "meta": {
    "total_items": 2,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 1
  },
  "data": [
    {
      "missionID": 31,
      "companyName": "SpaceX",
      "spaceStationId": 1,
      "launchDate": "2020-05-30",
      "status": 1,
      "costOfTheMissions": "220000000.00",
      "missionDuration": "64.00",
      "crewSize": 2,
      "location_id": 27,
      "rocketName": "Falcon 9"
    },
    {
      "missionID": 32,
      "companyName": "SpaceX",
      "spaceStationId": 1,
      "launchDate": "2021-04-23",
      "status": 1,
      "costOfTheMissions": "220000000.00",
      "missionDuration": "180.00",
      "crewSize": 4,
      "location_id": 27,
      "rocketName": "Falcon 9"
    }
  ]
}
```

### Sorting

Add 'sort_by' to the query list and the data field you want to be sorted by, only 3 are allowed:\
['companyName', 'costOfMission', 'missionDuration']\

#### GET /space-api/missions?sort_by=companyName

```json
{
  "meta": {
    "total_items": 32,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 7
  },
  "data": [
    {
      "missionID": 28,
      "companyName": "Blue Origin",
      "spaceStationId": null,
      "launchDate": "2021-07-20",
      "status": 1,
      "costOfTheMissions": null,
      "missionDuration": "0.18",
      "crewSize": 4,
      "location_id": null
    },
    {
      "missionID": 12,
      "companyName": "ESA",
      "spaceStationId": 1,
      "launchDate": "2016-07-07",
      "status": 1,
      "costOfTheMissions": "70000000.00",
      "missionDuration": "139.00",
      "crewSize": 3,
      "location_id": 15
    },
    {
      "missionID": 13,
      "companyName": "ESA",
      "spaceStationId": 1,
      "launchDate": "2011-12-21",
      "status": 1,
      "costOfTheMissions": "70000000.00",
      "missionDuration": "6.00",
      "crewSize": 6,
      "location_id": 15
    },
    {
      "missionID": 19,
      "companyName": "ESA",
      "spaceStationId": 1,
      "launchDate": "2013-12-19",
      "status": 1,
      "costOfTheMissions": "70000000.00",
      "missionDuration": "146.00",
      "crewSize": 6,
      "location_id": 15
    },
    {
      "missionID": 11,
      "companyName": "ESA",
      "spaceStationId": 1,
      "launchDate": "2014-05-28",
      "status": 1,
      "costOfTheMissions": "70000000.00",
      "missionDuration": "166.00",
      "crewSize": 6,
      "location_id": 15
    }
  ]
}
```
You can also add 'order' in addition to 'sort_by' to determine if the sorting is ascending or descending by passing "ASC" or "DESC" to 'order'. It is ascending by default.

GET /space-api/missions?sort_by=companyName&order=desc
```json
{
  "meta": {
    "total_items": 32,
    "offset": 0,
    "current_page": 1,
    "page_size": 5,
    "total_pages": 7
  },
  "data": [
    {
      "missionID": 31,
      "companyName": "SpaceX",
      "spaceStationId": 1,
      "launchDate": "2020-05-30",
      "status": 1,
      "costOfTheMissions": "220000000.00",
      "missionDuration": "64.00",
      "crewSize": 2,
      "location_id": 27
    },
    {
      "missionID": 32,
      "companyName": "SpaceX",
      "spaceStationId": 1,
      "launchDate": "2021-04-23",
      "status": 1,
      "costOfTheMissions": "220000000.00",
      "missionDuration": "180.00",
      "crewSize": 4,
      "location_id": 27
    },
    {
      "missionID": 1,
      "companyName": "Roscosmos",
      "spaceStationId": null,
      "launchDate": "1961-04-12",
      "status": 1,
      "costOfTheMissions": "100000.00",
      "missionDuration": "1.00",
      "crewSize": 1,
      "location_id": 15
    },
    {
      "missionID": 9,
      "companyName": "Roscosmos",
      "spaceStationId": null,
      "launchDate": "1961-08-06",
      "status": 1,
      "costOfTheMissions": "100000.00",
      "missionDuration": "1.00",
      "crewSize": 1,
      "location_id": 15
    },
    {
      "missionID": 6,
      "companyName": "Roscosmos",
      "spaceStationId": null,
      "launchDate": "1963-06-16",
      "status": 1,
      "costOfTheMissions": "100000.00",
      "missionDuration": "3.00",
      "crewSize": 1,
      "location_id": 15
    }
  ]
}
```
