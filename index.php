<?php
require_once('lib/BCGFontFile.php');
require_once('lib/BCGColor.php');
require_once('lib/BCGDrawing.php');
require_once('lib/BCGean13.barcode.php');

$font = new BCGFontFile('lib/font/Arial.ttf', 18);

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
	$code->parse('468758556789');
}
catch (Exception $e)
{
	$drawException = $e;
}

$drawing = new BCGDrawing('barcodes/output.png', $color_bg);
if ($drawException)
	$drawing->drawException($drawException);
else
{
	$drawing->setBarcode($code);
	$drawing->draw();
}

$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
?>
<img src="barcodes/output.png" />