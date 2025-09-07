<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if ($data) {
        // Сохраняем в файл
        $filename = 'applications.json';
        $currentData = [];
        
        if (file_exists($filename)) {
            $currentData = json_decode(file_get_contents($filename), true) ?: [];
        }
        
        $currentData[] = $data;
        file_put_contents($filename, json_encode($currentData, JSON_PRETTY_PRINT));
        
        echo json_encode(['success' => true]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filename = 'applications.json';
    
    if (file_exists($filename)) {
        $data = file_get_contents($filename);
        echo $data;
    } else {
        echo json_encode([]);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request']);