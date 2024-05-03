
<?php
session_start();
if (isset($_SESSION['adminId'])) {?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
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
    include "./Partials/Alert.php"
    ?>
            <section class="px-3 my-5">
                <a href="#" class="font-medium">Dashboard</a>
                <?php
include "./Partials/Totals.php";
    include "./Partials/MostSendMessage.php";
    ?>
            </section>
        </main>
        <script type="text/javascript" src="../src/js/main.js"></script>
    </body>
    </html>

<?php
} else {
    header("location: ../index.php");
}
?>
