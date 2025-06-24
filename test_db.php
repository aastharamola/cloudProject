<?php
// Database configuration
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','gymdb');

echo "<h2>Testing Database Connection</h2>";

try {
    // Create connection
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style='color: green;'>✓ Successfully connected to the database</div>";
    
    // List all tables
    echo "<h3>Database Tables:</h3>";
    $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        // Check if admin table exists and has data
        if (in_array('tbladmin', $tables)) {
            $stmt = $conn->query("SELECT COUNT(*) as count FROM tbladmin");
            $adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "<div>Admin accounts: $adminCount</div>";
        }
    } else {
        echo "<div style='color: red;'>No tables found in the database. Please import the SQL file.</div>";
    }
    
} catch(PDOException $e) {
    echo "<div style='color: red;'>Connection failed: " . $e->getMessage() . "</div>";
    
    // Provide helpful troubleshooting steps
    echo "<h3>Troubleshooting:</h3>";
    echo "<ol>";
    echo "<li>Make sure MySQL server is running in XAMPP/WAMP</li>";
    echo "<li>Verify the database 'gymdb' exists in phpMyAdmin</li>";
    echo "<li>Check if the username and password in config.php are correct</li>";
    echo "<li>If the database doesn't exist, import the SQL file from the 'SQL File' folder</li>";
    echo "</ol>";
}
?>
