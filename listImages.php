<?php
$folder = $_GET['folder'] ?? '';

if (!is_dir($folder)) {
    echo json_encode(['images' => []]);
    exit;
}

$images = [];
foreach (glob($folder . "*.jpg") as $filename) {
    $images[] = $filename;
}

echo json_encode(['images' => $images]);
?>