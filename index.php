
<?php
$name = $usn = $email = $phone = "";
$department = $semester = $address = "";
$errors = [];
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $usn = trim($_POST["usn"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $department = trim($_POST["department"] ?? "");
    $semester = trim($_POST["semester"] ?? "");
    $address = trim($_POST["address"] ?? "");

    // Server-side validation
    if ($name === "" || !preg_match("/^[a-zA-Z ]{3,50}$/", $name)) {
        $errors[] = "Enter a valid name (3-50 letters).";
    }

    if (!preg_match("/^[a-zA-Z0-9-]{5,20}$/", $usn)) {
        $errors[] = "Enter a valid USN.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must contain 10 digits.";
    }

    $allowedDepartments = ["CSE", "ISE", "ECE", "EEE", "ME", "CIVIL"];

    if (!in_array($department, $allowedDepartments, true)) {
        $errors[] = "Select a valid department.";
    }

    if (!in_array($semester, ["1","2","3","4","5","6","7","8"], true)) {
        $errors[] = "Select a valid semester.";
    }

    if ($address === "" || strlen($address) > 300) {
        $errors[] = "Enter an address (maximum 300 characters).";
    }

    if (empty($errors)) {
        $submitted = true;
    }
}

// Escape output to prevent HTML injection
function safe($value) {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<?php if ($submitted): ?>

    <div class="success-icon">✓</div>
    <h1>Registration Successful!</h1>
    <p class="subtitle">Your application has been submitted successfully.</p>

    <div class="details">
        <h2>Student Registration Details</h2>

        <p><strong>Name:</strong> <?= safe($name) ?></p>
        <p><strong>USN:</strong> <?= safe($usn) ?></p>
        <p><strong>Email:</strong> <?= safe($email) ?></p>
        <p><strong>Phone:</strong> <?= safe($phone) ?></p>
        <p><strong>Department:</strong> <?= safe($department) ?></p>
        <p><strong>Semester:</strong> <?= safe($semester) ?></p>
        <p><strong>Address:</strong> <?= nl2br(safe($address)) ?></p>
    </div>

    <button onclick="window.print()" class="print-btn">
        Print Confirmation
    </button>

    <a href="index.php" class="back-btn">New Registration</a>

<?php else: ?>

    <h1>Student Registration Form</h1>
    <p class="subtitle">Enter your details to complete registration</p>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <p><?= safe($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form id="registrationForm" method="POST" action="index.php" novalidate>

        <label>Full Name</label>
        <input type="text" name="name" id="name"
            placeholder="Enter your full name"
            value="<?= safe($name) ?>" required>

        <label>USN</label>
        <input type="text" name="usn" id="usn"
            placeholder="Enter your USN"
            value="<?= safe($usn) ?>" required>

        <label>Email Address</label>
        <input type="email" name="email" id="email"
            placeholder="Enter your email"
            value="<?= safe($email) ?>" required>

        <label>Phone Number</label>
        <input type="tel" name="phone" id="phone"
            placeholder="10-digit phone number"
            value="<?= safe($phone) ?>" required>

        <label>Department</label>
        <select name="department" id="department" required>
            <option value="">Select Department</option>
            <?php
            $departments = ["CSE","ISE","ECE","EEE","ME","CIVIL"];
            foreach ($departments as $d):
            ?>
            <option value="<?= $d ?>"
                <?= $department === $d ? "selected" : "" ?>>
                <?= $d ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Semester</label>
        <select name="semester" id="semester" required>
            <option value="">Select Semester</option>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?= $i ?>"
                    <?= $semester === (string)$i ? "selected" : "" ?>>
                    <?= $i ?> Semester
                </option>
            <?php endfor; ?>
        </select>

        <label>Address</label>
        <textarea name="address" id="address"
            placeholder="Enter your address"
            required><?= safe($address) ?></textarea>

        <button type="submit">Submit Registration</button>

    </form>

<?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="script.js"></script>

</body>
</html>
