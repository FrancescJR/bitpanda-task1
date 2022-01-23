# Exercise 1.

This would be a quite good test if it weren't for restrictions for using Laravel.

## Requirements

Just docker.

## Installation

composer install
docker composer up

### Seed the DB
on your machine if you have mysql command:
mysql -h 127.0.0.1 -u root laravel < 1./database.sql

Or using docker:

your-shell# docker exec -ti bitpanda-task-1 bash
docker-container-shell# mysql -u root -h mysql laravel < database.sql

Why I don't use artisan? because I don't want my domain to be automatically created by the framework.

## Usage

All the endpoints are RESTful among the resource "/bitpanda/v1/user".

1. Create a call which will return all the users which are `active` (users table) and have an Austrian citizenship.

`GET http://localhost/api/v1/users?country=AUS`

The only filter that works is this one. Trying to go fast


2. Create a call which will allow you to edit user details just if the user details are there already.

`PUT  http://localhost/api/v1/users/{userId}`

(use id = 1 for a user that works and id 2 for a user that don't)

Try with a json body like this one:

```
{
"phone_number": "234234234"
}
```

only the phone number is editable. Trying to go fast...

3. Create a call which will allow you to delete a user just if no user details exist yet.
  
DELETE /bitpanda/v1/users/{userId}

4. Write a feature test for 3. with valid and invalid data

## Description

Here is some explanation and decisions about the development:

###  Directory Structure

I understand this might come a little of a shock. I just know it's very important to develop as independent
of the framework as possible. for that reason, All of my code can be foun in "src" and laravel, almost vanilla
with only the routes, some config, and some customizations to find the vendor in the parent directory
is there.

I have deleted several files that are not needed to complete this task. I am afrais I wasn't as throughtly as I would 
have liked. Laravel gives you many funcionalities out of the box, for this very same reason, it's a very a poor choice
to use it as an API backend. Lumen might have been better. Symfony even better.

Ironically, you are asking to install laravel via composer and this way it doesn't install the docker-compose file
which could be needed.

### Docker

The docker compose is basically the one you get from sail package, but I had to customize it a little bit
because I am using a slightly different directory structure, plus, I had to add some several
missing directives that I am sure can be found on sail scripts.

It doesn't make sense to use a layer that encapsulates docker like sail, I wouldn't say Docker is that difficult.


### Domain

All business logic should be found here. For not wasting time purposes, I didn't use Value Objects
event though there is obvious business logic on the entities attributes that right
now is delegated to the Infrastructure layer, in the DB. For instance, the ISO-2 and
ISO-3 of the country have the restriction of just being 2/3 chars.

This should be specified in the domain preferably, instead of delegating this business
requirement to the relying infrastructure. That might be weird, in this specific case
but imagine you change DB motor to use just redis for example, you would lose this
restriction, and invalid values would be able to be stored, unless you had the code
already to prevent it.

Reverse engineering from the DB, you can see that there are 2 aggregate roots in this domain,
one is "country" and the other one is "User". User is the main aggregate and it has the other
entity user details.

I will just assume that the decision of having user and user details two different entities
was specified by the business, and it doesn't come from some arbitrary decision forced by
the framework. The reason to be for User Details is very frail. We can already see that
it doesn't need actually to have an id, but instead the way of identifying this entity
could be by just the main aggregate root User. That's a strong hint that this is at least
an aggregate. Another hint is that this user details, without user, has no reason to live.

I want to insist, that the reason of having it separately is very frail and it might be better
for example to have it all as single entity in domain and maybe save it separately on the DB, but this also
doesn't make any sense. This separation is just plainly a bad decision. Period.

For the first "call", which is a list of users with filters (if we want to apply some API restful concepts...)
I am using a Criteria pattern. The implementation is rather "rude" (Criteria should have a list of filters
for example). But again, I am just doing what is necessary to complete the task.

Why is there no "Country" in the domain? That is a legitimate question, and the answer is that I was
lazy to make the whole process. I would probably have modelled the domain different. The way it is
makes it for sure that you need to either get the country, joined in a query, or make another
query on the DB to get the country information.

I would advocate for really small aggregates and to make them very independent, so instead of doing teh join query
and therefore be able to do $userdetails->getCoutnry()->getIso2(); to just be able to get the ID. But then
that forces you to do more queries if you want to get the Iso2 of the country, since you will need to find it in the DB.
Why I advocate then for that? Because this problem can be easily solved with projections and CQRS and then we
can have both entities independent and could be even saved in different DBs and developed at different rythms. And again
we don't have to think on which is the DB that we are operating on and whether it supports joins or how it relates
entities.

You can see other business logic for the other endpoints, 
in the domain like trying to update user when user details are not present.

### Application

I am using the command pattern which would be very useful later to apply a Command Bus
and eventually CQRS. I am already spending way more time this tasks requests
to actually go through with it. So the controllers have directly the CommandHandler dependency directly.

That will be easy to modify in the future if a command bus is to be used. (Personally, the only use
I find of teh command bus are the decorators you can put in it. Oh Laravel probably does already something
with its "Middleware". I can repeat how being dependant so bad to the framework is actually bad and something
to avoid at all costs)

### Infrastructure

Everything related to connecting to the DB. I would like to put the controller here but
I was heistating whether to put here the Service Provider to connect to Laravel framework here or not.
I decided to put the service provider in the same Laravel Skeleton.

### Phpunit tests

I wish I had time to add tests in the application and especially in the domain to show how to use
the aggregate: you cannot edit directly user_Details, you have to use this entity through
the user entity. That's a rule of teh aggregates.

Unfortunately, time is pressing, and since I am quite sure we live in two complete different worlds, It's been
years now that I am away of that world and I don't want to go back.
