<?php
include "Connection.php"; // Assuming Connection.php contains your database connection logic
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Check if message content is set
if (isset($_POST['messageContent'])) {
    // Get the text data from the POST request
    $message = $_POST['messageContent'];
    $sender = $_POST["sender"];
    $receiver = $_POST["receiver"];

    // Define the target directory
    $targetDirectory = "../Uploads/messageImage/";
    if (!isset($_POST["coversationId"])) {
        // $checkIfConversationId

        if (isset($_FILES["image"]) && $_FILES["image"] != null) {
            $uniqueImageName = uniqid("IMG-") . $_FILES["image"]["name"];
            $target_file = $targetDirectory . basename($uniqueImageName);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // echo json_encode(array("status" => 200, "message" => "Image uploaded successfully"));
                $convReturnData = [];
                $mkConversation = "INSERT INTO `conversation` (`created_user`, `participant_user1`, `participant_user2`) VALUES ('$sender', '$sender', '$receive')";
                $convResult = mysqli_query($conn, $mkConversation);
                if ($convResult) {
                    $last_id = mysqli_insert_id($conn);
                    $mkUserConverstionSql = "INSERT INTO `user_conversation` (`userId`,`conversation_id`) VALUES ('$sender','$last_id')";
                    $userConvResult = mysqli_query($conn, $mkUserConverstionSql);
                    $massegeSql = "INSERT INTO `message` (`conversation_id`, `sender_id`, `receiver_id`, `message_content`, `image`) VALUES ('$convId', '$sender', '$receiver', '$message',' $uniqueImageName')";
                    $messageResult = mysqli_query($conn, $massegeSql);
                    if ($messageResult) {
                        echo json_encode(array("status" => 200, "message" => "Conversation created and message with image sented successfully"));
                    }
                }
            }
        } else {

            $mkConversation = "INSERT INTO `conversation` (`created_user`, `participant_user1`, `participant_user2`) VALUES ('$sender', '$sender', '$receiver')";
            $convResult = mysqli_query($conn, $mkConversation);
            if (mysqli_affected_rows($conn) > 0) {
                $last_id = mysqli_insert_id($conn);
                $mkUserConverstionSql = "INSERT INTO `user_conversation` (`userId`,`conversation_id`) VALUES ('$sender','$last_id')";
                $userConvResult = mysqli_query($conn, $mkUserConverstionSql);
                $massegeSql = "INSERT INTO `message` (`conversation_id`, `sender_id`, `receiver_id`, `message_content`) VALUES ('$last_id', '$sender', '$receiver', '$message')";
                $messageResult = mysqli_query($conn, $massegeSql);
                if ($messageResult) {
                    echo json_encode(array("status" => 200, "message" => "Conversation created and message without image sented successfully"));
                }

            } else {
                echo json_encode(array("status" => 500, "message" => mysqli_error($conn)));
            }

        }

    } else {
        $conversationID = $_POST["coversationId"];
        if (isset($_FILES["image"]) && $_FILES["image"] != null) {
            $uniqueImageName = uniqid("IMG-") . $_FILES["image"]["name"];
            $target_file = $targetDirectory . basename($uniqueImageName);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $massegeSql = "INSERT INTO `message` (`conversation_id`, `sender_id`, `receiver_id`, `message_content`, `image`) VALUES ('$conversationID', '$sender', '$receiver', '$message',' $uniqueImageName')";
                $messageResult = mysqli_query($conn, $massegeSql);
                if ($messageResult) {
                    echo json_encode(array("status" => 200, "message" => "Only message with image sented successfully"));
                }
            }
        } else {

            $massegeSql = "INSERT INTO `message` (`conversation_id`, `sender_id`, `receiver_id`, `message_content`) VALUES ('$conversationID', '$sender', '$receiver', '$message')";
            $messageResult = mysqli_query($conn, $massegeSql);
            if ($messageResult) {
                echo json_encode(array("status" => 200, "message" => "Only message without image sent"));
            }
        }
    }

    // Send a response

} else {
    echo json_encode(array("status" => 404, "message" => "Something wrong happened"));
}
