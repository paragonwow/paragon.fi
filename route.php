<?php
function redirect($path, $code = 302) {
  if ($code === 301) {
    header("HTTP/1.1 301 Moved Permanently");
  }
  header('Location: '. $path);
  exit;
}
$routes = json_decode(file_get_contents('./lookup_table.json'), TRUE);
$lookup_uri = ltrim($_SERVER['REQUEST_URI'], '/');

// Attempt to redirect old content paths to /node/%s.html.
if (isset($routes[$lookup_uri])) {
  $entry = $routes[$lookup_uri];
  $path = sprintf('/node/%s.html', $entry['nid']);

  if (!file_exists(__DIR__ . $path)) {
    redirect('/');
  }
  redirect($path);
}
// Attempt to redirect rest of the paths.
/*$parts = explode('/', $lookup_uri);
$whitelist = ['forum'];

if (in_array($parts[0], $whitelist)) {
  $path = sprintf('/%s/%s.html', $parts[0], $parts[1]);

  if (!file_exists(__DIR__ . $path)) {
    redirect('/');
  }
  redirect($path);
}*/
// Redirect to front page by default.
redirect('/');
