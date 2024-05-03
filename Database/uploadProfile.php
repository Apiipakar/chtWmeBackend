<?php
include "Connection.php";
$target_dir = "../Uploads/";
$uniqueImageName = uniqid("IMG-") . $_FILES["image"]["name"];
$target_file = $target_dir . basename($uniqueImageName);
$userId = $_POST["userId"];

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $sql = "UPDATE user  SET profile_image = '$uniqueImageName' WHERE id = $userId";
    $result = mysqli_query($conn, $sql);
    // if ($stmt->execute()) {
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode(array("status" => 200, "message" => "Image uploaded successfully", "user" => $userId));
    } else {
        echo json_encode(array("status" => 500, "message" => "Failed to update profile image in database"));
    }
    // $stmt->close();
} else {
    echo json_encode(array("status" => 500, "message" => "Failed to upload image"));
}
