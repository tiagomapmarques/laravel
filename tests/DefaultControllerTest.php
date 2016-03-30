<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DefaultControllerTest extends TestCase {
	/**
	 * Test the reponse of the home page
	 *
	 * @return void
	 */
	public function testResponse() {
		$this->visit('/')
			->assertResponseOk();
	}

	/**
	 * Test main content of the home page.
	 *
	 * @return void
	 */
	public function testContent() {
		$this->visit('/')
			->see('Laravel Up and Running Kit');
	}

	/**
	 * Test that menu exists through the search form
	 *
	 * @return void
	 */
	public function testMenu() {
		$text = 'LURK is comming';
		$final_uri = $this->baseUrl.'/search?q='.str_replace(' ','+',$text);
		try {
			$this->visit('/')
				->type($text, 'q')
				->press('Submit');
		}
		catch(\Exception $e) {
			if(strpos($e->getMessage(),'A request to ['.$final_uri.'] failed. Received status code [404]')<0) {
				throw $e;
			}
		}
		$this->assertEquals($this->currentUri,$final_uri);
	}
}
