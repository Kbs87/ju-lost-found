<?php
// includes/db.php
$host = 'localhost';
$dbname = 'jimma_lost_found';
$username = 'root';
$password = ''; // Default XAMPP/WAMP password is usually empty

try {
    // First connect without specifying a database to ensure we can create it if missing
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Create database if it doesn't exist
    $createSql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($createSql);

    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // If the core table doesn't exist, try importing schema from database.sql
    $check = $pdo->query("SHOW TABLES LIKE 'items'");
    $tableExists = ($check && $check->fetch() !== false);
    if (!$tableExists) {
        $schemaFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database.sql';
        if (file_exists($schemaFile) && is_readable($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            // Remove common SQL comments
            $lines = explode("\n", $sql);
            $clean = '';
            $inCommentBlock = false;
            foreach ($lines as $line) {
                $trim = trim($line);
                if ($trim === '') continue;
                if (strpos($trim, '/*') === 0) { $inCommentBlock = true; continue; }
                if ($inCommentBlock) { if (strpos($trim, '*/') !== false) { $inCommentBlock = false; } continue; }
                if (strpos($trim, '--') === 0) continue;
                $clean .= $line . "\n";
            }

            // Split statements by semicolon and execute
            $statements = array_filter(array_map('trim', explode(';', $clean)));
            foreach ($statements as $statement) {
                if ($statement === '') continue;
                try {
                    $pdo->exec($statement);
                } catch (PDOException $e) {
                    // ignore individual statement errors but continue
                }
            }
        }
    }
} catch (PDOException $e) {
    // In production, log this error instead of echoing
    die("Connection failed: " . $e->getMessage());
}
?>
