<?php
/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at: 9/9/16 12:38 PM UTC+06:00
 */

namespace PHPShopify;

class TestSimpleResource extends TestResource
{

    public $resourceName;
    public $errorPostArray;
    public $postArray;
    public $putArray;

    public function __construct()
    {
        $this->resourceName = preg_replace('/.+\\\\(\w+)Test$/', '$1', get_called_class());
        parent::__construct();
    }

    public function testPost()
    {
        if ($this->postArray) {
            $result = static::$shopify->{$this->resourceName}->post($this->postArray);
            $this->assertTrue(is_array($result));
            $this->assertNotEmpty($result);
            return $result['id'];
        }
    }

    /**
     * @depends testPost
     */
    public function testGet()
    {
        $resource = static::$shopify->{$this->resourceName};
        $result = $resource->get();

        $this->assertTrue(is_array($result));
        //Data posted, so cannot be empty
        if($this->postArray) {
            $this->assertNotEmpty($result);
        }
        if($resource->countEnabled) {
            //Count should match the result array count
            $count = static::$shopify->{$this->resourceName}->count();
            $this->assertEquals($count, count($result));
        }
    }

    /**
     * @depends testPost
     */
    public function testGetSelf($id)
    {
        if ($id) {
            $product = static::$shopify->{$this->resourceName}($id)->get();

            $this->assertTrue(is_array($product));
            $this->assertNotEmpty($product);
            $this->assertEquals($id, $product['id']);
        }
    }

    /**
     * @depends testPost
     */
    public function testPut($id)
    {
        if ($this->putArray) {
            $result = static::$shopify->{$this->resourceName}($id)->put($this->putArray);
            $this->assertTrue(is_array($result));
            $this->assertNotEmpty($result);
            foreach($this->putArray as $key => $value) {
                $this->assertEquals($value, $result[$key]);
            }
        }
    }

    /**
     * @depends testPost
     */
    public function testDelete($id)
    {
        if ($id) {
            $result = static::$shopify->{$this->resourceName}($id)->delete();
            $this->assertEmpty($result);
        }
    }

    public function testPostError() {
        if ($this->errorPostArray) {
            $this->expectException('PHPShopify\\Exception\\ApiException');
            static::$shopify->{$this->resourceName}->post($this->errorPostArray);
        }
    }
}
