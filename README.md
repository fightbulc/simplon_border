<pre>
     _                 _               _                   _           
 ___(_)_ __ ___  _ __ | | ___  _ __   | |__   ___  _ __ __| | ___ _ __ 
/ __| | '_ ` _ \| '_ \| |/ _ \| '_ \  | '_ \ / _ \| '__/ _` |/ _ \ '__|
\__ \ | | | | | | |_) | | (_) | | | | | |_) | (_) | | | (_| |  __/ |   
|___/_|_| |_| |_| .__/|_|\___/|_| |_| |_.__/ \___/|_|  \__,_|\___|_|   
                |_|                                                    
</pre>

# Simplon/Border

A small library to handle http requests and responses including JSON-RPC.

## Version

0.5.2

## How to install

Since this library is build with [PHP 5.4 syntax](http://php.net/manual/en/migration54.new-features.php) you are required to have it installed. Simplon/Border can bei installed by either downloading it from github or via [Composer](http://getcomposer.org). I encourage you to do the latter. Here is a snippet from a possible composer.json file:

```json
{
  "require": {
    "php": ">=5.4",
    "simplon/border": "0.5.2"
  }
}
```

## Request object

The request class is basically an interface wrapper for PHP's [$_SERVER](http://php.net/manual/en/reserved.variables.server.php) variable. I also added some methods which help to identify/handle JSON-RPC requests.

### Examples

Just a couple of calls to show you how we roll. Have a look at the class to see all methods:

```php
// print request method
echo Request::getInstance()->getMethod();

// print request uri
echo Request::getInstance()->getUri();

// print query string
echo Request::getInstance()->getQueryString();

// print remote ip
echo Request::getInstance()->getRemoteIp();
```

How to handle JSON-RPC requests?

```php
// is that a json-rpc request?
if(Request::getInstance()->isJsonRpc())
{
  // print request id
  echo Request::getInstance()->getJsonRpcId();
  
  // print method
  echo Request::getInstance()->getJsonRpcMethod();

  // print params | array
  var_dump(Request::getInstance()->getJsonRpcParams());
}
```

## Response object

In the demand of talking [HTTP](http://www.w3.org/Protocols/rfc2616/rfc2616-sec6.html)? The response class does exactly that. You can use it to respond to a http request by sending:

- status codes (e.g. 200, 400, 500 ...)
- initiating a file download
- initiating a streaming process (chunking)
- return to referer
- json-rpc response
- json response
- html response
- text
- redirect to another address

### Examples

Here are a couple of examples. Have a look at the class to see all:

```php
// initiating file download
(new Response())->sendFile('/your/file/path/file.pdf', 'application/pdf');

// talk json-rpc
(new Response())->sendJsonRpc('result', ['name' => 'hansi'], 1);

// talk json
(new Response())->sendJson(['name' => 'hansi']);

// send status code
(new Response())->sendStatusCode(500);
```