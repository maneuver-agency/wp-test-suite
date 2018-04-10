<?php

use Maneuver\WpTestSuite\BrowserTestCase;
use Maneuver\WpTestSuite\Traits\NinjaForms;

class BrowserTest extends BrowserTestCase {

  use NinjaForms;

  // public function testHome() {
  //   $session = $this->startSession();
  //   $session->visit(home_url('/'));

  //   $page = $session->getPage();

  //   $this->assertTrue($page->hasContent('lorem ipsum'));
  // }

  public function testForm() {
    $session = $this->startSession();
    $session->visit(home_url('/'));

    $form_id = 1;

    $values = $this->fillAllNinjaFormFields($session, $form_id);
    $this->submitNinjaForm($session, $form_id);

    $this->assertNinjaFormSuccessMessage($session, $form_id);
    $this->assertNinjaFormSubmission($form_id, $values);
  }
}