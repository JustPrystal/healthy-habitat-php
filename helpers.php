<?php
function get_project_root_url()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];

    // Grab the path to the project root
    $projectPath = explode('/', $_SERVER['SCRIPT_NAME']); // e.g., ['', 'healthy-habitat-php', 'Blocks', 'sme', 'vote.php']
    $projectBase = $projectPath[1] ?? ''; // 'healthy-habitat-php'

    return $protocol . $host . '/' . $projectBase . '/';
}
?>