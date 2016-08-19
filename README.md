# PHP Shopify SDK
PHPShopify is a simple SDK implementation of Shopify API. It helps accessing the API in an object oriented way. 

## Installation
PHPShopify is composer supported but still not sumitted to packagist. For the time being you can download and put this into `vendor/phpclassic` folder and add the following code into your `composer.json` file:

```
    "autoload": {
        "psr-4": {
            "PHPShopify\\": "vendor/phpclassic/php-shopify/lib/"
        }
    }
```

### Requirements
PHPShopify uses CURL extension for handling http calls to the API. So you need to be have enabled the curl extension.

## Usage

PHPShopify is developed in a fully object oriented way. Usage is very simple. 

#### Configure
If you are using your own private API, provide the ApiKey and Password. For Third party apps, use the permanent access token which you have got from the app.

```php
<?php
$config = array(
    'ShopUrl' => 'yourshop.myshopify.com',
    'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
    'Password' => '***YOUR-PRIVATE-API-PASSWORD',
);
```

Or

```php
<?php
$config = array(
    'ShopUrl' => 'yourshop.myshopify.com',
    'AccessToken' => '***ACCESS-TOKEN-FOR-THIRD-PARTY-APPS***',
);
```

#### Get the ShopifyClient SDK Object

```php
$shopify = new PHPShopify\ShopifyClient($config);
```

##### Now just have fun using the SDK using the object oriented way. All objects are named as same as it is named in shopify API reference and you can GET, POST, PUT, DELETE accordingly. 

For example getting all product list:

```php
$products = $shopify->Product->get();
```

GET any specific product with ID

```php
$productID = 23564666666;
$product = $shopify->Product($productID)->get();
```

The child resources can be used in a nested way. For example, get the images of a product

```php
$productID = 23564666666;
$productImages = $shopify->Product($productID)->Image->get();
```

Or GET any specific article from a specific blog like this

```php
$blogID = 23564666666;
$articleID = 125336666;
$blogArticle = $shopify->Blog($blogID)->Article($articleID)->get();
```

Create a new order (POST Request)

```php
$order = array (
    "email" => "foo@example.com",
    "fulfillment_status" => "unfulfilled",
    "line_items" => [
      [
          "variant_id" => 27535413959,
          "quantity" => 5
      ]
    ]
);

$shopify->Order->post($order);
```

Update a customer address (PUT Request)

```php
$updatedAddress = array(
    "address1" => "129 Oak St",
    "city" => "Ottawa",
    "province" => "ON",
    "phone" => "555-1212",
    "zip" => "123 ABC",
    "last_name" => "Lastnameson",
    "first_name" => "Mother",
    "country" => "CA",
);

$customerID = 4425749127;
$addressID = 225663355;

$shopify->Customer($customerID)->Address($addressID)->put($updatedAddress);
```

DELETE a WebHook

```php
$webHookID = 453487303;

$shopify->WebHook($webHookID)->delete());
```

#Reference
- [Shopify API Reference](https://help.shopify.com/api/reference/)