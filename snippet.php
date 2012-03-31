<?php
$barcode = $modx->getOption('code', $scriptProperties, '123412341234');

return include($modx->getOption('core_path') . 'components/barcode/elements/snippets/snippet.barcode.php');