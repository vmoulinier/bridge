# Bridge contract

##  Requirements

- [Docker](https://docs.docker.com/engine/installation/)

To setting up this project, I used (https://github.com/guham/symfony-docker)

## Installation

The following steps are copied from the documentation

1. Clone the project repository
    ```bash
    $ git clone https://github.com/vmoulinier/bridge.git
    ```
    
2. Copy the `symfony/.env.dist` file to `symfony/.env`
    ```bash
    $ cp symfony/.env.dist symfony/.env
    ```

3. Build & run containers with `docker-compose` by specifying a second compose file, e.g., with MySQL 
    ```bash
    $ docker-compose -f docker-compose.yaml -f docker-compose.mysql.yaml build
    ```
    then
    ```bash
    $ docker-compose -f docker-compose.yaml -f docker-compose.mysql.yaml up -d
    ```
   
4. Composer install

    first, configure permissions on `symfony/var` folder
    ```bash
    $ docker-compose exec app chown -R www-data:1000 var
    ```
    then
    ```bash
    $ docker-compose exec -u www-data app composer install
    ```

## Application

You can use any API tools, like POSTMAN

# **URL**

`http://bridge.localhost:8080/index`

# **Body of the request**

Use JSON data to post to the endpoint

**Payload example**
```json
[
   {
      "actions":[
         "D1",
         "C2",
         "H4",
         "NT4",
         "P",
         "P",
         "P"
      ]
   },
   {
      "actions":[
         "H1",
         "NT1",
         "D2",
         "NT5",
         "P",
         "P",
         "P"
      ]
   },
   {
      "actions":[
         "H1",
         "NT1",
         "D2",
         "NT5",
         "P",
         "P",
         "P"
      ]
   },
   {
      "actions":[
         "H1",
         "NT1",
         "D2",
         "NT5",
         "P",
         "P",
         "P"
      ]
   }
]
```

# **Response**

The application return a JSON list who contain the last contract and the player who did it.
