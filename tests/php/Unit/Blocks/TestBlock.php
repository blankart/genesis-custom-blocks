<?php
/**
 * Tests for class Block.
 *
 * @package Genesis\CustomBlocks
 */

use Genesis\CustomBlocks\Blocks;

/**
 * Tests for class Block.
 */
class TestBlock extends \WP_UnitTestCase {

	/**
	 * The instance to test.
	 *
	 * @var Blocks\Block
	 */
	public $instance;

	/**
	 * A mock JSON blob for the block.
	 *
	 * @var string
	 */
	const JSON = '
	{
		"genesis-custom-blocks\\/simple-test-block": {
			"name": "simple-test-block",
			"title": "Simple Test Block",
			"icon": "genesis_custom_blocks",
			"category": "common",
			"keywords": [
				"keywords",
				"go",
				"here"
			],
			"fields": {
				"heading": {
					"name": "heading",
					"label": "Heading",
					"control": "text",
					"type": "string",
					"location": "editor",
					"order": 0,
					"help": "",
					"default": "",
					"placeholder": "",
					"maxlength": null
				},
				"content": {
					"name": "content",
					"label": "Content",
					"control": "textarea",
					"type": "textarea",
					"location": "editor",
					"order": 1,
					"help": "",
					"default": "",
					"placeholder": "",
					"maxlength": null,
					"number_rows": 4,
					"new_lines": "autop"
				}
			}
		}
	}
	';

	/**
	 * Setup.
	 *
	 * @inheritdoc
	 */
	public function setUp() {
		parent::setUp();

		$post = $this->factory()->post->create(
			[
				'post_title' => 'Simple Test Block',
				'post_name'  => 'simple-test-block',
				'post_type'  => 'genesis_custom_block',
			]
		);

		$this->instance = new Blocks\Block( $post );
	}

	/**
	 * Test __construct.
	 *
	 * @covers \Genesis\CustomBlocks\Blocks\Block::__construct()
	 */
	public function test_construct() {
		$this->assertEquals( 'simple-test-block', $this->instance->name );
	}

	/**
	 * Test from_json.
	 *
	 * @covers \Genesis\CustomBlocks\Blocks\Block::from_json()
	 */
	public function test_from_json() {
		$this->instance->from_json( self::JSON );

		// Check all the base attributes.
		$this->assertEquals( 'Simple Test Block', $this->instance->title );
		$this->assertEquals( 'genesis_custom_blocks', $this->instance->icon );
		$this->assertEquals(
			[
				'icon'  => null,
				'slug'  => 'common',
				'title' => 'Common',
			],
			$this->instance->category
		);
		$this->assertEquals( [ 'keywords', 'go', 'here' ], $this->instance->keywords );

		// Check that we've got 2 fields.
		$this->assertCount( 2, $this->instance->fields );
		$this->assertArrayHasKey( 'heading', $this->instance->fields );
		$this->assertArrayHasKey( 'content', $this->instance->fields );
	}

	/**
	 * Test to_json.
	 *
	 * @covers \Genesis\CustomBlocks\Blocks\Block::to_json()
	 */
	public function test_to_json() {
		$this->instance->from_json( self::JSON );
		$json = $this->instance->to_json();

		$decoded = json_decode( $json, true );
		$this->assertArrayHasKey( 'genesis-custom-blocks/simple-test-block', $decoded );

		// Check all the base attributes.
		$block = $decoded['genesis-custom-blocks/simple-test-block'];
		$this->assertArrayHasKey( 'name', $block );
		$this->assertArrayHasKey( 'title', $block );
		$this->assertArrayHasKey( 'icon', $block );
		$this->assertArrayHasKey( 'category', $block );
		$this->assertArrayHasKey( 'keywords', $block );
		$this->assertArrayHasKey( 'fields', $block );
		$this->assertFalse( $block['displayModal'] );

		// Check that we've got 2 fields.
		$this->assertCount( 2, $block['fields'] );
		$this->assertArrayHasKey( 'heading', $block['fields'] );
		$this->assertArrayHasKey( 'content', $block['fields'] );
	}
}
