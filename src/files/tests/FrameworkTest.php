<?php

use PHPUnit\Framework\TestCase;

class FrameworkTest extends TestCase {

  /**
   * Unit test for mf_get_frontpage().
   */
  public function testGetFrontpage() {
    $front = mf_get_frontpage();
    $this->assertEquals(get_class($front), Mnvr\Page::class);

    $id = get_option( 'page_on_front' );
    $this->assertEquals($id, $front->id);
  }

  /**
   * Unit test for mf_get_archive_url_for_posttype().
   */
  public function testGetArchiveUrlForPosttype() {
    $archive = mf_get_archive_url_for_posttype('post');
    $this->assertArrayHasKey('link', $archive);
  }

  /**
   * Unit test for mf_get_custom_class().
   */
  public function testGetCustomClass() {
    $this->assertEquals(mf_get_custom_class('post'), Mnvr\Post::class);
  }

  /**
   * Unit test for mf_retrieve().
   */
  public function testRetrieve() {
    $posts = mf_retrieve('all posts');

    $this->assertInternalType('array', $posts);
    $this->assertNotEmpty($posts);
    $this->assertEquals(get_class($posts[0]), Mnvr\Post::class);
  }

  /**
   * Unit test for mf_retrieve_count().
   */
  public function testRetrieveCount() {
    $count = mf_retrieve_count('all posts');

    $this->assertTrue(is_numeric($count));
  }
}