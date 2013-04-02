<?php
/**
 * Barcode Snippet
 *
 * @package barcode
 * @subpackage snippet
 * @author Dave Shoreman <codeM0nK3Y@me.com>
 */

$barcode = $modx->getOption('code', $scriptProperties, '123412341234');

return include($modx->getOption('core_path') . 'components/barcode/elements/snippets/snippet.barcode.php');