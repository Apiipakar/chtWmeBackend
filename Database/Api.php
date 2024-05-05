<?php

//allowr cors and origin header.
// Set the allowed origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include "./Connection.php";

$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);
$action = isset($data) ? $data['action'] : $_POST["action"];

// Check if the request is JSON or HTTP multipart
$contentType = $_SERVER["CONTENT_TYPE"];

if (strpos($contentType, "application/json") !== false) {
    // JSON request
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    // Check if data was successfully decoded from JSON
    if ($data !== null) {
        // If action is provided in the JSON data, use it, otherwise fallback to $_POST["action"]
        $action = isset($data['action']) ? $data['action'] : $_POST["action"];

        // You can perform further actions based on $action if needed
    } else {
        // If JSON decoding fails, fallback to $_POST["action"]
        $action = $_POST["action"];
    }
} elseif (strpos($contentType, "multipart/form-data") !== false) {
    // HTTP multipart request
    // Access uploaded files and other form data using $_FILES and $_POST arrays
    // Example:
    $action = isset($_POST['action']) ? $_POST['action'] : null;
} else {
    // Unsupported content type
    // Handle error or return an appropriate response
}

function getCounts($conn)
{
    $userCountSql = "SELECT COUNT(*) usersCount FROM user";
    $onlinUsersSql = "SELECT COUNT(*) onlineUsers FROM  user  WHERE isOnline = 1";
    $groupCountSql = "SELECT COUNT(*) TotalGrops FROM groupp";
    $resultCountUser = mysqli_query($conn, $userCountSql);
    $resultOnlineUsers = mysqli_query($conn, $onlinUsersSql);
    $resultCountGroups = mysqli_query($conn, $groupCountSql);
    $data = [];
    while ($row = mysqli_fetch_assoc($resultCountUser)) {
        $data[] = $row;
    }

    while ($row1 = mysqli_fetch_assoc($resultOnlineUsers)) {
        $data[] = $row1;
    }

    while ($row2 = mysqli_fetch_assoc($resultCountGroups)) {
        $data[] = $row2;
    }
    echo json_encode($data);
}

//creat user function.
function createUser($conn)
{
    global $data;

    $fullname = $data['fullname'] ?? $_POST["fullname"] ?? null;
    $username = $data['username'] ?? $_POST["username"] ?? null;
    $email = $data['email'] ?? $_POST["email"] ?? null;
    $phoneNumber = $data['phone_number'] ?? $_POST["phone_number"] ?? null;
    $password = $data['password'] ?? $_POST["password"] ?? null;

// Check if all required fields are provided
    if ($fullname === null || $username === null || $email === null || $phoneNumber === null || $password === null) {
        echo json_encode(array("status" => 400, "message" => "Required fields not found"));
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user(fullname, username, email, phone_number, password) values('$fullname', '$username', '$email','$phoneNumber', '$hashed_password')";

        $checkSql = "select * from user where email = '$email' or phone_number = '$phoneNumber'";
        $checkResult = mysqli_query($conn, $checkSql);
        if (mysqli_num_rows($checkResult) > 0) {
            echo json_encode(array("status" => 400, "message" => "Email or phone number already exists."));
        } else {
            $result = mysqli_query($conn, $sql);
            echo json_encode(array("status" => 200, "message" => "Successfully created user."));
        }
    }
}
//login user
function userLogin($conn)
{
    global $data;
    $phoneNumber = isset($data) ? $data['phone_number'] : $_POST["phone_number"];
    // $email = isset($data) ? $data['email'] : $_POST["email"];
    $password = isset($data) ? $data['password'] : $_POST["password"];

    $sql = "SELECT * FROM user where phone_number = '$phoneNumber'";

    $result = mysqli_query($conn, $sql);
    $data1 = [];
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedHashedPassword = $row["password"];
        $data1[] = $row;

        if (password_verify($password, $storedHashedPassword)) {
            echo json_encode(array("status" => 200, "message" => "Successfully Logged in", "user" => $data1));
        } else {
            echo json_encode(array("status" => 404, "message" => "invalid Password"));
        }

        // echo json_encode($data1);
    } else {
        echo json_encode(array("status" => 404, "message" => "user with entered phone number is not found."));
    }

}

//add profile user profileImage.
function updateUserProfile($conn)
{
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profileImage"]["name"]);
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
        // Image saved successfully
        // Now, you can store $target_file (image path) in your database
        // Perform database operations to insert $target_file into your database
        // Return a response to the Flutter app indicating success
        echo json_encode(["success" => true, "message" => "Image uploaded successfully"]);
    } else {
        // Failed to save image
        echo json_encode(["success" => false, "message" => "Failed to upload image"]);
    }

}
//admin login user.
function AdminLogin($conn)
{
    // $jsonData = file_get_contents("php://input");
    // $data = json_decode($jsonData, true);
    global $data;

    $email = isset($data) ? $data['email'] : $_POST["email"];
    $password = isset($data) ? $data['password'] : $_POST["password"];
    $sql = "select * from admin where email = '" . $email . "' and password= '" . $password . "'";
    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1 = $row;
            session_start();
            $_SESSION["adminId"] = $row["id"];
            $_SESSION["AdminName"] = $row["fullname"];
            $_SESSION["AdminUsername"] = $row["username"];
            echo json_encode(array("status" => 200, "data" => "Successfull logged in"));
        }
    } else {
        echo json_encode(array("status" => 404, "data" => "Invalid Credentials."));
    }
}

function currentUser($conn)
{
    global $data;
    $id = isset($data) ? $data["id"] : $_POST["id"];
    $sql = "SELECT * FROM user where id = '$id'";
    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $data1));
    } else {
        echo json_encode(array("status" => 404, "message" => "user not found"));
    }
}

function updateUserInfo($conn)
{
    global $data;
    $id = isset($data) ? $data["userId"] : $_POST["userId"];
    $fullname = isset($data) ? $data["fullname"] : $_POST["fullname"];
    $username = isset($data) ? $data["username"] : $_POST["username"];
    $email = isset($data) ? $data["email"] : $_POST["email"];
    $bio = isset($data) ? $data["bio"] : $_POST["bio"];
    $sql = "UPDATE user set fullname = '$fullname', email = '$email', username = '$username', bio = '$bio' where id = '$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode(array("status" => 200, "message" => "User information updated successfully"));
    } else {
        echo json_encode(array("status" => 404, "message" => "Couln't update user information"));
    }
}
function ListMostUsersSentMessage($conn)
{
    global $data;
    $sql = "
    SELECT distinct  u.id as userId, u.fullname,
    (SELECT COUNT(*) FROM `message` WHERE sender = u.id) AS message_count
    FROM `message` m
    JOIN `user` u ON m.sender = u.id order by message_count desc  LIMIT 10
    ";

    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $data1));
    } else {
        echo json_encode(array("status" => 400, "data" => "No record found."));
    }
}

//get all users
function getAllUsers($conn)
{

    global $data;
    $sql = "SELECT * FROM user";
    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $data1));
    } else {
        echo json_encode(array("status" => 400, "data" => "No record found."));
    }

}

//get all users by mobile.
function loadAllUsers($conn)
{
    global $data;
    $txtSearch = $data['txtSearch'] ?? $_POST["txtSearch"] ?? null;
    $userId = isset($data) ? $data['userId'] : $_POST["userId"];
    $userData = [];
    $sql = "";
    if ($txtSearch === "") {
        // echo "there is no search";
        // $sql = "select * from user where id <> '$userId'";
        $sql = "SELECT * FROM `user` t1 where id <> '$userId' and NOT EXISTS ( SELECT * FROM `friend` f WHERE t1.id = f.friendId and f.user = '$userId')";
    } else {
        // $sql = "select id,fullname,email,username,phone_number,profile_image,bio,last_seen from user where fullname like '%$txtSearch%' or email like '%$txtSearch%' or phone_number like '%$txtSearch%' and id <> '$userId'";
        $sql = "SELECT * FROM `user` t1 where id <> '$userId' and t1.fullname like '%$txtSearch%' or t1.phone_number like '%$txtSearch%' and NOT EXISTS ( SELECT * FROM `friend` f WHERE t1.id = f.friendId and f.user = '$userId')";
    }
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userData[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $userData));
    } else {
        echo json_encode(array("status" => 404, "data" => "No user found" . mysqli_error($conn)));
    }
}

//get friends
function Loadfriends($conn)
{
    global $data;
    $txtSearch = $data['txtSearch'] ?? $_POST["txtSearch"] ?? null;
    $userId = isset($data) ? $data['userId'] : $_POST["userId"];
    $sql = "";
    if ($txtSearch === "") {
        $sql = "SELECT u.id,u.phone_number,u.fullname,u.username,u.email,u.last_seen,u.isOnline,u.profile_image FROM `friend` f join `user` u on f.friendId = u.id where f.user = '$userId'";
    } else {
        $sql = "SELECT Distinct u.id,u.phone_number,u.fullname,u.username,u.email,u.last_seen,u.isOnline,u.profile_image FROM `friend` f join
        `user` u on f.friendId = u.id where f.user = '$userId' and u.fullname like '%$txtSearch%' or u.phone_number like '%$txtSearch%'";
    }
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userData[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $userData));
    } else {
        echo json_encode(array("status" => 404, "data" => "No Friend found" . mysqli_error($conn)));
    }

}
//update last seen.
function updateLastSeen($conn)
{
    global $data;
    $currentUser = isset($data) ? $data["currentUser"] : $_POST["currentUser"];
    $lastDate = isset($data) ? $data["lastDate"] : $_POST["lastDate"];
    $sql = "UPDATE user set last_seen ='$lastDate' where id = '$currentUser' ";
    $result = mysqli_query($conn, $sql);
    if ($result === true) {
        echo json_encode(array("status" => 200, "message" => "successfully updated Last seen"));
    } else {
        echo json_encode(array("status" => 404, "message" => "Couldn't update Last seen"));
    }

}
//upload userprofile image.
function uploadUserProfileImage($conn)
{
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    //test http multipar
    function heloo($conn)
    {
        echo "working";
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

//check if user is friend.
function checkIsFriend($conn)
{
    global $data;
    $currentUser = isset($data) ? $data["currentUser"] : $_POST["currentUser"];
    $friendId = isset($data) ? $data["friendId"] : $_POST["friendId"];
    $sql = "SELECT * FROM friend WHERE user = '$currentUser' and  friendId = $friendId And isFriend = 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(array("status" => 200, "message" => "yes is friend!"));
    } else {
        echo json_encode(array("status" => 404, "message" => "No is not friend!"));
    }
}
//add friend
function addFriend($conn)
{
    global $data;
    $currentUser = isset($data) ? $data["currentUser"] : $_POST["currentUser"];
    $friendId = isset($data) ? $data["friendId"] : $_POST["friendId"];
    $sql = "insert into friend(user, friendId, isFriend) values('$currentUser', '$friendId', 1)";
    $result = mysqli_query($conn, $sql);
    if ($result === true) {
        echo json_encode(array("status" => 200, "message" => "Freind Added Successfully"));
    } else {
        echo json_encode(array("status" => 404, "message" => "Unable to add Friend!" . mysqli_error($conn)));
    }
}

function searchUser($conn)
{
    global $data;
    $sText = isset($data) ? $data["sText"] : $_POST["sText"];
    $sql = "SELECT * FROM user where fullname like '%$sText%' or email like '%$sText%' or phone_number like '%$sText%'";
    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $data1));
    } else {
        echo json_encode(array("status" => 404, "data" => "No record found."));
    }

}

function loadUserGroups($conn)
{
    global $data;
    $id = isset($data) ? $data["id"] : $_POST["id"];
    $txtSearch = isset($data) ? $data["txtSearch"] : $_POST["txtSearch"];
    $sql = null;
    if ($txtSearch == null) {
        $sql = "SELECT
        ug.group_id groupId,
        g.group_name groupName,
        g.group_image groupImage,
        gm.message messageContent,
        gm.message_date sent_at
        FROM
            user_groups ug
        JOIN groupp g ON
            ug.group_id = g.id
        JOIN group_message gm ON
            gm.group_id = g.id
        JOIN(
            SELECT
                grm.id,
                MAX(grm.message_date) AS max_sent_at
            FROM
                group_message grm
            GROUP BY
                grm.id
        ) max_msg
        ON
            gm.id = max_msg.id AND gm.message_date = max_msg.max_sent_at
        WHERE
            ug.userId = '$id'";
    } else {
        $sql = "SELECT
        ug.group_id groupId,
        g.group_name groupName,
        g.group_image groupImage,
        gm.message messageContent,
        gm.message_date sent_at
        FROM
            user_groups ug
        JOIN groupp g ON
            ug.group_id = g.id
        JOIN group_message gm ON
            gm.group_id = g.id
        JOIN(
            SELECT
                grm.id,
                MAX(grm.message_date) AS max_sent_at
            FROM
                group_message grm
            GROUP BY
                grm.id
        ) max_msg
        ON
            gm.id = max_msg.id AND gm.message_date = max_msg.max_sent_at
        WHERE
            ug.userId = '$id' and g.group_name = '$$txtSearch'";

    }
    $convsersations = [];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $convsersations[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $convsersations));
    } else {
        echo json_encode(array("status" => 404, "data" => "Currently There is no Groups found."));
    }

}
function LoadUserChats($conn)
{
    global $data;
    $id = isset($data) ? $data["id"] : $_POST["id"];
    $txtSearch = isset($data) ? $data["txtSearch"] : $_POST["txtSearch"];
    $sql = null;
    if ($txtSearch == null) {
        $sql = "SELECT
    uc.id AS userConverId,
    c.id AS conversation_id,
    u.id AS userOneId,
    u2.id AS userTwoId,
    u.fullname AS userOne,
    u2.fullname AS UserTwo,
    u.profile_image AS userOneProfile,
    u2.profile_image AS userTwoProfile,
    m.message_content AS last_message,
    m.sent_at AS sent_at
    FROM
        user_conversation uc
    JOIN conversation c ON
        uc.conversation_id = c.id
    LEFT JOIN message m ON
        m.conversation_id = uc.conversation_id
    JOIN USER u ON
        c.participant_user1 = u.id
    JOIN USER u2 ON
        c.participant_user2 = u2.id
    JOIN(
        SELECT conversation_id,
            MAX(sent_at) AS max_sent_at
        FROM
            message
        GROUP BY
            conversation_id
    ) max_msg
    ON
        m.conversation_id = max_msg.conversation_id AND m.sent_at = max_msg.max_sent_at
    WHERE
    c.participant_user1 = '$id' OR c.participant_user2 = '$id' ORDER BY m.sent_at desc";
    } else {
        $sql = "SELECT
    uc.id AS userConverId,
    c.id AS conversation_id,
    u.id AS userOneId,
    u2.id AS userTwoId,
    u.fullname AS userOne,
    u2.fullname AS UserTwo,
    u.profile_image AS userOneProfile,
    u2.profile_image AS userTwoProfile,
    m.message_content AS last_message,
    m.sent_at AS sent_at
    FROM
        user_conversation uc
    JOIN conversation c ON
        uc.conversation_id = c.id
    LEFT JOIN message m ON
        m.conversation_id = uc.conversation_id
    JOIN USER u ON
        c.participant_user1 = u.id
    JOIN USER u2 ON
        c.participant_user2 = u2.id
    JOIN(
        SELECT conversation_id,
            MAX(sent_at) AS max_sent_at
        FROM
            message
        GROUP BY
            conversation_id
    ) max_msg
    ON
        m.conversation_id = max_msg.conversation_id AND m.sent_at = max_msg.max_sent_at
    WHERE
     u2.fullname like '%$txtSearch%' and c.participant_user1 = '$id' OR c.participant_user2 = '$id'";

    }
    $convsersations = [];
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $convsersations[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $convsersations));
    } else {
        echo json_encode(array("status" => 404, "data" => "Currently There is no conversation found."));
    }
}
function deleteMessage($conn)
{
    global $data;
    $id = isset($data) ? $data["messageId"] : $_POST["messageId"];
    $sql = "DELETE FROM message WHERE  id = '$id'";
    $deleteResult = mysqli_query($conn, $sql);
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode(array("status" => 200, "message" => "Message deleted successfully"));
    } else {
        echo json_encode(array("status" => 404, "message" => "Can't delete Message Duo to " . mysqli_error($conn)));

    }

}
function getConversation($conn)
{
    global $data;
    $id = isset($data) ? $data["id"] : $_POST["id"];
    $sql = "select m.id messageId, u.id senderId, u2.id receiverId, u.fullname sender, u2.fullname receiver, u.profile_image senderProfileImage, u2.profile_image receiverProfileImage, m.image messageImage, m.sent_at, m.message_content, m.seen isSean from message m
            join user u on u.id = m.sender_id
            join user u2 on u2.id = m.receiver_id
            join conversation c on c.id = m.conversation_id where conversation_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $conversation = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $conversation[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $conversation));
    } else {
        echo json_encode(array("status" => 404, "data" => "no conversation found"));

    }
}

function getFriendConversation($conn)
{
    global $data;
    $friendId = isset($data) ? $data["friendId"] : $_POST["friendId"];
    $currentUser = isset($data) ? $data["currentUser"] : $_POST["currentUser"];
    $checkIfConversationExistSql = "SELECT *
        FROM conversation
        WHERE (participant_user1 = '$currentUser' AND participant_user2 = '$friendId')
        OR (participant_user1 = '$friendId' AND participant_user2 = '$currentUser') ";
    $oldConversation = [];
    $checkConversationResult = mysqli_query($conn, $checkIfConversationExistSql);
    if (mysqli_num_rows($checkConversationResult) > 0) {
        while ($row = mysqli_fetch_assoc($checkConversationResult)) {
            $oldConversation[] = $row;
        }
        $conversationId = $oldConversation[0]['id'];
        $sql = "select m.id messageId, u.id senderId, u2.id receiverId, u.fullname sender, u2.fullname receiver, u.profile_image senderProfileImage, u2.profile_image receiverProfileImage,m.image messageImage, m.sent_at, m.message_content, m.seen isSean from message m
            join user u on u.id = m.sender_id
            join user u2 on u2.id = m.receiver_id
            join conversation c on c.id = m.conversation_id where conversation_id = '$conversationId'";
        $result = mysqli_query($conn, $sql);
        $conversation = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $conversation[] = $row;
            }
            echo json_encode(array("status" => 200, "data" => $conversation));
        } else {
            echo json_encode(array("status" => 404, "data" => "no conversation found"));
        }
    } else {
        echo json_encode(array("status" => 404, "data" => "No conversation found"));
    }

}
//get baaned users
function getBannedUsers($conn)
{
    global $data;
    $sql = "SELECT * FROM user where isBanned= '1'";
    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $data1));
    } else {
        echo json_encode(array("status" => 404, "data" => "No record found."));
    }

}

function updateOnline($conn)
{
    global $data;
    $currentUser = isset($data) ? $data["currentUser"] : $_POST["currentUser"];
    $state = isset($data) ? $data["state"] : $_POST["state"];
    $sql = "UPDATE user SET isOnline = '$state' WHERE id = '$currentUser'";
    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if ($result) {

        echo json_encode(array("status" => 200, "message" => "Online status updated"));
    } else {
        echo json_encode(array("status" => 404, "data" => "No record found."));
    }

}
function getOnlineUsers($conn)
{
    global $data;
    $sql = "SELECT * FROM user where isOnline= '1'";
    $data1 = [];
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1[] = $row;
        }
        echo json_encode(array("status" => 200, "data" => $data1));
    } else {
        echo json_encode(array("status" => 404, "data" => "No record found."));
    }

}
// Ban user function
function blockUser($conn)
{
    $userId = $_POST["id"];
    $sql = "update user set isBanned = '1' where id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo json_encode(array("status" => 200, "message" => "User Banned Successfully"));
    } else {
        echo json_encode(array("status" => 400, "message" => "Can't Ban user due to "+mysqli_error($conn)));

    }

}

// Delte user function
function DeleteUser($conn)
{
    $userId = $_POST["id"];
    $sql = "delete  user set is = '1' where id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo json_encode(array("status" => 200, "message" => "User Banned Successfully"));
    } else {
        echo json_encode(array("status" => 400, "message" => "Can't Ban user due to "+mysqli_error($conn)));

    }

}

//update user record.
function updateUser($conn)
{
    global $data;
    $fullname = isset($data) ? $data['fullname'] : $_POST["fullname"];
    $id = isset($data) ? $data['id'] : $_POST["id"];
    $username = isset($data) ? $data['username'] : $_POST["username"];
    $email = isset($data) ? $data['email'] : $_POST["email"];
    $password = isset($data) ? $data['password'] : $_POST["password"];
    if (isset($fullname) && !empty($fullname) && isset($username) && !empty($username) && isset($password) && !empty($password) && isset($email) && !empty($email)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET fullname='$fullname', username='$username',email='$email', password='$hashedPassword' where id='$id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_affected_rows($conn) > 0) {
            echo json_encode(array("status" => 200, "message" => "user updated successfully"));
        } else {
            echo json_encode(array("status" => 502, "message" => "user update Failed " . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array("status" => 403, "message" => "All Input fields are required"));
    }
}
//un ban user.
function unBanUser($conn)
{
    $userId = $_POST["id"];
    $sql = "update user set isBanned = '0' where id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo json_encode(array("status" => 200, "message" => "User unBanned Successfully"));
    } else {
        echo json_encode(array("status" => 400, "message" => "Can't unBan user due to "+mysqli_error($conn)));

    }

}

//check if flutter is getting api.

function checkFlutter($conn)
{
    echo "heloooo";
}

//logout function.
function logout()
{
    session_start();
    session_destroy();
    $_SESSION["AdminName"] = "";
    $_SESSION["adminId"] = "";
    $_SESSION["AdminUsername"] = "";
    echo json_encode(array("message" => "Successfully logged out"));
}
$action($conn);
