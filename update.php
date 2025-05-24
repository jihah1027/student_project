<?php
$conn = new mysqli("localhost", "root", "", "student_db");

$matric = $_POST['matric'];
$name = $_POST['name'];
$email = $_POST['email'];
$race = $_POST['race'];
$gender = $_POST['gender'];

// Handle image upload
$imageFileName = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = "uploads/";
    // Create uploads folder if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $tmpName = $_FILES['image']['tmp_name'];
    $originalName = basename($_FILES['image']['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array(strtolower($ext), $allowedExt)) {
        $newFileName = uniqid() . "." . $ext;
        $destination = $uploadDir . $newFileName;
        if (move_uploaded_file($tmpName, $destination)) {
            $imageFileName = $newFileName;
        }
    } else {
        echo "Invalid image file type. Allowed types: jpg, jpeg, png, gif.<br>";
    }
}

// Prepare the SQL update
$sql = "UPDATE student SET 
        name = ?, 
        email = ?, 
        race = ?, 
        gender = ?";

// Add image column only if a new image was uploaded
if ($imageFileName !== null) {
    $sql .= ", image = ?";
}

$sql .= " WHERE matric = ?";

$stmt = $conn->prepare($sql);

if ($imageFileName !== null) {
    $stmt->bind_param("sssssi", $name, $email, $race, $gender, $imageFileName, $matric);
} else {
    $stmt->bind_param("ssssi", $name, $email, $race, $gender, $matric);
}

if ($stmt->execute()) {
    echo "Record updated successfully. <a href='list.php'>Back to list</a>";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
