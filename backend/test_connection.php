<?php
include 'db.php';

if ($conn) {
    echo "✅ Connection to the database was successful!";
} else {
    echo "❌ Failed to connect to the database.";
}
?>
