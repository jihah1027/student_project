<?php
$conn = new mysqli("localhost", "root", "", "student_db");

$matric = $_GET['matric'];
$result = $conn->query("SELECT * FROM student WHERE matric = $matric");
$row = $result->fetch_assoc();
?>

<form action="update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="matric" value="<?= $row['matric'] ?>">
    Name: <input type="text" name="name" value="<?= $row['name'] ?>"><br>
    Email: <input type="email" name="email" value="<?= $row['email'] ?>"><br>
    Race: 
    <select name="race">
        <option value="Malay" <?= ($row['race'] == 'Malay') ? 'selected' : '' ?>>Malay</option>
        <option value="Chinese" <?= ($row['race'] == 'Chinese') ? 'selected' : '' ?>>Chinese</option>
        <option value="Indian" <?= ($row['race'] == 'Indian') ? 'selected' : '' ?>>Indian</option>
    </select><br>
    Gender:
    <input type="radio" name="gender" value="Male" <?= ($row['gender'] == 'Male') ? 'checked' : '' ?>> Male
    <input type="radio" name="gender" value="Female" <?= ($row['gender'] == 'Female') ? 'checked' : '' ?>> Female<br>
    
    Current Image:<br>
    <?php if (!empty($row['image'])): ?>
        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Student Image" style="max-width:150px;"><br>
    <?php else: ?>
        No image uploaded.<br>
    <?php endif; ?>

    Upload New Image: <input type="file" name="image"><br>
    <input type="submit" value="Update">
</form>
