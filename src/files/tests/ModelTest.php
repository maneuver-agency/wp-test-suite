<?php

use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase {

  public function testPost() {

    if (function_exists('mf_create_custom_classes')) {

      $post = get_posts([
        'post_type' => 'post',
        'numberposts' => 1,
      ]);

      if (!empty($post)) {
        mf_create_custom_classes($post);
        $this->assertEquals(get_class(reset($post)), Mnvr\Post::class);
      }

    }
  }

  public function testPage() {

    if (function_exists('mf_create_custom_classes')) {

      $post = get_posts([
        'post_type' => 'page',
        'numberposts' => 1,
      ]);

      if (!empty($post)) {
        mf_create_custom_classes($post);
        $this->assertEquals(get_class(reset($post)), Mnvr\Page::class);
      }

    }
  }

}