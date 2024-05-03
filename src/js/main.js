// hide loading and alert initially
$("#EditUserBox").hide();
$("#Loading").hide();
$("#Alert").hide();

//active current admin page.
activePage();
getTotals();
getMostUsersSentMessageList();
getAllUsers();

//==============================================[DASHBOARD SECTION]=========================================================
function activePage() {
  let DashboardLink = document.getElementById("DashboardLink");
  let UserLink = document.getElementById("UserLink");
  let GroupsLink = document.getElementById("GroupsLink");
  let NotificationLink = document.getElementById("NotificationLink");
  let SetingsLink = document.getElementById("SetingsLink");
  let path = window.location.pathname;

  let links = [
    DashboardLink,
    UserLink,
    GroupsLink,
    NotificationLink,
    SetingsLink,
  ];
  links.forEach((l) => {
    if (path === l.pathname) {
      l.parentElement.classList.add("bg-slate-200");
    }
  });
}

//get totals
function getTotals() {
  $("#Loading").show();
  $.ajax({
    type: "POST",
    url: "../Database/Api.php",
    dataType: "json",
    data: { action: "getCounts" },
    success: (res) => {
      $("#Loading").hide();
      res.forEach((r) => {
        $("#totalusers").text(r.usersCount);
        $("#totalOnlineUsers").text(r.onlineUsers);
        $("#totalGroups").text(r.TotalGrops);
      });
    },
    error: (err) => {
      console.log(err);
    },
  });
}

//get most users sent message list.
function getMostUsersSentMessageList() {
  $("#Loading").show();
  $.ajax({
    type: "POST",
    url: "../Database/Api.php",
    dataType: "json",
    data: { action: "ListMostUsersSentMessage" },
    success: (res) => {
      $("#Loading").hide();
      let tr;
      if (res.status === 200) {
        res.data.forEach((d) => {
          tr += `<tr class="border text-center">
          <td class="py-1 px-2 border">${d.userId}</td>
          <td class="py-1 px-2 border">${d.fullname}</td>
          <td class="py-1 px-2 border">${d.message_count}</td>        
          </tr>`;
        });
        $("#userSentMessage").append(tr);
      } else {
        $("#userSentMessage").append(res.data);
      }
    },
    error: (err) => {
      console.log(err);
    },
  });
}

//================================================[USER SECTION]==========================================
//get all users.
function getAllUsers() {
  $("#Loading").show();
  $.ajax({
    type: "POST",
    url: "../Database/Api.php",
    dataType: "json",
    data: { action: "getAllUsers" },
    success: (res) => {
      $("#Loading").hide();
      let tr;
      if (res.status === 200) {
        res.data.forEach((d) => {
          let onlyDate = d.date_Joined.split(" ")[0];
          let checkOnline;
          let checkBanned;
          if (d.isBanned == "0") {
            checkBanned = `
              <button class="cursor-pointer bg-blue-700 hover:bg-blue-900 text-white px-3 rounded py-1" onClick="bannUser('${d.id}','${d.fullname}')">Ban</button>
            `;
          } else {
            checkBanned = `
              <button class="cursor-pointer bg-slate-500 hover:bg-slate-900 text-white px-3 rounded py-1" onClick="unBanUser('${d.id}','${d.fullname}')">Banned</button>
            `;
          }
          if (d.isOnline == "1") {
            checkOnline =
              "<div class='w-[8px] m-auto h-[8px] rounded-full bg-green-700 animate-ping duration-0'></div>";
          } else {
            checkOnline =
              "<div class='w-[10px] m-auto h-[10px] rounded-full bg-red-500'></div>";
          }
          tr += `<tr class="border hover:bg-slate-100">
          <td class="py-1 px-2 border">${d.id}</td>
          <td class="py-1 px-2 border">${d.phone_number}</td>
          <td class="py-1 px-2 border">${d.fullname}</td>        
          <td class="py-1 px-2 border">${d.email}</td>        
          <td class="py-1 px-2 border">${onlyDate}</td>        
          <td class="py-1 px-2 border text-center">${checkOnline}</td>        
          <td class="py-1 px-2 border text-center">
          <i class="fa-solid fa-edit cursor-pointer text-green-700 px-3 rounded py-1" onClick="editUser('${d.id}','${d.fullname}','${d.username}','${d.email}','${d.phone_number}','${d.password}')"></i>
          </td>        
          <td class="py-1 px-2 border text-center">${checkBanned}</td>        
          </tr>`;
        });
        $("#usersTable").append(tr);
      }
    },
    error: (err) => {
      console.log(err);
    },
  });
}
//search users.
$("#searchTxt")
  .off("input")
  .on("input", (e) => {
    // console.log(e.target.value);
    if (e.target.value === "") {
      $("#usersTable").empty();
      $("#usersTable").empty();
      getAllUsers();
    } else {
      $.ajax({
        type: "POST",
        url: "../Database/Api.php",
        dataType: "json",
        data: { action: "searchUser", sText: e.target.value },
        success: (res) => {
          let tr;
          if (res.status === 200) {
            res.data.forEach((d) => {
              let onlyDate = d.date_Joined.split(" ")[0];
              let checkOnline;
              let checkBanned;
              if (d.isBanned == "0") {
                checkBanned = `
              <button class="cursor-pointer bg-blue-700 hover:bg-blue-900 text-white px-3 rounded py-1" onClick="bannUser('${d.id}','${d.fullname}')">Ban</button>
            `;
              } else {
                checkBanned = `
              <button class="cursor-pointer bg-slate-500 hover:bg-slate-900 text-white px-3 rounded py-1" onClick="unBanUser('${d.id}','${d.fullname}')">Banned</button>
            `;
              }
              if (d.isOnline == "1") {
                checkOnline =
                  "<div class='w-[8px] m-auto h-[8px] rounded-full bg-green-700 animate-ping duration-0'></div>";
              } else {
                checkOnline =
                  "<div class='w-[10px] m-auto h-[10px] rounded-full bg-red-500'></div>";
              }
              tr += `<tr class="border hover:bg-slate-100">
          <td class="py-1 px-2 border">${d.id}</td>
          <td class="py-1 px-2 border">${d.phone_number}</td>
          <td class="py-1 px-2 border">${d.fullname}</td>        
          <td class="py-1 px-2 border">${d.email}</td>        
          <td class="py-1 px-2 border">${onlyDate}</td>        
          <td class="py-1 px-2 border text-center">${checkOnline}</td>        
          <td class="py-1 px-2 border text-center">
          <i class="fa-solid fa-edit cursor-pointer text-green-700 px-3 rounded py-1" onClick="editUser('${d.id}','${d.fullname}','${d.username}','${d.email}','${d.phone_number}','${d.password}')"></i>
          </td>        
          <td class="py-1 px-2 border text-center">${checkBanned}</td>        
          </tr>`;
            });
            $("#usersTable").empty();
            $("#usersTable").append(tr);
          }
        },
        error: (err) => {
          console.log(err);
        },
      });
    }
  });

//select user by dropdown.
$("#selectUsers").on("change", () => {
  if ($("#selectUsers").val() === "All") {
    $("#usersTable").empty();
    getAllUsers();
  } else if ($("#selectUsers").val() === "banned") {
    $("#usersTable").empty();
    getBannedUsers();
  } else if ($("#selectUsers").val() === "Online") {
    $("#usersTable").empty();
    getOnlineUsers();
  }
});

//get banned users.
function getBannedUsers() {
  $.ajax({
    type: "POST",
    url: "../Database/Api.php",
    dataType: "json",
    data: { action: "getBannedUsers" },
    success: (res) => {
      $("#Loading").hide();
      let tr;
      if (res.status === 200) {
        res.data.forEach((d) => {
          let onlyDate = d.date_Joined.split(" ")[0];
          let checkOnline;
          let checkBanned;
          if (d.isBanned == "0") {
            checkBanned = `
              <button class="cursor-pointer bg-blue-700 hover:bg-blue-900 text-white px-3 rounded py-1" onClick="bannUser('${d.id}','${d.fullname}')">Ban</button>
            `;
          } else {
            checkBanned = `
              <button class="cursor-pointer bg-slate-500 hover:bg-slate-900 text-white px-3 rounded py-1" onClick="unBanUser('${d.id}','${d.fullname}')">Banned</button>
            `;
          }
          if (d.isOnline == "1") {
            checkOnline =
              "<div class='w-[8px] m-auto h-[8px] rounded-full bg-green-700 animate-ping duration-0'></div>";
          } else {
            checkOnline =
              "<div class='w-[10px] m-auto h-[10px] rounded-full bg-red-500'></div>";
          }
          tr += `<tr class="border hover:bg-slate-100">
          <td class="py-1 px-2 border">${d.id}</td>
          <td class="py-1 px-2 border">${d.phone_number}</td>
          <td class="py-1 px-2 border">${d.fullname}</td>        
          <td class="py-1 px-2 border">${d.email}</td>        
          <td class="py-1 px-2 border">${onlyDate}</td>        
          <td class="py-1 px-2 border text-center">${checkOnline}</td>        
          <td class="py-1 px-2 border text-center">
          <i class="fa-solid fa-edit cursor-pointer text-green-700 px-3 rounded py-1" onClick="editUser('${d.id}','${d.fullname}','${d.username}','${d.email}','${d.phone_number}','${d.password}')"></i>
          </td>        
          <td class="py-1 px-2 border text-center">${checkBanned}</td>        
          </tr>`;
        });
        $("#usersTable").append(tr);
      } else {
        $("#usersTable").append(res.data);
        $("#usersTable").addClass("text-center");
      }
    },
    error: (err) => {
      console.log(err);
    },
  });
}
//get Online users.
function getOnlineUsers() {
  $.ajax({
    type: "POST",
    url: "../Database/Api.php",
    dataType: "json",
    data: { action: "getOnlineUsers" },
    success: (res) => {
      $("#Loading").hide();
      let tr;
      if (res.status === 200) {
        res.data.forEach((d) => {
          let onlyDate = d.date_Joined.split(" ")[0];
          let checkOnline;
          let checkBanned;
          if (d.isBanned == "0") {
            checkBanned = `
              <button class="cursor-pointer bg-blue-700 hover:bg-blue-900 text-white px-3 rounded py-1" onClick="bannUser('${d.id}','${d.fullname}')">Ban</button>
            `;
          } else {
            checkBanned = `
              <button class="cursor-pointer bg-slate-500 hover:bg-slate-900 text-white px-3 rounded py-1" onClick="unBanUser('${d.id}','${d.fullname}')">Banned</button>
            `;
          }
          if (d.isOnline == "1") {
            checkOnline =
              "<div class='w-[8px] m-auto h-[8px] rounded-full bg-green-700 animate-ping duration-0'></div>";
          } else {
            checkOnline =
              "<div class='w-[10px] m-auto h-[10px] rounded-full bg-red-500'></div>";
          }
          tr += `<tr class="border hover:bg-slate-100">
          <td class="py-1 px-2 border">${d.id}</td>
          <td class="py-1 px-2 border">${d.phone_number}</td>
          <td class="py-1 px-2 border">${d.fullname}</td>        
          <td class="py-1 px-2 border">${d.email}</td>        
          <td class="py-1 px-2 border">${onlyDate}</td>        
          <td class="py-1 px-2 border text-center">${checkOnline}</td>        
          <td class="py-1 px-2 border text-center">
          <i class="fa-solid fa-edit cursor-pointer text-green-700 px-3 rounded py-1" onClick="editUser('${d.id}','${d.fullname}','${d.username}','${d.email}','${d.phone_number}','${d.password}')"></i>
          </td>        
          <td class="py-1 px-2 border text-center">${checkBanned}</td>        
          </tr>`;
        });
        $("#usersTable").append(tr);
      } else {
        $("#usersTable").append(res.data);
        $("#usersTable").addClass("text-center");
      }
    },
    error: (err) => {
      console.log(err);
    },
  });
}
//ban user
function bannUser(id, name) {
  // alert(id);
  $("#confimBox").fadeIn();
  $("#confirmText").text("Are you sure you want to Ban " + name + "?");
  $("#confirmBtn")
    .off("click")
    .on("click", () => {
      $.ajax({
        type: "POST",
        url: "../Database/Api.php",
        dataType: "json",
        data: { action: "blockUser", id: id },
        success: (res) => {
          if (res.status == 200) {
            $("#Alert").show();
            $("#Alert").addClass("bg-green-700");
            $("#Alert").text(res.message);
            $("#confimBox").hide();
            $("#usersTable").empty();
            getAllUsers();
            setTimeout(() => {
              $("#Alert").hide();
            }, 3000);
          } else {
            $("#Alert").show();
            $("#Alert").addClass("bg-red-700");
            $("#Alert").text(res.message);
          }
        },
        error: (err) => {
          console.log(err);
        },
      });
    });
}
//un ban user.
function unBanUser(id, name) {
  // alert(id);
  $("#confimBox").fadeIn();
  $("#confirmText").text("Are you sure you want to un Ban " + name + "?");
  $("#confirmBtn")
    .off("click")
    .on("click", () => {
      $.ajax({
        type: "POST",
        url: "../Database/Api.php",
        dataType: "json",
        data: { action: "unBanUser", id: id },
        success: (res) => {
          if (res.status == 200) {
            $("#Alert").show();
            $("#Alert").addClass("bg-green-700");
            $("#Alert").text(res.message);
            $("#confimBox").hide();
            $("#usersTable").empty();
            getAllUsers();
            setTimeout(() => {
              $("#Alert").hide();
            }, 3000);
          } else {
            $("#Alert").show();
            $("#Alert").addClass("bg-red-500");
            $("#Alert").text(res.message);
          }
        },
        error: (err) => {
          console.log(err);
        },
      });
    });
}

//edit user.
function editUser(id, fullname, username, email, phoneNumber, password) {
  console.log(fullname);
  $("#EditUserBox").show();
  $("#fullnameTxt").val(fullname);
  $("#usernameTxt").val(username);
  $("#emailTxt").val(email);
  $("#phoneNumberTxt").val(phoneNumber);
  $("#passwordTxt").val(password);
  $("#updateUserBtn").on("click", () => {
    $.ajax({
      type: "POST",
      url: "../Database/api.php",
      dataType: "json",
      data: JSON.stringify({
        action: "updateUser",
        id: id,
        fullname: $("#fullnameTxt").val(),
        email: $("#emailTxt").val(),
        password: $("#passwordTxt").val(),
        username: $("#usernameTxt").val(),
      }),
      success: (res) => {
        console.log(res);
        if (res.status == 200) {
          $("#Alert").show();
          $("#Alert").addClass("bg-green-700");
          $("#Alert").text(res.message);
          $("#confimBox").hide();
          $("#usersTable").empty();
          getAllUsers();
          setTimeout(() => {
            $("#Alert").hide();
          }, 3000);
        } else {
          $("#Alert").show();
          $("#Alert").addClass("bg-red-700");
          $("#Alert").text(res.message);
          $("#usersTable").empty();
          getAllUsers();
          setTimeout(() => {
            $("#Alert").hide();
          }, 3000);
        }
      },
      error: (err) => {
        console.log(err);
      },
    });
  });
}

//hide user modal.
$("#closeUserModal").on("click", () => {
  $("#EditUserBox").fadeOut();
});
//------------------------[logout when logout button is clicked]--------
$("#logOutBtn").on("click", () => {
  $.ajax({
    type: "POST",
    url: "../Database/Api.php",
    dataType: "json",
    data: { action: "logout" },
    success: (res) => {
      $("#Alert").show();
      $("#Alert").addClass("bg-red-700");
      $("#Alert").text(res.message);
      setTimeout(() => {
        $("#Alert").hide();
        window.location.href = "../index.php";
      }, 2000);
    },
    error: (err) => {
      console.log(err);
    },
  });
});
