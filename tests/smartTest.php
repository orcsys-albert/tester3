<?php
declare(strict_types=1);
use Smart\smartsmsClass;

use PHPUnit\Framework\TestCase;

#[AllowDynamicProperties]
class smartTest extends PHPUnit\Framework\TestCase
{
	private $response;
	protected function setUp(): void
	{
		$this->smartclass = new smartsmsClass();
		$to = "233242925729";
		$content = "Testing at ".date('Y-m-d H:i:s');
		$this->response = $this->smartclass->sendSms($to,$content);
	}

	public function test_credentials_are_in_env(){
		$this->assertIsString(getenv('SMARTSMS_USERNAME'));
		$this->assertIsString(getenv('SMARTSMS_PASSWORD'));
	}

    public function test_can_send_sms()
    {
		$this->assertArrayHasKey("status", $this->response);
		
    }
   
	public function test_can_send_sms_successfully()
    {
       $this->assertEquals("success", $this->response['status']);
    }

	public function test_customer_name(){
		$name = $this->smartclass->getPatientData(2);
		$this->assertEquals("albert", $name);
	}
}