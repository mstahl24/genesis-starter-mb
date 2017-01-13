<?php
/**
 * Page defaults
 *
 */
namespace Mockingbird\Developers;

//* Add Custom Content Areas
// add_action( 'genesis_entry_content', __NAMESPACE__. '\custom_content_insert', 1 );
function custom_content_insert() {


	echo "content test";

}

genesis();