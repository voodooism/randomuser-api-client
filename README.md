# Randomuser API client
PHP client for https://randomuser.me API

## Installation
```
composer require voodooism/randomuser-api-client
```

## Usage

```php
  $serializer = SerializerBuilder::create()->build();

  $options = new ClientOptions('https://randomuser.me');

  $client = new Client($serializer, new HttpClient(), $options);
  
  //One user
  $user = $this->client->getRandomUser();
  
  //Array of users
  $users = $this->client->getRandomUsers(10);
```
