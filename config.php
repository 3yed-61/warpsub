<?php
// Define the URL where the new IPs and ports will be fetched from
$sourceUrl = 'https://raw.githubusercontent.com/3yed-61/warp-ip/main/export/warp-ip';

// Define the path to the configuration file and the output path
$configFilePath = '/config_file.json'; // Update this path
$outputFilePath = 'export/warp-s.json';

// Fetch the new IPs and ports
$newData = file_get_contents($sourceUrl);
if ($newData === FALSE) {
    die("Error fetching new IPs and ports.");
}

// Assume the new data is in the format:
// IP1:PORT1\nIP2:PORT2
$newLines = explode("\n", trim($newData));
if (count($newLines) < 2) {
    die("Error: Not enough IP:PORT pairs provided.");
}

// Split the first and second IP:PORT pairs
list($newIP1, $newPort1) = explode(':', $newLines[0]);
list($newIP2, $newPort2) = explode(':', $newLines[1]);

// Read the existing configuration file
$config = file_get_contents($configFilePath);
if ($config === FALSE) {
    die("Error reading configuration file.");
}

// Replace the IP addresses and ports in the configuration
// Regex assumes IP:PORT format and replaces only the first two occurrences
$updatedConfig = preg_replace(
    ['/(\d{1,3}\.){3}\d{1,3}:\d+/', '/(\d{1,3}\.){3}\d{1,3}:\d+/'],
    [$newIP1 . ':' . $newPort1, $newIP2 . ':' . $newPort2],
    $config,
    2
);

// Save the updated configuration to the output file
if (!file_put_contents($outputFilePath, $updatedConfig)) {
    die("Error saving updated configuration.");
}

echo "Configuration updated successfully.";
?>
