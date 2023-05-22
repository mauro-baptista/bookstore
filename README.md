#Bookstore API

## How to use
To be done

## Endpoints

GET /api/books

Will retrieve a json with all the existing books.

Sample:
```
[
  0 => [
    "id" => 1
    "description" => "I, Robot description"
    "publisher" => "Spectra"
    "author" => "Isaac Asimov"
    "cover_photo" => "https://www.moen.info/repellendus-illo-qui-praesentium-ea"
    "price" => 2999
  ], [
    "id" => 2
    "description" => "Rendezvous with Rama description"
    "publisher" => "RosettaBooks"
    "author" => "Arthur C. Clarke"
    "cover_photo" => "http://marks.info/corporis-blanditiis-nobis-ea-aut-sint"
    "price" => 1850
  ]
]
```

GET /api/books/{id}

Will retrieve a json with the data of existing book.

Sample:
```
[
    "id" => 1
    "description" => "I, Robot description"
    "publisher" => "Spectra"
    "author" => "Isaac Asimov"
    "cover_photo" => "https://www.moen.info/repellendus-illo-qui-praesentium-ea"
    "price" => 2999
]
```

## Tests
To be done
