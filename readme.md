# Mailbox API

## Requirements

* PHP >= 7.1.0
* Database MySQL/PostgreSQL/SQLite/SQL Server
* Composer

## Getting Started
After ensuring that you meet the above requirements, follow the below procedures for installing  Mailbox API
### Clone this repo
```shell
$ git clone https://github.com/erisitohang/mailbox.git mailbox
$ cd mailbox
```
### Run Composer
This assumes you have composer installed and configured to run globally. For assistance, visit https://getcomposer.org/download/
```shell
$ composer install
```
### Environment Configuration
```shell
$ cp .env.example to .env
```
After this file copy, update the attributes in .env to match your environment, database, and API Credential

### Data Seed Sample
Copy Or Create file messages_sample.json into storage/app/
```shell
$ cp storage/app/messages_sample.json.example storage/app/messages_sample.json
```

### Seed the Database
```shell
$ php artisan db:seed
```

## Running the tests

Navigate to the project root and run vendor/bin/phpunit after installing all the composer dependencies.
```shell
$ ./vendor/bin/phpunit
```

## Packages

### Responses
Responses are sent using ties into Fractal's Manager object for simplifying and standardizing responses.

### Authentication
The system implements HTTP Authorization header. Username and password is set in .env file with the keys API_USER & API_PASSWORD

```shell
$ curl -X GET http://mailbox.local/api/v1/message -H 'Authorization: Basic YWRtaW46YWRtaW4='
```
OR 
```shell
$ curl -X GET http://admin:admin@mailbox.local/api/v1/message
```

### Pagination
When returning data for collection-based endpoints, results are paginated, 15 per page.
```json
{
    "current_page": 1,
    "data": [
        {
            "uid": 21,
            "sender": "Ernest Hemingway",
            "subject": "animals",
            "message": "This is a tale about nihilism. The story is about a combative nuclear engineer who hates animals. It starts in a ghost town on a world of forbidden magic. The story begins with a legal dispute and ends with a holiday celebration.",
            "time_sent": 1459239867,
            "is_read": false,
            "is_archived": false
        },
        {
            "uid": 24,
            "sender": "George Orwell",
            "subject": "chemist",
            "message": "This is a tale about degeneracy. The story is about a chemist. It takes place in a manufacturing city. The story begins with growth.",
            "time_sent": 1456744407,
            "is_read": false,
            "is_archived": false
        }
    ],
    "first_page_url": "http://mailbox.local/api/v1/message?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://mailbox.local/api/v1/message?page=1",
    "next_page_url": null,
    "path": "http://mailbox.local/api/v1/message",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### Error response
401 Unauthorized are returned with a message "Not found!" in JSON response:
```json
{
    "error": "Unauthorized"
}
```

### List of routes
```$xslt
+------+--------------------------+------------------+-----------------------------------------------+----------+------------+
| Verb | Path                     | NamedRoute       | Controller                                    | Action   | Middleware |
+------+--------------------------+------------------+-----------------------------------------------+----------+------------+
| GET  | /api/v1/message          | message.index    | App\Http\Controllers\Api\V1\MessageController | index    | BasicAuth  |
| GET  | /api/v1/message/archived | message.archived | App\Http\Controllers\Api\V1\MessageController | archived | BasicAuth  |
| GET  | /api/v1/message/{id}     | message.show     | App\Http\Controllers\Api\V1\MessageController | show     | BasicAuth  |
| PUT  | /api/v1/message/read     | message.read     | App\Http\Controllers\Api\V1\MessageController | read     | BasicAuth  |
| PUT  | /api/v1/message/archive  | message.archive  | App\Http\Controllers\Api\V1\MessageController | archive  | BasicAuth  |
| GET  | /                        |                  | None                                          | Closure  |            |
+------+--------------------------+------------------+-----------------------------------------------+----------+------------+
```

## Usage

### List messages
GET /api/v1/message
#### Response
```json
{
    "current_page": 1,
    "data": [
        {
            "uid": 21,
            "sender": "Ernest Hemingway",
            "subject": "animals",
            "message": "This is a tale about nihilism. The story is about a combative nuclear engineer who hates animals. It starts in a ghost town on a world of forbidden magic. The story begins with a legal dispute and ends with a holiday celebration.",
            "time_sent": 1459239867,
            "is_read": false,
            "is_archived": false
        }
    ],
    "first_page_url": "http://mailbox.local/api/v1/message?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://mailbox.local/api/v1/message?page=1",
    "next_page_url": null,
    "path": "http://mailbox.local/api/v1/message",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```
### List archived messages
GET /api/v1/message/archived
#### Response
```json
{
    "current_page": 1,
    "data": [
        {
            "uid": 21,
            "sender": "Ernest Hemingway",
            "subject": "animals",
            "message": "This is a tale about nihilism. The story is about a combative nuclear engineer who hates animals. It starts in a ghost town on a world of forbidden magic. The story begins with a legal dispute and ends with a holiday celebration.",
            "time_sent": 1459239867,
            "is_read": false,
            "is_archived": true
        }
    ],
    "first_page_url": "http://mailbox.local/api/v1/message/archived?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://mailbox.local/api/v1/message/archived?page=1",
    "next_page_url": null,
    "path": "http://mailbox.local/api/v1/message/archived",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### Show message
GET /api/v1/message/21
#### Response
```json
{
    "uid": 21,
    "sender": "Ernest Hemingway",
    "subject": "animals",
    "message": "This is a tale about nihilism. The story is about a combative nuclear engineer who hates animals. It starts in a ghost town on a world of forbidden magic. The story begins with a legal dispute and ends with a holiday celebration.",
    "time_sent": 1459239867,
    "is_read": false,
    "is_archived": true
}
```
### Read message
PUT /api/v1/message/read
#### PUT
```json
{
	"id": 21
}
```
#### Response
```json
{
    "uid": 21,
    "sender": "Ernest Hemingway",
    "subject": "animals",
    "message": "This is a tale about nihilism. The story is about a combative nuclear engineer who hates animals. It starts in a ghost town on a world of forbidden magic. The story begins with a legal dispute and ends with a holiday celebration.",
    "time_sent": 1459239867,
    "is_read": true,
    "is_archived": true
}
```
### Read message
PUT /api/v1/message/archive
#### PUT
```json
{
	"id": 21
}
```

