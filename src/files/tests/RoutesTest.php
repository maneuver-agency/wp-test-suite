<?php

use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase {

  /**
   * Tests if all pages are accessible.
   */
  public function testPages() {
    $pages = get_pages();

    foreach ($pages as $page) {
      $permalink = get_permalink($page);
      $response = wp_remote_get($permalink);
      $status_code = wp_remote_retrieve_response_code($response);
      $this->assertEquals(200, $status_code, sprintf('The status code of the request to %s is not 200.', $permalink));
    }

  }

  /**
   * Tests if all posts are accessible.
   */
  public function testPosts() {
    $posts = get_posts();

    foreach ($posts as $post) {
      $permalink = get_permalink($post);
      $response = wp_remote_get($permalink);
      $status_code = wp_remote_retrieve_response_code($response);
      $this->assertEquals(200, $status_code, sprintf('The status code of the request to %s is not 200.', $permalink));
    }

  }

  public function testTimberRoutes() {
    if (class_exists('Routes')) {
      global $timber_routes;

      if (!empty($timber_routes)) {
        foreach ($timber_routes as $name => $route) {
          if (strstr($route, ':lang')) {

            if (function_exists('pll_default_language')) {
              $lang = pll_default_language();
            } else {
              $lang = substr(get_bloginfo('language'), 0, 2);
            }

            $route = str_replace(':lang', $lang, $route);
          }

          $route = home_url($route);

          $response = wp_remote_get($route);
          $status_code = wp_remote_retrieve_response_code($response);
          $this->assertEquals(200, $status_code, sprintf('The status code of the request to %s is not 200.', $route));
        }
      }
    }
  }
}