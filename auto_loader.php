<?php
// Load environment variables from .env file
$config = parse_ini_file(__DIR__ . '/.env', true);
if ($config === false) {
    die('Error loading configuration file.');
}

// Get the current URL path
$current_path = $_SERVER['REQUEST_URI'];

// If file exists in public directory, serve it directly
$public_file = __DIR__ . '/public' . $current_path;
if (file_exists($public_file) && is_file($public_file)) {
    if (pathinfo($public_file, PATHINFO_EXTENSION) === 'css') {
        header('Content-Type: text/css');
    } else {
        header('Content-Type: ' . mime_content_type($public_file));
    }
    readfile($public_file);
    exit;
}

// Split the path into segments
$path_segments = explode('/', trim($current_path, '/'));

// Set default page if no segment is provided
if(empty($path_segments[0])) {
    $path_segments[0] = 'home'; // Default to 'home' if no segment is found
}

// Reverse array so page is always first segment
$path_segments = array_reverse($path_segments);

// If segment has no extension, assume it's a page and add .php
if (!empty($path_segments[0]) && pathinfo($path_segments[0], PATHINFO_EXTENSION) === '') {
    $path_segments[0] .= '.php';
}
$page = array_shift($path_segments);

// If there are additional segments, treat them as subdirectories
if (!empty($path_segments)) {
    $path = __DIR__ . '/pages/' . implode('/', array_reverse($path_segments)) . '/' . $page;
} else {
    $path = __DIR__ . '/pages/' . $page;
}
$page_file = realpath($path);
// Check if the file exists and include it, otherwise show a 404 error
if (file_exists($page_file)) {
    include $page_file;
} else {
    http_response_code(404);
    $body = '<strong>404 Not Found</strong><p>Whoops! The page you are looking for does not exist.</p>';
    $body .= "<p>Current Path: {$current_path}</p>"; // Debugging line to show the attempted file path
    $body .= "<p>Page File: {$page_file}</p>"; // Debugging line to show the attempted file path
}