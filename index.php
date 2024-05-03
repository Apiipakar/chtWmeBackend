<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login</title>
    <!-- font awesome link -->
    <link rel="stylesheet" href="./src/fontawesome-free-6.5.1-web/css/all.min.css">
    <!-- css link -->
    <link rel="stylesheet" href="./src/css/style.css">
    <!-- jquery link -->
    <script src="./src/js/jquery.js"></script>
</head>
<body class="flex h-screen w-full flex-col items-center justify-center">
    <?php
include "./pages/Partials/Alert.php";
?>
    <form class="w-2/3 md:w-1/4 border shadow-lg bg-white" id="loginForm">
        <h1 class="text-center sm:text-[30px] font-medium mt-5">Admin Login</h1>
        <!-- username -->
        <div class="form_group flex flex-col gap-2 mt-5 ">
            <input type="text" class="border-b border-slate-500 sm:w-2/3 mx-auto py-2 px-1 outline-none focus:border-slate-800" placeholder="username" name="email">
        </div>
        <!-- password -->
        <div class="form_group flex flex-col gap-2 mt-5 relative">
            <input type="text" class="border-b border-slate-500 sm:w-2/3 mx-auto py-2 px-1 outline-none focus:border-slate-800" placeholder="password" name="password">
        </div>
        <div class="form_group flex flex-col gap-2 mt-3 mb-5">
            <input type="submit" value="Login" class="w-2/3 sm:w-2/3 mx-auto py-2 px-1 rounded text-white bg-neutral-800 cursor-pointer">
        </div>
    </form>
    <script type="text/javascript">
        $("#Alert").hide();
        $(document).ready(()=>{
            login()
        })
      function login(){
        $("#loginForm").on("submit", (e)=>{
            e.preventDefault();
            let fd = new FormData($("#loginForm")[0])
            fd.append("action","AdminLogin")
           $.ajax({
            type:"POST",
            url:"./Database/Api.php",
            dataType: "json",
            data: fd,
            processData: false, // Ensure FormData is not processed
            contentType: false,
            success: (res)=>{
                console.log(res)
                if(res.status == 404){
                     $("#Alert").show();
                     $("#Alert").addClass("bg-red-500");
                     $("#Alert").text(res.data)
                     setTimeout(() => {
                     $("#Alert").hide();
                     }, 3000);
                }else{
                    $("#Alert").show();
                     $("#Alert").addClass("bg-green-500");
                     $("#Alert").text(res.data)
                     setTimeout(() => {
                     $("#Alert").hide();
                     window.location.href = "./pages/Dashboard.php"
                     }, 3000);
                }


            },error: (err)=>{
                console.log(err)
            }
           })
        })
      }
    </script>
</body>
</html>
