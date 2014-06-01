<?php

namespace GoWeb\Api\Model;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \GoWeb\Api\Model\Client 
     */
    private $_client;
    
    public function setUp()
    {
        $this->_client = new Client(array(
            "permid" => "a709fa2cca2e7f5016778547fd77313fa92a39de140421055948127",
            "token" => "df179b1916726da38232592b6fc555ce0a17b787",
            "status" => 0,
            "balance" => array(
                "amount" => 5,
                "currency" => "EUR"
            ),
            "profile" => array(
                "id" => 48127,
                "email" => "mayhem@ukr.net",
                "hash" => "ead8a383b4d52384f8962b427fc7db79a6457b7b",
                "contract_number" => "00048127",
                "status" => "ACTIVE"
            ),
            "baseServices" => array(
                array(
                    "id" => 45588,
                    "service_id" => 6,
                    "name" => "Рекламний",
                    "custom_name" => "Послуга№45588",
                    "cost" => 0,
                    "chargeoff_period" => "DAILY",
                    "status" => "ACTIVE",
                    "catchup" => 0,
                    "ad" => 1,
                    "total_cost" => 0,
                    "total_monthly_cost" => 0
                ),
                array(
                    "id" => 45589,
                    "service_id" => 9,
                    "name" => "Домашний",
                    "custom_name" => "Послуга№45589",
                    "cost" => 0.033,
                    "chargeoff_period" => "DAILY",
                    "status" => "ACTIVE",
                    "catchup" => 1,
                    "ad" => 0,
                    "total_cost" => 0.033,
                    "total_monthly_cost" => 0.99
                ),
                array(
                    "id" => 45590,
                    "service_id" => 6,
                    "name" => "Рекламний",
                    "custom_name" => "Послуга№45590",
                    "cost" => 0,
                    "chargeoff_period" => "DAILY",
                    "status" => "ACTIVE",
                    "catchup" => 0,
                    "ad" => 1,
                    "total_cost" => 0,
                    "total_monthly_cost" => 0
                )
            ),
        ));
    }
    
    public function testGetActiveClientBaseServiceId()
    {
        $this->assertEquals(45589, $this->_client->getActiveClientBaseServiceId());
    }
}
