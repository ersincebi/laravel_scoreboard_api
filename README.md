# laravel_skorbord_api
Implementation of an API application using the Laravel Framework [https://laravel.com/docs/8.x](https://laravel.com/docs/8.x)

### Installation
- Clone the project
- In the project folder run `make all` or `php artisan serve`
- Hit the IP address with postman
- if the database not loads, the database file is under ./docker/mysql/laravel.sql


### Requerinments
- docker
- docker-compose
- make
### without docker
- php
- composer
### Usage

- You may use the the postman collaction file that inside the main directory of the project
- The base will be `http://localhost:8081` or `http://127.0.0.1:8000`



#### Requests
The routes available are:

| Method | Route                                                    | Parameters                                      | Action                                                   |
|--------|--------------------|-------------------------------------------------|------------------------------------------------------------------------------------------------|
| `GET`  | `/api/get_games`                                         |                                                 | Retrieves all games                                      |
| `GET`  | `/api/get_scoreboard/{game_id}`                          | Numeric Id                                      | Retrieves scorese that made on that ggame                |
| `POST` | `/api/add_score/{game_id}/{user_id}/{score}`             | `quantity`,`address`,`shippingDate`,`orderCode` | Adds a new score                                         |

