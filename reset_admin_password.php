<?php
require_once('include/config.php');

// New password to set
$newPassword = 'admin123';  // You can change this to your desired password
$email = 'admin@example.com';

try {
    // Check if admin exists
    $stmt = $dbh->prepare("SELECT id FROM tbladmin WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Admin exists, update password
        $hashedPassword = md5($newPassword);
        $update = $dbh->prepare("UPDATE tbladmin SET password = :password WHERE email = :email");
        $update->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $update->bindParam(':email', $email, PDO::PARAM_STR);
        
        if ($update->execute()) {
            echo "<h3>Password updated successfully!</h3>";
            echo "<p>Email: $email</p>";
            echo "<p>New Password: $newPassword</p>";
            echo "<p><a href='admin/login.php'>Go to Admin Login</a></p>";
        } else {
            echo "<p>Error updating password.</p>";
        }
    } else {
        echo "<p>No admin found with email: $email</p>";
        echo "<p>Creating new admin account...</p>";
        
        // Create new admin account
        $name = 'Administrator';
        $mobile = '1234567890';
        $hashedPassword = md5($newPassword);
        
        $sql = "INSERT INTO tbladmin (name, email, mobile, password, create_date) 
                VALUES (:name, :email, :mobile, :password, NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        
        if ($query->execute()) {
            echo "<h3>New admin account created successfully!</h3>";
            echo "<p>Email: $email</p>";
            echo "<p>Password: $newPassword</p>";
            echo "<p><a href='admin/login.php'>Go to Admin Login</a></p>";
        } else {
            echo "Error creating admin account.";
        }
    }
    
} catch (PDOException $e) {
    echo "<h3>Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    
    // Show additional debug info
    echo "<h4>Debug Info:</h4>";
    echo "<pre>Check if the database 'gymdb' exists and contains the 'tbladmin' table.</pre>";
}
?>
