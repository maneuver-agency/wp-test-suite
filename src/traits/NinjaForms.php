<?php

namespace Maneuver\WpTestSuite\Traits;

trait NinjaForms {

  public function getForm($form_id) {
    return Ninja_Forms()->form($form_id)->get();
  }

  public function getFields($form_id) {
    return Ninja_Forms()->form($form_id)->get_fields();
  }

  public function getActions($form_id) {
    return Ninja_Forms()->form($form_id)->get_actions();
  }

  public function getSubmissions($form_id) {
    return Ninja_Forms()->form($form_id)->get_subs();
  }

  public function fillAllNinjaFormFields($session, $form_id) {
    $form = $session->getPage()->find('css', '#nf-form-'. $form_id .'-cont');
    if (empty($form)) {
      throw new Exception("Form $form_id not found on the page.");
    }

    $fields = $this->getFields($form_id);
    $values = [];
    $faker = Faker\Factory::create();

    foreach ($fields as $field) {
      $id = $field->get_setting('id');
      $type = $field->get_setting('type');
      $label = strtolower($field->get_setting('label'));
      $value = '';

      if ($type == 'submit') {
        continue;
      }

      if (empty($value)) {
        try {
          $value = $faker->$label;
        } catch(\Exception $e) {}
      }
      
      if (empty($value)) {
        try {
          $value = $faker->$type;
        } catch(\Exception $e) {}
      }

      if (empty($value)) {
        switch ($type) {
          case 'textarea':
            $value = $faker->text;
            break;
          default:
            $value = $faker->word;
        }
      }

      $values[$id] = $value;
    }

    foreach ($values as $field_id => $value) {
      $session->getPage()->fillField('nf-field-' . $field_id, $value);
    }

    return $values;
  }

  public function submitNinjaForm(&$session, $form_id) {
    $fields = $this->getFields($form_id);
    $submit_id = null;

    // Find submit button.
    foreach ($fields as $field) {
      if ($field->get_setting('type') == 'submit') {
        $submit_id = $field->get_setting('id');
      }
    }

    // Press submit button.
    // The Element->submit() method doesn't work with NinjaForms.
    if ($submit_id) {
      $session->getPage()->pressButton('nf-field-' . $submit_id);
    }

    // Wait for AJAX call to finish.
    $session->wait(5000);
  }

  public function assertNinjaFormSuccessMessage($session, $form_id) {
    $actions = $this->getActions($form_id);

    $message = '';

    foreach ($actions as $action) {
      if ($action->get_setting('type') == 'successmessage') {
        $message = $action->get_setting('success_msg');
      }
    }

    $message = trim(preg_replace('/\s+/u', ' ', $message), ' ');

    if ($message) {
      $msg_el = $session->getPage()->find('css', '.nf-response-msg');
      $this->assertContains($message, $msg_el->getText());
    }
  }

  public function assertNinjaFormSubmission($form_id, $field_values) {
    $subs = $this->getSubmissions($form_id);
    $sub = reset($subs);

    foreach ($field_values as $field_id => $value) {
      $this->assertEquals($value, $sub->get_field_value($field_id));
    }
  }
}