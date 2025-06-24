<?php
require_once('include/config.php');

try {
    // Check if admin table exists
    $stmt = $dbh->query("SHOW TABLES LIKE 'tbladmin'");
    $tableExists = $stmt->rowCount() > 0;
    
    if (!$tableExists) {
        die("Error: The 'tbladmin' table does not exist in the database. Please import the SQL file first.");
    }
    
    // Check admin accounts
    $stmt = $dbh->query("SELECT * FROM tbladmin");
    $adminCount = $stmt->rowCount();
    
    if ($adminCount === 0) {
        // Create a default admin account
        $email = 'admin@example.com';
        $password = md5('admin123'); // Default password
        $name = 'Administrator';
        $mobile = '1234567890';
        
        $sql = "INSERT INTO tbladmin (name, email, mobile, password, create_date) 
                VALUES (:name, :email, :mobile, :password, NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        
        if ($query->execute()) {
            echo "<h3>Default admin account created successfully!</h3>";
            echo "<p>Email: admin@example.com</p>";
            echo "<p>Password: admin123</p>";
            echo "<p><a href='admin/login.php'>Go to Admin Login</a></p>";
        } else {
            echo "Error creating admin account.";
        }
    } else {
        // Show existing admin accounts
        echo "<h3>Existing Admin Accounts:</h3>";
        echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p>If you forgot your password, you can reset it using the following SQL command in phpMyAdmin or MySQL command line:</p>";
        echo "<pre>UPDATE tbladmin SET password = MD5('newpassword') WHERE email = 'admin@example.com';</pre>";
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?>
