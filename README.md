#Bookstore API

## How to use
To be done

## Endpoints

### GET /api/books

Retrieve a json with all the existing books.

On success (Status 200):
```
[
  0 => [
    "id" => 1
    "title" => "I, Robot"
    "description" => **"I, Robot** description"
    "publisher" => "Spectra"
    "author" => "Isaac Asimov"
    "cover_photo" => "https://sample.com/irobot.jpg"
    "price" => 2999
    "is_available" => true
  ], [
    "id" => 2
    "title" => "Rendezvous with Rama"
    "description" => "Rendezvous with Rama description"
    "publisher" => "RosettaBooks"
    "author" => "Arthur C. Clarke"
    "cover_photo" => "https://sample.com/rama.jpg"
    "price" => 1850
    "is_available" => false
  ]
]
```

### GET /api/books/{id}

Retrieve a json with the data of existing book.

On success (Status 200):
```
[
    "id" => 1
    "title" => "I, Robot"
    "description" => "I, Robot description"
    "publisher" => "Spectra"
    "author" => "Isaac Asimov"
    "cover_photo" => "https://sample.com/irobot.jpg"
    "price" => 2999
    "is_available" => true
]
```

### POST /api/books

Add a new book.

Rules:
'title' => ['required', 'min:2', 'max:256'],
'description' => ['nullable', 'min:10', 'max:2048'],
'publisher' => ['nullable', 'min:2', 'max:256'],
'author' => ['nullable', 'min:2', 'max:256'],
'cover_photo' => ['nullable', 'url'],
'price' => ['required', 'integer', 'min:0', 'max:999999'],

On success (Status 201):
```
[
    "id" => 1
    "title" => "I, Robot"
    "description" => "I, Robot description"
    "publisher" => "Spectra"
    "author" => "Isaac Asimov"
    "cover_photo" => "https://sample.com/irobot.jpg"
    "price" => 2999
    "is_available" => true
]
```

### PUT /api/books/{id}

Edit an existing book.

Rules: Same as add a new book

On success (Status 200):
```
[
    "id" => 1
    "title" => "I, Robot"
    "description" => "I, Robot description"
    "publisher" => "Spectra"
    "author" => "Isaac Asimov"
    "cover_photo" => "https://sample.com/irobot.jpg"
    "price" => 2999
    "is_available" => true
]
```

### DELETE /api/books/{id}

Delete an existing book.

On success (Status 204):
```
[]
```

### GET /api/books/borrow

Retrieve a json with all the borrowed books by the user.

On success (Status 200):
```
[
  0 => [
    "id" => 1
    "title" => "I, Robot"
    "description" => "I, Robot description"
    "publisher" => "Spectra"
    "author" => "Isaac Asimov"
    "cover_photo" => "https://sample.com/irobot.jpg"
    "price" => 2999
    "is_available" => false
  ], [
    "id" => 2
    "title" => "Rendezvous with Rama"
    "description" => "Rendezvous with Rama description"
    "publisher" => "RosettaBooks"
    "author" => "Arthur C. Clarke"
    "cover_photo" => "https://sample.com/rama.jpg"
    "price" => 1850
    "is_available" => false
  ]
]
```

### POST /api/books/{id}/borrow

It will borrow the book to the user

On success (Status 201):
```
[]
```

### DELETE /api/books/{id}/borrow

It will return the book to from the user

On success (Status 204):
```
[]
```

## Tests
`php ./vendor/bin/phpunit`
