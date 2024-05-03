
<?php
session_start();
if (isset($_SESSION['adminId'])) {?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage - users</title>
    <!-- font awesome link -->
    <link rel="stylesheet" href="../src/fontawesome-free-6.5.1-web/css/all.min.css">
    <!-- css link -->
   <link rel="stylesheet" href="../src/css/style.css">
    <!-- jquery link -->
    <script src="../src/js/jquery.js"></script>
</head>
<body class="flex">
    <?php
include "./Partials/aside.php";
    include "./Partials/Loading.php";

    ?>
    <main class="w-full md:w-[85%]">
        <?php
include "./Partials/header.php";
    include "./Partials/Alert.php";
    include "./Partials/ConfirmBox.php";
    include "./Partials/EditUser.php";
    ?>
    <div class="flex justify-between  px-3 mt-3">
        <h1 class="text-slate-500">Manage users</h1>
        <div class="flex items-center gap-2 w-1/2 justify-end">
        <input type="text" class="w-1/3 px-2 py-1 outline-none focus:ring-1 border border-slate-300 text-slate-500" placeholder="Search..." id="searchTxt">
        <select class="border border-slate-300 w-2/3 outline-none focus:ring-1 py-1 px-2" id="selectUsers">
            <option value="All">All</option>
            <option value="banned">Select Banned</option>
            <option value="Online">Select Online</option>
        </select>
        </div>
    </div>

    <?php
include "./Partials/usersTable.php";

    ?>
    </main>
    <script type="text/javascript" src="../src/js/main.js"></script>
</body>
</html>

<?php
} else {
    header("location: ../index.php");
}
?>
