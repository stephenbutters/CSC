var isAndroid = Framework7.prototype.device.android === true;
var isIos = Framework7.prototype.device.ios === true;
Template7.global = {
    android: isAndroid,
    ios: isIos
};
// Export selectors engine
var $$ = Dom7;

if (isIos) {
    $$('head').append(
        '<link rel="stylesheet" href="css/framework7.ios.min.css">' +
        '<link rel="stylesheet" href="css/framework7.ios.colors.min.css">' +
        '<link rel="stylesheet" href="css/framework7.ios.css">'
    );
}
else {
    $$('head').append(
        '<link rel="stylesheet" href="css/framework7.material.min.css">' +
        '<link rel="stylesheet" href="css/framework7.material.colors.min.css">' +
        '<link rel="stylesheet" href="css/framework7.material.css">'
    );
} 



// Initialize your app
var myApp = new Framework7({
    aterial: isAndroid ? true : false,
    template7Pages: true
});


// Add view
var mainView = myApp.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
    domCache: true
});

var subjects = [];
var subjectClasses = [];
var temp = [];
var classAVB = [];

function loadClasses() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            var tempData = this.responseText;
            var data = tempData.split("*");
            temp = [];
            for(var i = 0; i < data.length; i++) {
                if(data[i] != "") {
                    if(data[i].charAt(0) == '-') {
                        subjects.push(data[i].substring(1, data[i].length));
                        var temp1 = data[i].split("(");
                        if(temp1.length == 1) {
                            classAVB.push(data[i].substring(1, data[i].length));
                        } else {
                            classAVB.push(temp1[1].substring(0, temp1[1].length - 2));
                        }
                        if(temp.length != 0) {
                            subjectClasses.push(temp);
                            temp = [];
                        }
                    } else {
                        temp.push(data[i]);
                        if(i == data.length - 1) {
                            subjectClasses.push(temp);
                        }
                    }
                }
            }
        }
    }
    xmlhttp.open("GET", "subject.php", false);
    xmlhttp.send();
}

$$('#sectionAddBtn').on('click', function() {
    //just for test
    mainView.router.load({pageName: 'index'});
});

$$('#registerBtn').on('click', function() {
    var tempUserName = $$('.register-screen input[name = "username"]').val();
    var tempUserPwd = $$('.register-screen input[name = "password"]').val();
    var tempUserPhone = $$('.register-screen input[name = "phonenum"]').val();
    var tempUserEmail = $$('.register-screen input[name = "email"]').val();
    var temprepeatPwd = $$('.register-screen input[name = "repeatedpassword"]').val();
    if(tempUserName == "" || tempUserPwd == "" || tempUserEmail == "" || tempUserPhone == "") {
        myApp.alert('Please fill out all the informations.', 'ERROR');
        return;
    }
    if(!document.getElementById('checkAgreement').checked) {
        myApp.alert('Please check the agreements.', 'ERROR');
        return;
    }
    if(!(/^\w+$/.test(tempUserName))) {
        myApp.alert('Your user name should only contains letters and numbers.', 'UserName');
        return;
        if(tempUserName.length < 6) {
            myApp.alert('Your user name should be more than 6 characters.', 'UserName');
        }
        return;
    }
    if(!(/^\d+$/.test(tempUserPhone) || tempUserPhone.length != 10)) {
        myApp.alert('Your phone number should be 10 digits.', 'PhoneNumber');
        return;
    }
    if(!(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+([^<>()\.,;:\s@\"]{2,}|[\d\.]+))$/.test(tempUserEmail))) {
        myApp.alert('Cannot identify the email address, please check it one more tiem.', 'Email');
        return;
    }
    if(tempUserPwd != temprepeatPwd) {
        myApp.alert('Your passwords do not match.', 'Password');
        return;
    }
    if(tempUserPwd.length < 6 || !(/^\w+$/.test(tempUserPwd))) {
        myApp.alert('Your password should be more than 6 characters and contains only digits and letters.', 'Password');
        return;
    }
    register(tempUserName, tempUserPwd, tempUserPhone, tempUserEmail);
    if(result != "0") {
        myApp.alert('Duplicated user name.', 'ERROR');
        return;
    }
    result = "";
    myApp.showPreloader('Registering');
    setTimeout(function () {
        myApp.hidePreloader();
        myApp.closeModal('.popupsignup');
        myApp.alert('You can log in with your account now.', 'INFO'); 
        $$('.register-screen input[name = "username"]').val("");
        $$('.register-screen input[name = "password"]').val("");
        $$('.register-screen input[name = "phonenum"]').val("");
        $$('.register-screen input[name = "email"]').val("");
        $$('.register-screen input[name = "repeatedpassword"]').val("");    
    }, 500);
});

$$('#pwdchangeBtn').on('click', function() {
    var tempUserName = $$('.pwdchange-screen input[name = "cpusername"]').val();
    var tempUserPwd = $$('.pwdchange-screen input[name = "cppassword"]').val();
    var tempUserEmail = $$('.pwdchange-screen input[name = "cpemail"]').val();
    var temprepeatPwd = $$('.pwdchange-screen input[name = "cprepeatedpassword"]').val();
    if(tempUserPwd != temprepeatPwd) {
        myApp.alert('Your passwords do not match.', 'Password');
        return;
    }
    if(tempUserPwd.length < 6 || !(/^\w+$/.test(tempUserPwd))) {
        myApp.alert('Your password should be more than 6 characters and contains only digits and letters.', 'Password');
        return;
    }
    changePwd(tempUserName, tempUserPwd, tempUserEmail);
    if(result != "0") {
        myApp.alert('Could not find any matches.', 'ERROR');
        return;
    }
    result = "";
    myApp.showPreloader('Processing');
    setTimeout(function () {
        myApp.hidePreloader();
        myApp.closeModal('.popuppwdchange');
        myApp.alert('Password updated.', 'INFO');
        $$('.pwdchange-screen input[name = "cpusername"]').val("");
        $$('.pwdchange-screen input[name = "cppassword"]').val("");
        $$('.pwdchange-screen input[name = "cpemail"]').val("");
        $$('.pwdchange-screen input[name = "cprepeatedpassword"]').val("");     
    }, 500);
});

function changePwd(username, userpwd, useremail) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText == "0") result = "0";
            else result = "1";
        }
    }
    xmlhttp.open("GET", "changePwd.php?username="
        +username+"&userpwd="+userpwd+"&useremail="+useremail, false);
    xmlhttp.send();
}

var result = "";
function register(userName, userPwd, userPhone, userEmail) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText == "0") result = "0";
            else result = "1";
        }
    }
    xmlhttp.open("GET", "registerUser.php?username="
        +userName+"&userpwd="+userPwd+"&userphone="+userPhone+"&useremail="+userEmail, false);
    xmlhttp.send();
}

// Callbacks to run specific code for specific pages, for example for About page:
myApp.onPageInit('about', function (page) {
    // run createContentPage func after link was clicked
    $$('.create-page').on('click', function () {
        createContentPage();
    });
});
var firstLogin = 1;
var uname="";
$$('.login-screen .list-button').on('click', function () {
    uname = $$('.login-screen input[name = "username"]').val();
    var pwd = $$('.login-screen input[name = "password"]').val();
    accountValidate(uname, pwd);
    if(result == "0") {
        result = "";
        var temp = "Welcome, " + uname;
        $$('#userwelcome').html(temp);
        myApp.showPreloader('Loging In');
        setTimeout(function () {
            myApp.hidePreloader();
            myApp.closeModal('.login-screen');
            mainView.router.back();
            $$('.login-screen input[name = "password"]').val("");
            if(firstLogin) {
                // loadSubjectsData("subjects");
                // for(var i= 0; i < subjects.length; i++) {
                //     loadSubjectsData("subject"+i);
                // }
                loadClasses();
                addSubjects();
                firstLogin = 0;
            }
        }, 100);
    } else {
        myApp.alert('One of your username and password is wrong.', 'ERROR');
    }
 });

function accountValidate(username, userpwd) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText == "0") result = "0";
            else result = "1";
        }
    }
    xmlhttp.open("GET", "userValidate.php?username="+username+"&userpwd="+userpwd, false);
    xmlhttp.send();
}

var inClassPage = 0;
var classPageName;
var classNum = -1;

$$('#sectionAddBtn').on('click', function() {
    var curClassName = document.getElementById("addClassSectionID").innerHTML;
    var tempFrom = document.getElementById("sectionFrom");
    var curFrom = tempFrom.options[tempFrom.selectedIndex].value;
    var tempTo = document.getElementById("sectionTo");
    var curTo = tempTo.options[tempTo.selectedIndex].value;
    if(curFrom == curTo) {
        myApp.alert("Can't change to the same section.", 'ERROR');
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText != "0") {
                myApp.alert('Something went wrong with response code '+this.responseText, 'ERROR');
            }
        }
    }
    xmlhttp.open("GET", "classSectionSubmit.php?userName="+uname+"&className="+curClassName+"&secfrom="+curFrom+"&secto="+curTo, true);
    xmlhttp.send();
});

$$('#backToIndexBtn').on('click', function() {
    mainView.router.load({pageName: 'index'});
});

function popupClassInfo (classname, secFrom, secTo, time, status) {
  myApp.modal({
    title:  'Section Info',
    text: 'Class: '+classname+'<br>Section From: '+secFrom+'<br>Section To: '+secTo+'<br>Time: '+time+'<br>Status: '+status,
    buttons: [
      {
        text: 'Cancel',
        onClick: function() {
        }
      },
      {
        text: 'Remove',
        onClick: function() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    if(this.responseText != "0") {
                        myApp.alert('Something went wrong with response code '+this.responseText, 'ERROR');
                    }
                }
            }
            xmlhttp.open("GET", "removeClassSection.php?userName="+uname+"&className="+classname+"&secFrom="+secFrom+"&secTo="+secTo, true);
            xmlhttp.send();
        }
      },
    ]
  })
}

function classAddUI(classname) {
    document.getElementById("addClassSectionID").innerHTML = classname;
    mainView.router.load({pageName: 'addClassSectionPage'});
}



function threeBtn(classname) {
    myApp.modal({
    title:  'Group Team Up',
    text: 'Select "Raise a Team" to create a team, "Join a Team" to find and join a team.',
    verticalButtons: true,
    buttons: [
      {
        text: 'Raise a Team',
        onClick: function() {
          document.getElementById("raiseTeamPageID").innerHTML = classname;
          document.getElementById("teamname").value = "";
          document.getElementById("teamsize").value = 1;
          document.getElementById("curteamsize").value = 1;
          document.getElementById("teamDescription").value = "";
          mainView.router.load({pageName: 'raiseTeamPage'});
        }
      },
      {
        text: 'Join a Team',
        onClick: function() {
          myApp.alert('Have not implemented')
        }
      },
      {
        text: 'Cancel'
      },
    ]
  })
}

setInterval(function() {
    if(firstLogin == 0) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText[0][3]);
                var obj = JSON.parse(this.responseText);
                var tempID = document.getElementById("classSectionChangeDiv");
                tempID.innerHTML = "";
                for(var i = 0; i < obj.length; i++) {
                    var lidom = document.createElement("li");
                    lidom.className = "button button-fill button-blue modal33";
                    lidom.style.cssText = 'border-radius: 10px; margin-bottom: 10px; margin-top: 10px; height: 50px;';
                    lidom.setAttribute('onclick', "popupClassInfo('"+obj[i][0]+"', '"+obj[i][1]+"', '"+obj[i][2]+"', '"+obj[i][3]+"', 'pending')");
                    var adom = '<a href="#" style="color: white;">'+obj[i][0]+'</a>';
                    lidom.innerHTML = adom;
                    tempID.append(lidom);
                }
            }
        }
        xmlhttp.open("GET", "updateClassSection.php?userName="+uname, true);
        xmlhttp.send();
    }   
}, 1000);

// Generate dynamic page
var dynamicPageIndex = 0;
function createContentPage() {
	mainView.router.loadContent(
        '<!-- Top Navbar-->' +
        '<div class="navbar">' +
        '  <div class="navbar-inner">' +
        '    <div class="left"><a href="#" class="back link"><i class="icon icon-back"></i><span>Back</span></a></div>' +
        '    <div class="center sliding">Dynamic Page ' + (++dynamicPageIndex) + '</div>' +
        '  </div>' +
        '</div>' +
        '<div class="pages">' +
        '  <!-- Page, data-page contains page name-->' +
        '  <div data-page="dynamic-pages" class="page">' +
        '    <!-- Scrollable page content-->' +
        '    <div class="page-content">' +
        '      <div class="content-block">' +
        '        <div class="content-block-inner">' +
        '          <p>Here is a dynamic page created on ' + new Date() + ' !</p>' +
        '          <p>Go <a href="#" class="back">back</a> or go to <a href="services.html">Services</a>.</p>' +
        '        </div>' +
        '      </div>' +
        '    </div>' +
        '  </div>' +
        '</div>'
    );
	return;
}

function addClass(i) {
    var temp = document.getElementById("subjectULDiv");
    temp.innerHTML = '';
    for(var j = 0; j < subjectClasses[i].length; j++) {
            var temp1 = subjectClasses[i][j].split(".");
            var lidom = document.createElement("li");
            lidom.className = "item-content"; 
            var dDom = '<a onclick="classAddUI(\''+classAVB[i]+' - '+temp1[0]+'\')" href="#'+
                        '" class="item-link"> <div class="item-content"> <div class="item-inner">' +
                        '<div class="item-title">' + subjectClasses[i][j] + '</div></div></div></a>';
            lidom.innerHTML = dDom;
            temp.append(lidom);
    }
    mainView.router.load({pageName: 'classDivPage'});
}

function addClass2(i) {
    var temp = document.getElementById("subjectULGroupDiv");
    temp.innerHTML = '';
    for(var j = 0; j < subjectClasses[i].length; j++) {
            var temp1 = subjectClasses[i][j].split(".");
            var lidom = document.createElement("li");
            lidom.className = "item-content"; 
            var dDom = '<a onclick="threeBtn(\''+classAVB[i]+' - '+temp1[0]+'\')" href="#'+
                        '" class="item-link"> <div class="item-content"> <div class="item-inner">' +
                        '<div class="item-title">' + subjectClasses[i][j] + '</div></div></div></a>';
            lidom.innerHTML = dDom;
            temp.append(lidom);
    }
    mainView.router.load({pageName: 'classDivPageGroup'});
}

function addSubjects() {
    console.log(classAVB);
    var subjectul = $$('#subjectUL');
    var subjectulg = $$('#subjectULGroup');
    for(var i = 0; i < subjects.length; i++) {
        var lidom = document.createElement("li");
        var lidom2 = document.createElement("li");   
        lidom.className = "item-content";
        lidom2.className = "item-content";
        var aDom = '<a href="#" onclick="addClass('+i+')" class="item-link">' +
                    '<div class="item-content"> <div class="item-inner">' +
                    '<div class="item-title">' + subjects[i] + '</div></div></div></a>';
        var aDom2 = '<a href="#" onclick="addClass2('+i+')" class="item-link">' +
                    '<div class="item-content"> <div class="item-inner">' +
                    '<div class="item-title">' + subjects[i] + '</div></div></div></a>';
        lidom.innerHTML = aDom;
        subjectul.append(lidom);
        lidom2.innerHTML = aDom2;
        subjectulg.append(lidom2);
    }
}
