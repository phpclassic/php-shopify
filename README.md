# PHP Shopify SDK
PHPShopify is a simple SDK implementation of Shopify API. It helps accessing the API in an object oriented way. 

## Installation
Install with Composer
```shell
composer require phpclassic/php-shopify
```

>You may not be able to install using composer until a stable version is available. For the time being you can download the zip file and put the extracted folder into `vendor/phpclassic` folder and add the following code into your root `composer.json` file:

```
    "autoload": {
        "psr-4": {
            "PHPShopify\\": "vendor/phpclassic/php-shopify/lib/"
        }
    }
```

### Requirements
PHPShopify uses curl extension for handling http calls. So you need to have the curl extension installed and enabled with PHP.
>However if you prefer to use any other available package library for handling HTTP calls, you can easily do so by modifying 1 line in each of the `get()`, `post()`, `put()`, `delete()` methods in `PHPShopify\HttpRequestJson` class.

## Usage

You can use PHPShopify in a pretty simple object oriented way. 

#### Configure ShopifyClient SDK
If you are using your own private API, provide the ApiKey and Password. 

```php
$config = array(
    'ShopUrl' => 'yourshop.myshopify.com',
    'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
    'Password' => '***YOUR-PRIVATE-API-PASSWORD***',
);

PHPShopify\ShopifyClient::config($config);
```

For Third party apps, use the permanent access token.

```php
$config = array(
    'ShopUrl' => 'yourshop.myshopify.com',
    'AccessToken' => '***ACCESS-TOKEN-FOR-THIRD-PARTY-APP***',
);

PHPShopify\ShopifyClient::config($config);
```
##### How to get the permanent access token for a shop?
There is a AuthHelper class to help you getting the permanent access token from the shop using oAuth. 

1) First, you need to configure the client with additional parameter SharedSecret

```php
$config = array(
    'ShopUrl' => 'yourshop.myshopify.com',
    'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
    'SharedSecret' => '***YOUR-SHARED-SECRET***',
);

PHPShopify\ShopifyClient::config($config);
```

2) Create the authentication request 

> The redirect url must be white listed from your app admin as one of **Application Redirect URLs**.

```php
//your_authorize_url.php
$scopes = 'read_products,write_products,read_script_tags,write_script_tags';
//This is also valid
//$scopes = array('read_products','write_products','read_script_tags', 'write_script_tags'); 
$redirectUrl = 'https://yourappurl.com/your_redirect_url.php';

\PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl);
```

3) Get the access token when redirected back to the `$redirectUrl` after app authorization. 

```php
//your_redirect_url.php
PHPShopify\ShopifyClient::config($config);
$accessToken = \PHPShopify\AuthHelper::getAccessToken();
//Now store it in database or somewhere else
```

> You can use the same page for creating the request and getting the access token (redirect url). In that case just skip the 2nd parameter `$redirectUrl` while calling `createAuthRequest()` method. The AuthHelper class will do the rest for you.

```php
//your_authorize_and_redirect_url.php
PHPShopify\ShopifyClient::config($config);
$accessToken = \PHPShopify\AuthHelper::createAuthRequest($scopes);
//Now store it in database or somewhere else
```

#### Get the ShopifyClient SDK Object

```php
$shopify = new PHPShopify\ShopifyClient;
```

You can provide the configuration as a parameter while instantiating the object (if you didn't configure already by calling `config()` method)

```php
$shopify = new PHPShopify\ShopifyClient($config);
```

##### Now you can do `get()`, `post()`, `put()`, `delete()` calling the resources in the object oriented way. All resources are named as same as it is named in shopify API reference. (See the resource map below.) 
> All the requests returns an array (which can be a single resource array or an array of multiple resources) if succeeded. When no result is expected (for example a DELETE request), an empty array will be returned.

Get all product list (GET request)

```php
$products = $shopify->Product->get();
```

Get any specific product with ID (GET request)

```php
$productID = 23564666666;
$product = $shopify->Product($productID)->get();
```

You can also filter the results by using the url parameters (as specified by Shopify API Reference for each specific resource). 
For example get the list of cancelled orders after a specified date and time (and `fields` specifies the data columns for each row to be rendered) : 

```php
$params = array(
    'status' => 'cancelled',
    'created_at_min' => '2016-06-25T16:15:47-04:00',
    'fields' => 'id,line_items,name,total_price'
);

$orders = $shopify->Order->get($params);
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

Update an order (PUT Request)

```php
$updateInfo = array (
    "fulfillment_status" => "fulfilled",
);

$shopify->Order($orderID)->put($order);
```

Remove a WebHook (DELETE request)

```php
$webHookID = 453487303;

$shopify->WebHook($webHookID)->delete());
```


###The child resources can be used in a nested way.
> You must provide the ID of the parent resource when trying to get any child resource

For example, get the images of a product (GET request)

```php
$productID = 23564666666;
$productImages = $shopify->Product($productID)->Image->get();
```

Add a new address for a customer (POST Request)

```php
$address = array(
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

$shopify->Customer($customerID)->Address->post($address);
```

Create a fulfillment event (POST request)

```php
$fulfillmentEvent = array(
    "status" => "in_transit"
);

$shopify->Order($orderID)->Fulfillment($fulfillmentID)->Event->post($fulfillmentEvent);
```

Update a Blog article (PUT request)

```php
$blogID = 23564666666;
$articleID = 125336666;
$updateArtilceInfo = array(
    "title" => "My new Title",
    "author" => "Your name",
    "tags" => "Tags, Will Be, Updated",
    "body_html" => "<p>Look, I can even update through a web service.<\/p>",
);
$shopify->Blog($blogID)->Article($articleID)->put($updateArtilceInfo);
```

Delete any specific article from a specific blog (DELETE request)

```php
$blogArticle = $shopify->Blog($blogID)->Article($articleID)->delete();
```

### Resource Mapping
Some resources are available directly, some resources are only available through parent resources and a few resources can be accessed both ways. It is recommended that you see the details in the related Shopify API Reference page about each resource. Each resource name here is linked to related Shopify API Reference page.
> Use the resources only by listed resource map. Trying to get a resource directly which is only available through parent resource may end up with errors.

- [AbandonedCheckout](https://help.shopify.com/api/reference/abandoned_checkouts)
- [ApplicationCharge](https://help.shopify.com/api/reference/applicationcharge)
- [Blog](https://help.shopify.com/api/reference/blog/)
- Blog -> [Article](https://help.shopify.com/api/reference/article/)
- Blog -> Article -> [Event](https://help.shopify.com/api/reference/event/)
- Blog -> [Event](https://help.shopify.com/api/reference/event/)
- Blog -> [Metafield](https://help.shopify.com/api/reference/metafield)
- [CarrierService](https://help.shopify.com/api/reference/carrierservice/)
- [Collect](https://help.shopify.com/api/reference/collect/)
- [Comment](https://help.shopify.com/api/reference/comment/)
- Comment -> [Event](https://help.shopify.com/api/reference/event/)
- [Country](https://help.shopify.com/api/reference/country/)
- Country -> [Province](https://help.shopify.com/api/reference/province/)
- [CustomCollection]()
- CustomCollection -> [Event](https://help.shopify.com/api/reference/event/)
- CustomCollection -> [Metafield](https://help.shopify.com/api/reference/metafield)
- [Customer](https://help.shopify.com/api/reference/customer/)
- Customer -> [Address](https://help.shopify.com/api/reference/customeraddress/)
- Customer -> [Metafield](https://help.shopify.com/api/reference/metafield)
- [CustomerSavedSearch](https://help.shopify.com/api/reference/customersavedsearch/)
- CustomerSavedSearch -> [Customer](https://help.shopify.com/api/reference/customer/)
- [Discount](https://help.shopify.com/api/reference/discount) _(Shopify Plus Only)_
- [Event](https://help.shopify.com/api/reference/event/)
- [FulfillmentService](https://help.shopify.com/api/reference/fulfillmentservice)
- [GiftCard](https://help.shopify.com/api/reference/gift_card) _(Shopify Plus Only)_
- [Location](https://help.shopify.com/api/reference/location/) _(read only)_
- [Metafield](https://help.shopify.com/api/reference/metafield)
- [Multipass](https://help.shopify.com/api/reference/multipass) _(Shopify Plus Only, API not available yet)_
- [Order](https://help.shopify.com/api/reference/order)
- Order -> [Fulfillment](https://help.shopify.com/api/reference/fulfillment)
- Order -> Fulfillment -> [Event](https://help.shopify.com/api/reference/fulfillmentevent)
- Order -> [Risk](https://help.shopify.com/api/reference/order_risks)
- Order -> [Refund](https://help.shopify.com/api/reference/refund)
- Order -> [Transaction](https://help.shopify.com/api/reference/transaction)
- Order -> [Event](https://help.shopify.com/api/reference/event/)
- Order -> [Metafield](https://help.shopify.com/api/reference/metafield)
- [Page](https://help.shopify.com/api/reference/page)
- Page -> [Event](https://help.shopify.com/api/reference/event/)
- Page -> [Metafield](https://help.shopify.com/api/reference/metafield)
- [Policy](https://help.shopify.com/api/reference/policy) _(read only)_
- [Product](https://help.shopify.com/api/reference/product)
- Product -> [Image](https://help.shopify.com/api/reference/product_image)
- Product -> [Variant](https://help.shopify.com/api/reference/product_variant)
- Product -> Variant -> [Metafield](https://help.shopify.com/api/reference/metafield)
- Product -> [Event](https://help.shopify.com/api/reference/event/)
- Product -> [Metafield](https://help.shopify.com/api/reference/metafield)
- [RecurringApplicationCharge](https://help.shopify.com/api/reference/recurringapplicationcharge)
- RecurringApplicationCharge -> [UsageCharge](https://help.shopify.com/api/reference/usagecharge)
- [Redirect](https://help.shopify.com/api/reference/redirect)
- [ScriptTag](https://help.shopify.com/api/reference/scripttag)
- [ShippingZone](https://help.shopify.com/api/reference/shipping_zone) _(read only)_
- [Shop](https://help.shopify.com/api/reference/shop) _(read only)_
- [SmartCollection](https://help.shopify.com/api/reference/smartcollection)
- SmartCollection -> [Event](https://help.shopify.com/api/reference/event/)
- [Theme](https://help.shopify.com/api/reference/theme)
- Theme -> [Asset](https://help.shopify.com/api/reference/asset/)
- [User](https://help.shopify.com/api/reference/user) _(read only, Shopify Plus Only_
- [Webhook](https://help.shopify.com/api/reference/webhook)

### Custom Actions
There are several action methods which can be called without calling the `get()`, `post()`, `put()`, `delete()` methods directly, but eventually results in a custom call to one of those methods.

For example, get count of total projects
```php
$productCount = $shopify->Product->count();
```

Make an address default for the customer.
```php
$shopify->Customer($customerID)->Address($addressID)->makeDefault();
```

Search for customers with keyword "Bob" living in country "United States".
```php
$shopify->Customer->search("Bob country:United States");
```

#### Custom Actions List
The custom methods are specific to some resources which may not be available for other resources.  It is recommended that you see the details in the related Shopify API Reference page about each action. We will just list the available actions here with some brief info. each action name is linked to an example in Shopify API Reference which has more details information.

- _(Any resource type)_ ->
    - [count()](https://help.shopify.com/api/reference/product#count)
    Get a count of all the resources.
    Unlike all other actions, this function returns an integer value.

- Comment ->
    - [markSpam()](https://help.shopify.com/api/reference/comment#spam)
    Mark a Comment as spam
    - [markNotSpam()](https://help.shopify.com/api/reference/comment#not_spam)
    Mark a Comment as not spam
    - [approve()](https://help.shopify.com/api/reference/comment#approve)
    Approve a Comment
    - [remove()](https://help.shopify.com/api/reference/comment#remove)
    Remove a Comment
    - [restore()](https://help.shopify.com/api/reference/comment#restore)
    Restore a Comment
    
- Customer ->
    - [search()](https://help.shopify.com/api/reference/customer#search)
    Search for customers matching supplied query
    
- Customer -> Address ->
    - [makeDefault()](https://help.shopify.com/api/reference/customeraddress#default)
    Sets the address as default for the customer
    - [set($params)](https://help.shopify.com/api/reference/customeraddress#set)
    Perform bulk operations against a number of addresses
    
- Discount ->
    - [enable()]()
    Enable a discount
    - [disable()]()
    Disable a discount
    
- Fulfillment ->
    - [complete()](https://help.shopify.com/api/reference/fulfillment#complete)
    Complete a fulfillment
    - [open()](https://help.shopify.com/api/reference/fulfillment#open)
    Open a pending fulfillment
    - [cancel()](https://help.shopify.com/api/reference/fulfillment#cancel)
    Cancel a fulfillment
    
- GiftCard ->
    - [disable()](https://help.shopify.com/api/reference/gift_card#disable)
    Disable a gift card.
    - [search()](https://help.shopify.com/api/reference/gift_card#search)
    Search for gift cards matching supplied query

- Order -> Refund ->
    - [calculate()](https://help.shopify.com/api/reference/refund#calculate)
    Calculate a Refund.
    
- RecurringApplicationCharge -> 
    - [activate()](https://help.shopify.com/api/reference/recurringapplicationcharge#activate)
    Activate a recurring application charge
    - [customize($data)](https://help.shopify.com/api/reference/recurringapplicationcharge#customize)
    Customize a recurring application charge
    
- SmartCollection -> 
    - [sortOrder($params)](https://help.shopify.com/api/reference/smartcollection#order)
    Set the ordering type and/or the manual order of products in a smart collection
    
- User ->
    - [current()](https://help.shopify.com/api/reference/user#current)
    Get the current logged-in user

## Reference
- [Shopify API Reference](https://help.shopify.com/api/reference/)