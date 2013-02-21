<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\core\Libraries;

require __DIR__ . '/bootstrap/connections.php';

Libraries::paths(array(
	'phpunit' => array(
		'{:library}\tests\{:namespace}\{:class}\{:name}Test'
	)
));

?>