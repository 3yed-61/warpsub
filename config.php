<?php
// Define the URL where the new IPs and ports will be fetched from
$sourceUrl = 'https://raw.githubusercontent.com/3yed-61/warp-ip/main/export/warp-ip';

// Define the path to the configuration file and the output path
$configFilePath = '/config_file.json';
$outputFilePath = 'export/warp.json';

// Fetch the new IPs and ports
$newData = file_get_contents($sourceUrl);
if ($newData === FALSE) {
    die("Error fetching new IPs and ports.");
}

// Assume the new data is in the format:
// IP1:PORT1
// IP2:PORT2
list($newIP1, $newPort1, $newIP2, $newPort2) = explode("\n", trim($newData));

// Read the existing configuration file
$config = file_get_contents($configFilePath);
if ($config === FALSE) {
    die("Error reading configuration file.");
}

// Replace the IP addresses and ports in the configuration
// Modify the regex pattern to match the exact format in your config
$updatedConfig = preg_replace(
    ['/(\d{1,3}\.){3}\d{1,3}:\d{4}/', '/(\d{1,3}\.){3}\d{1,3}:\d{4}/'],
    [$newIP1 . ':' . $newPort1, $newIP2 . ':' . $newPort2],
    $config,
    2
);

// Save the updated configuration to the output file
if (!file_put_contents($outputFilePath, $updatedConfig)) {
    die("Error saving updated configuration.");
}

echo "Configuration updated successfully.";
