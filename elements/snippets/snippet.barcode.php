<?php
/**
 * Barcode Snippet controller
 *
 * @package barcode
 * @subpackage snippet
 * @version 1.0
 * @author Dave Shoreman <codeM0nK3Y@me.com>
 */

// First of all, check we have a valid code.
// The library adds the 13th digit automatically
if ($barcode != (int) $barcode
	 || strlen($barcode) < 12
	 || strlen($barcode) > 13)
	return 'Barcode must be a 12 digit number - the 13th digit is added automatically.';

if (strlen($barcode) == 13) $barcode = substr($barcode, 0, 12);

$path = $modx->getOption('core_path') . 'components/barcode/';
$assets_path = $modx->getOption('assets_path');
$assets_url = $modx->getOption('assets_url');

$dir = 'barcodes';
$filename = $barcode . '.png';
$imgSrc = null;

// Check if barcodes dir exists, or try to create it
if (!is_dir($assets_path . $dir) && !mkdir($assets_path . $dir))
	return 'Failed to find or create "/path/to/modx/assets/barcodes" directory';

// Check to see if the barcode has been created already
if (file_exists($assets_path . $dir . '/' . $filename))
	$imgSrc = $assets_url . $dir . '/' . $filename;
else
{
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

	$drawing = new BCGDrawing($assets_path . $dir . '/' . $filename, $color_bg);
	if ($drawException)
		$drawing->drawException($drawException);
	else
	{
		$drawing->setBarcode($code);
		$drawing->draw();
	}

	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

	// Check everything went well
	if (file_exists($assets_path . $dir . '/' . $filename))
		$imgSrc = $assets_url . $dir . '/' . $filename;
	else
		return 'Failed to create barcode';
}
return $imgSrc
 ? '<img src="' . $imgSrc . '" style="border: 0;" />'
 : 'Unknown error';