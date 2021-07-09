# BTCPay Server Greenfield API PHP client library
This library makes it easier to integrate BTCPay Server in your PHP application.

## Features
- No external dependancies. You can just drop this code in your project using composer or without composer.
- Requires PHP 7.3 and up. End-of-life'd versions will not be actively supported.
- All calls needed for eCommerce are included, but there are more we still need to add.

## TODO
- Autoloader just for our own files. Must not affect previously existing autoloaders.
- Getters and setters
- Expand beyond the eCommerce related API calls and make this library 100% complete.

## How to use with composer
TODO

## How to use without composer
TODO

## Best practises
- Always use an API key with as little permissions as possible.
- If you only interact with specific stores, use an API key that is limited to that store or those stores only.
- When processing an incoming webhook, always load the data fresh using the API as the data may be stale or changed in the meantime. Webhook payloads can be resent on error, so you could be seeing outdated information. By loading the data fresh, you are also protecting yourself from possibly spoofed (fake) requests. 