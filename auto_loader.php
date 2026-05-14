<?php
// Get the current URL path
$current_path = $_SERVER['REQUEST_URI'];

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
if (file_exists($path)) {
    // Return file directly if it's not a PHP file (e.g., CSS, JS, images)
    if(pathinfo($page_file, PATHINFO_EXTENSION) !== 'php') {
        header('Content-Type: ' . mime_content_type($page_file));
        readfile($page_file);
        exit;
    }
    include $page_file;
} else {
    http_response_code(404);
    $body = '<strong>404 Not Found</strong><p>Whoops! The page you are looking for does not exist.</p>';
}