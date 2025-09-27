<?php

namespace PHPShopify;

class GraphQLTest extends TestResource
{
    /**
     * GraphQLTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    
    /**
     * GraphQL Query Test
     */
    public function testQuery()
    {
        $graphQL = <<<Query
        query {
            shop {
                name
                primaryDomain {
                  url
                  host
                }
            }
        }
        Query;

        $return = static::$shopify->GraphQL->post($graphQL);
        
        $this->assertNotEmpty($return['data']['shop']);
    }


}
