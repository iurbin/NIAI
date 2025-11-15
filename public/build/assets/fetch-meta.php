<?php
// Set the content type to application/json so JS knows what to expect
header('Content-Type: application/json');

// Get the JSON data sent from JavaScript
$input = json_decode(file_get_contents('php://input'), true);
$url = $input['url'] ?? null;

// --- Utility function to send a JSON error ---
function send_json_error($message) {
    echo json_encode(['success' => false, 'error' => $message]);
    exit;
}

// 1. --- Validate the URL ---
if (!$url) {
    send_json_error('No URL provided.');
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    send_json_error('Invalid URL format.');
}

// 2. --- Fetch the HTML content using cURL ---
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the transfer as a string
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);         // 10 second timeout
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'); // Pretend to be a browser
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypasses SSL cert verification (use with caution)
curl_setopt($ch, CURLOPT_HEADER, false);

$html = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code != 200 || !$html) {
    send_json_error("Failed to retrieve content (HTTP Code: {$http_code}).");
}

// 3. --- Parse the HTML with DOMDocument ---
// We use @ to suppress warnings from malformed HTML
$doc = new DOMDocument();
@$doc->loadHTML($html);
$xpath = new DOMXPath($doc);

// --- Utility function to get a meta tag's 'content' attribute ---
function get_meta_property($xpath, $property) {
    // Queries for <meta property="og:title" content="...">
    // OR <meta name="description" content="...">
    $query = "//meta[@property='{$property}']/@content | //meta[@name='{$property}']/@content";
    $nodes = $xpath->query($query);
    return $nodes->length > 0 ? $nodes->item(0)->nodeValue : null;
}

// 4. --- Extract the data ---
// Get Title
$title_node = $xpath->query('//title')->item(0);
$title = $title_node ? trim($title_node->nodeValue) : null;
$og_title = utf8_decode(get_meta_property($xpath, 'og:title'));

// Get Description
$description = get_meta_property($xpath, 'description');
$og_description = utf8_decode(get_meta_property($xpath, 'og:description'));

// Get Image
$og_image = get_meta_property($xpath, 'og:image');

// 5. --- Consolidate and clean the data ---
$final_data = [
    'title' => $og_title ?: $title ?: 'No title found',
    'description' => $og_description ?: $description ?: 'No description found',
    'image' => $og_image,
];

// Fix relative image URLs (e.g., /images/foo.jpg)
if ($final_data['image'] && (strpos($final_data['image'], 'http') !== 0 && strpos($final_data['image'], '//') !== 0)) {
    $url_parts = parse_url($url);
    $base_url = $url_parts['scheme'] . '://' . $url_parts['host'];
    
    // Check if the image path is root-relative (starts with /)
    if (substr($final_data['image'], 0, 1) === '/') {
        $final_data['image'] = rtrim($base_url, '/') . $final_data['image'];
    } else {
        // Handle path-relative (e.g., images/foo.jpg)
        $path = dirname($url_parts['path'] ?? '/');
        $final_data['image'] = rtrim($base_url, '/') . '/' . ltrim($path, '/') . '/' . $final_data['image'];
    }
}

// 6. --- Send the successful response ---
echo json_encode(['success' => true] + $final_data);