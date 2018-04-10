<?php

namespace Maneuver\WpTestSuite;

use PHPUnit\Framework\TestCase;
use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;

class BrowserTestCase extends TestCase {

  /**
   * @var ChromeDriver
   */
  protected $driver;

  public function setUp() {
    $chromeUrl = 'http://localhost:9222';
    $this->driver = new ChromeDriver($chromeUrl, NULL, home_url());
  }

  /**
   * @return Session
   */
  protected function startSession() {
    $session = new Session($this->driver);
    $session->start();

    return $session;
  }
}