<?php
declare(strict_types=1);
use Smart\smartsmsClass;

use PHPUnit\Framework\TestCase;

class smartTest extends PHPUnit\Framework\TestCase
{
	private $response;
	protected function setUp(): void
	{
		$this->smartclass = new smartsmsClass();
		$to = "233242925729";
		$content = "Testing at ".microtime();
		$this->response = $this->smartclass->sendSms($to,$content);
	}

    public function test_can_send_sms()
    {
		$this->assertArrayHasKey("status", $this->response);
		
    }
   
	public function test_can_send_sms_successfully()
    {
       $this->assertEquals("success", $this->response['status']);
    }
}