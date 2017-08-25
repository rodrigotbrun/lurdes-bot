---
title: Create Reaction
category: Channel
order: 7
---

# `createReaction`

```php
$client->channel->createReaction($parameters);
```

## Description

Create a reaction for the message. If nobody else has reacted to the message using this emoji, this endpoint requires the &#039;ADD_REACTIONS&#039; permission to be present on the current user.

## Parameters


Name | Type | Required | Default
--- | --- | --- | ---
channel.id | snowflake | true | *null*
message.id | snowflake | true | *null*
emoji | string | true | *null*

## Response

Returns a 204 empty response on success.

