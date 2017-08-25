---
title: Get Current User Guilds
category: User
order: 4
---

# `getCurrentUserGuilds`

```php
$client->user->getCurrentUserGuilds($parameters);
```

## Description

Requires the guilds OAuth2 scope.

## Parameters


Name | Type | Required | Default
--- | --- | --- | ---
before | snowflake | false | absent
after | snowflake | false | absent
limit | integer | false | 100

## Response

Returns a list of user guild objects the current user is a member of.

Can Return:

* user guild
