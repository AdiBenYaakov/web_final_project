<?php
// פרטי התחברות למסד הנתונים 
$server_name="127.0.0.1";
$user_name="adibe5_adi"; // לשנות בהתאם לפרטי המשתמש שלכם
$password="Adi050697"; // לשנות בהתאם לפרטי המשתמש שלכם
$database_name="adibe5_project"; // לשנות בהתאם לפרטי המשתמש שלכם

// יצירת חיבור 
$conn = new mysqli($server_name, $user_name, $password, $database_name);

// בדיקת חיבור 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// קליטת המידע מהטופס (לפי ה-name שהגדרנו ב-HTML) 
$tripName     = $_POST['tripName'];
$fullName     = $_POST['userName'];
$visitDate    = $_POST['visitDate'];
$requiredItem = $_POST['requiredItem'];
$rating       = $_POST['userRating']; // מספר שלם (Integer)
$review       = $_POST['userReview'];

// הכנת השאילתה עם סימני שאלה (Prepared Statement) 
$sql = "INSERT INTO `reviews` 
        (`tripName`, `userName`, `visitDate`, `requiredItem`, `userRating`, `userReview`) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// קישור המשתנים לשאילתה (ssssis - חמש מחרוזות ומספר שלם אחד) 
$stmt->bind_param("ssssis", 
    $tripName, 
    $fullName, 
    $visitDate, 
    $requiredItem, 
    $rating, 
    $review
);

// הרצה ובדיקה 
if ($stmt->execute()) {
    $success = true;
} else {
    echo "Error: " . $stmt->error;
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Response | Trailify</title>
    <link rel="stylesheet" type="text/css" href="../css/trip-details.css">
</head>
<body>
    <div class="container">
        <div class="success-message">
            <h2>ההמלצה נוספה בהצלחה!</h2>
            <p>תודה, <?php echo htmlspecialchars($fullName); ?>. ההמלצה שלך על <strong><?php echo htmlspecialchars($tripName); ?></strong> נשמרה במערכת.</p>
            <br>
            <a href="trips.html" class="btn btn-primary">חזרה לטיולים</a>
        </div>
    </div>
</body>
</html>