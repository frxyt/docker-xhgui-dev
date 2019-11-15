<?php

if ($_SERVER['XHGUI_PROFILING'] && \file_exists('/xhgui/vendor/perftools/xhgui-collector/external/header.php')) {
    require_once('/xhgui/vendor/perftools/xhgui-collector/external/header.php');
}

// Your real application code goes there...
// Let's just use a good old ASCII Art generator! (idea from: https://gist.github.com/donatj/1353237)

$id=$_GET['id'] ? intval($_GET['id']): 357;
if(!is_integer($id) || $id < 1) {
    $id = 1;
}
$file = 'https://picsum.photos/id/' . $id . '/800/600';

$img = imagecreatefromstring(file_get_contents($file));
list($width, $height) = getimagesize($file);

$scale = 10;

$chars = "#0XT|:.' ";

$c_count = strlen($chars);

echo '<html><head><title>frxyt/xhgui-dev test</title></head><body><pre>';

for($y = 0; $y <= $height - $scale - 1; $y += $scale) {
	for($x = 0; $x <= $width - ($scale / 2) - 1; $x += ($scale / 2)) {
		$rgb = imagecolorat($img, $x, $y);
		$r = (($rgb >> 16) & 0xFF);
		$g = (($rgb >> 8) & 0xFF);
		$b = ($rgb & 0xFF);
		$sat = ($r + $g + $b) / (255 * 3);
		echo $chars[ (int)( $sat * ($c_count - 1) ) ];
	}
	echo PHP_EOL;
}

echo '</pre><a href="/?id=' . ($id - 1) . '">&lt;</a> <a href="' . $file . '">' . $id . '</a> <a href="/?id=' . ($id + 1) . '">&gt;</a></body></html>';