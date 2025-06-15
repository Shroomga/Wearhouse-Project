<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database backup script
$backup_dir = __DIR__ . '/backups';
$backup_file = $backup_dir . '/wearhousedb_' . date("Y-m-d_H-i-s") . '.sql';

// Create backups directory if it doesn't exist
if (!file_exists($backup_dir)) {
    if (!mkdir($backup_dir, 0777, true)) {
        die("Failed to create backup directory: " . $backup_dir);
    }
}

// Database credentials
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'wearhousedb';

// Check if mysqldump is available
$mysqldump_path = 'mysqldump';
if (PHP_OS === 'WINNT') {
    // For Windows, try to find mysqldump in common locations
    $possible_paths = [
        'C:\\xampp\\mysql\\bin\\mysqldump.exe',
        'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
        'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe'
    ];
    
    foreach ($possible_paths as $path) {
        if (file_exists($path)) {
            $mysqldump_path = $path;
            break;
        }
    }
}

// Construct the mysqldump command
$command = sprintf(
    '"%s" --host=%s --user=%s --password=%s %s > %s 2>&1',
    $mysqldump_path,
    escapeshellarg($db_host),
    escapeshellarg($db_user),
    escapeshellarg($db_pass),
    escapeshellarg($db_name),
    escapeshellarg($backup_file)
);

// Log the command (without password) for debugging
$log_file = $backup_dir . '/backup_log.txt';
$log_message = date('Y-m-d H:i:s') . " - Attempting backup with command: " . 
               str_replace($db_pass, '****', $command) . "\n";
file_put_contents($log_file, $log_message, FILE_APPEND);

// Execute backup
$output = [];
$return_var = 0;
exec($command, $output, $return_var);

// Log the backup attempt
$log_message = date('Y-m-d H:i:s') . " - Backup " . ($return_var === 0 ? "successful" : "failed") . 
               " - File: " . basename($backup_file) . " - Return code: " . $return_var . "\n";
if (!empty($output)) {
    $log_message .= "Output:\n" . implode("\n", $output) . "\n";
}
file_put_contents($log_file, $log_message, FILE_APPEND);

if ($return_var === 0) {
    echo "Database backup completed successfully.<br>";
    echo "Backup file: " . $backup_file . "<br>";
    echo "Backup size: " . round(filesize($backup_file) / 1024, 2) . " KB<br>";
} else {
    echo "Error creating database backup.<br>";
    echo "Error code: " . $return_var . "<br>";
    echo "mysqldump path: " . $mysqldump_path . "<br>";
    if (!empty($output)) {
        echo "Error details:<br>";
        echo "<pre>";
        print_r($output);
        echo "</pre>";
    }
    
    // Additional debugging information
    echo "<br>System Information:<br>";
    echo "PHP Version: " . PHP_VERSION . "<br>";
    echo "Operating System: " . PHP_OS . "<br>";
    echo "Current Directory: " . __DIR__ . "<br>";
    echo "Backup Directory: " . $backup_dir . "<br>";
    echo "Backup Directory Writable: " . (is_writable($backup_dir) ? 'Yes' : 'No') . "<br>";
    echo "mysqldump exists: " . (file_exists($mysqldump_path) ? 'Yes' : 'No') . "<br>";
}
?> 