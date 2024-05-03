<div id="EditUserBox" class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
<div class="bg-black absolute w-full h-full left-0 top-0 bg-opacity-25"></div>

<!-- edit modal -->
<div  class="bg-white shadow-md w-11/12 lg:w-1/3 z-20 rounded">
    <!-- modal header -->
   <div class="flex items-center justify-between px-1 border-b py-2">
    <h5 id='userModalHeader ' class=' ms-3 font-medium capitalize'>Edit User</h5>
    <i class="fa-solid fa-close px-3 py-2 hover:bg-slate-200 text-[18px] cursor-pointer ease-in transition-all rounded-full" id="closeUserModal"></i>
    </div>
    <!-- modal body -->
    <div class="p-3">
        <div class="form_group flex flex-col gap-2">
            <label for="fullname">Fullname</label>
            <input type="text" id="fullnameTxt" class="px-2 py-1 outline-none border focus:ring-1 rounded" placeholder="Enter fullname">
        </div>
         <div class="form_group flex flex-col gap-2">
            <label for="username">Username</label>
            <input type="text" id="usernameTxt" class="px-2 py-1 outline-none border focus:ring-1 rounded" placeholder="Enter username">
        </div>
        <div class="form_group flex flex-col gap-2">
            <label for="email">Email</label>
            <input type="text" id="emailTxt" class="px-2 py-1 outline-none border focus:ring-1 rounded" placeholder="Enter username">
        </div>

        <div class="form_group flex flex-col gap-2">
            <label for="phoneNumber">Phone number</label>
            <input type="text" id="phoneNumberTxt" class="px-2 py-1 outline-none border focus:ring-1 rounded" placeholder="Enter username">
        </div>

        <div class="form_group flex flex-col gap-2">
            <label for="password">Password</label>
            <input type="text" id="passwordTxt" class="px-2 py-1 outline-none border focus:ring-1 rounded" placeholder="Enter username">
        </div>
        <div class="form_group flex  justify-end gap-2">
            <button class="bg-green-700 px-3 py-1 m-max mt-2 text-white rounded" id="updateUserBtn">Update</button>
        </div>
    </div>
</div>
</div>
