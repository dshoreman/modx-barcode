<?php
$path = $modx->getOption('core_path') . 'components/barcode/';
require_once($path . 'lib/BCGFontFile.php');
require_once($path . 'lib/BCGColor.php');
require_once($path . 'lib/BCGDrawing.php');
require_once($path . 'lib/BCGean13.barcode.php');

$font = new BCGFontFile($path . 'lib/font/Arial.ttf', 18);

$color_fg = new BCGColor(0, 0, 0);
$color_bg = new BCGColor(255, 255, 255);

$drawException = null;
try
{
	$code = new BCGean13();
	$code->setScale(2);
	$code->setThickness(30);
	$code->setForegroundColor($color_fg);
	$code->setBackgroundColor($color_bg);
	$code->setFont($font);
	$code->parse($barcode);
}
catch (Exception $e)
{
	$drawException = $e;
}

$drawing = new BCGDrawing($path . 'barcodes/output.png', $color_bg);
if ($drawException)
	$drawing->drawException($drawException);
else
{
	$drawing->setBarcode($code);
	$drawing->draw();
}

$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

return '<img src="' . $modx->getOption('site_url') . 'core/components/barcode/barcodes/output.png" style="border: 0;" />';