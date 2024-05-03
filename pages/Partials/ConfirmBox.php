<div id="confimBox" class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
<div class="bg-black absolute w-full h-full left-0 top-0 bg-opacity-25"></div>

<!-- modal of confirm box -->
<div  class="bg-white shadow-md w-11/12 md:w-1/3 z-10 rounded">
<!-- modal header -->
<div class="flex items-center justify-between px-1 border-b py-2">
    <h5 id='confirmHeader ' class=' ms-3 font-medium capitalize'>confirm header</h5>
    <i class="fa-solid fa-close px-3 py-2 hover:bg-slate-200 text-[18px] cursor-pointer ease-in transition-all rounded-full" id="closeConfimaBTn"></i>
</div>

<!-- modal body -->
<div class="p-3">
    <p id="confirmText" class="text-center font-medium w-2/3 m-auto">Are you sure you wan't to show this modal?</p>
</div>

<!-- modal footer -->
<div class="flex items-center justify-end p-3">
    <button class="px-2 py-1 bg-green-700 text-white rounded me-5 hover:bg-green-800 ease-in" id="confirmBtn">Confirm</button>
</div>
</div>
</div>

<script>
$("#confimBox").hide();
$("#closeConfimaBTn").on("click",function(){
    $("#confimBox").fadeOut();

})
</script>
