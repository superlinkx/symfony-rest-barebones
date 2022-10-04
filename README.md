# Symfony Rest Barebones Example

This is part of my series of barebones REST examples for research purposes. The CRUD example is effectively just
https://medium.com/q-software/symfony-5-the-rest-the-crud-and-the-swag-7430cb84cd5 but with Symfony 6.

This is by no means a recommended way to build a CRUD app. It is for research purposes only and has several problems with
not checking for errors or doing proper input sanitization. May be something I'll look at fixing in the future, but
isn't part of my current research. It's a quick and dirty implementation designed to get an MVP.

## Getting Started

I've created this repo with a VS Code Devcontainer definition. It's relatively easy to see the dependencies this way,
and if you're using VS Code, you can simply run this project in a dev container with the VS Code Remote Dev Containers
extension. This will create a reproducible environment with all dependencies already configured.

### Starting The App

To get the app's dependencies, run:

```console
foo@bar:~$ composer install
```

In order to get the default database up and running, use `docker-compose up -d` (this works in the devcontainer thanks to
docker-in-docker). This will run Postgres with the default parameters and forward port 5432.

The following commands will need to be run when working with a fresh database:

```console
foo@bar:~$ bin/console doctrine:migrations:migrate
foo@bar:~$ bin/console doctrine:fixtures/load
```

This will run the current migrations and seed the database with Faker data.

Start the app:

```
foo@bar:~$ symfony server:start
```

- Open `127.0.0.1:8000` in a browser to see the default Symfony landing to see if it's working
- Can either run Postman against the endpoints or use the `example.http` with the VS Code "Rest Client" extension to try out some example endpoints
