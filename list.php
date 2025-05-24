<?php
$conn = new mysqli("localhost", "root", "", "student_db");

$filter = "";
if (!empty($_GET['race'])) {
    $race = $_GET['race'];
    $filter = "WHERE race = '$race'";
} elseif (!empty($_GET['gender'])) {
    $gender = $_GET['gender'];
    $filter = "WHERE gender = '$gender'";
}

$result = $conn->query("SELECT * FROM student $filter");
?>

<form method="get">
    Search by Race:
    <select name="race">
        <option value="">--Choose--</option>
        <option value="Malay" <?= (isset($_GET['race']) && $_GET['race'] == 'Malay') ? 'selected' : '' ?>>Malay</option>
        <option value="Chinese" <?= (isset($_GET['race']) && $_GET['race'] == 'Chinese') ? 'selected' : '' ?>>Chinese</option>
        <option value="Indian" <?= (isset($_GET['race']) && $_GET['race'] == 'Indian') ? 'selected' : '' ?>>Indian</option>
    </select>
    OR Gender:
    <select name="gender">
        <option value="">--Choose--</option>
        <option value="Male" <?= (isset($_GET['gender']) && $_GET['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= (isset($_GET['gender']) && $_GET['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
    </select>
    <input type="submit" value="Search">
</form>

<table border="1">
    <tr>
        <th>Matric</th><th>Name</th><th>Email</th><th>Race</th><th>Gender</th><th>Image</th><th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['matric']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['race']) ?></td>
        <td><?= htmlspecialchars($row['gender']) ?></td>
        <td>
            <?php if (!empty($row['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Student Image" style="max-width:80px;">
            <?php else: ?>
                No Image
            <?php endif; ?>
        </td>
        <td><a href="edit.php?matric=<?= $row['matric'] ?>">Edit</a></td>
    </tr>
    <?php endwhile; ?>
</table>
