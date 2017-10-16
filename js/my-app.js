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

function loadSubjectsData(names) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            var tempData = this.responseText;
            var data = tempData.split("*");
            temp = [];
            for(var i = 0; i < data.length; i++) {
                if(data[i] != "") {
                    if(names == "subjects") {
                        subjects.push(data[i]);
                    }
                    else {
                        temp.push(data[i]);
                    }
                }
            }
            subjectClasses.push(temp);
        }
    }
    xmlhttp.open("GET", "subject.php?name="+names, false);
    xmlhttp.send();
}

$$('#registerBtn').on('click', function() {
    var tempUserName = $$('.register-screen input[name = "username"]').val();
    var tempUserPwd = $$('.register-screen input[name = "password"]').val();
    var tempUserPhone = $$('.register-screen input[name = "phonenum"]').val();
    var tempUserEmail = $$('.register-screen input[name = "email"]').val();
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
    if(tempUserPwd.length < 6 || !(/^\w+$/.test(tempUserPwd))) {
        myApp.alert('Your password should be more than 6 characters and contains only digits and letters.', 'Password');
        return;
    }

    //after this, we need to submit the form to server
    //if call server register file then return a value 0, it means pass, but with value 1
    //that means the username duplicated
    //but for now, we just assuming we pass the user register
    if(register(tempUserName, tempUserPwd, tempUserPhone, tempUserEmail) == "0") {
        myApp.alert('Duplicated user name.', 'ERROR');
        return;
    }
    myApp.showPreloader('Registering');
    setTimeout(function () {
        myApp.hidePreloader();
        myApp.closeModal('.popup');
        myApp.alert('You can log in with your account now.', 'INFO');     
    }, 1000);
});

var result = "";
function register(userName, userPwd, userPhone, userEmail) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            return this.responseText;
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
$$('.login-screen .list-button').on('click', function () {
    var uname = $$('.login-screen input[name = "username"]').val();
    var pwd = $$('.login-screen input[name = "password"]').val();
    accountValidate(uname, pwd);
    if(result == "0") {
        var temp = "Welcome, " + uname;
        $$('#userwelcome').html(temp);
        myApp.showPreloader('Loging In');
        setTimeout(function () {
            myApp.hidePreloader();
            myApp.closeModal('.login-screen');
            mainView.router.back();
            $$('.login-screen input[name = "password"]').val("");
            if(firstLogin) {
                loadSubjectsData("subjects");
                for(var i= 0; i < subjects.length; i++) {
                    loadSubjectsData("subject"+i);
                }
                addSubjects();
                firstLogin = 0;
            }
        }, 1500);
    } else {
        myApp.alert('One of your username and password is wrong.', 'ERROR');
    }
 });

function accountValidate(username, userpwd) {
    console.log(username, userpwd);
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
setInterval(function() {
    if(mainView.activePage.name == "index" && inClassPage) {
        inClassPage = 0;
        var allPages = $$('#allPages');
        var page = document.createElement("div");
        page.className = ("page cached");
        page.setAttribute("data-page", classPageName);
        var bDom = '<form data-search-list=".list-search' + classPageName + '" data-search-in=".item-title"' +
                'class="searchbar searchbar-init" style="top: 65px; background-color: #4a5965; width: 90%; left: 5%; border-radius: 12px;"> <div class="searchbar-input">' +
                '<input type="search" style="border-radius: 12px" placeholder="Search Class">' +
                '<a href="#" class="searchbar-clear"></a></div></form> <div class="searchbar-overlay">' +
                '</div> <div class="page-content" style="top: 55px; text-align: center;">' +
                '<div class="content-block"> <div class="list-block list-search' + classPageName + ' searchbar-found">' +
                '<ul class="ul' + classPageName + '"></ul></div></div></div></div>';
        page.innerHTML = bDom;
        allPages.append(page);
        var nb = document.createElement("div");
        nb.className = "navbar-inner cached";
        nb.setAttribute("data-page", classPageName);
        var cDom = '<div class="left"><a href="#" class="back link"> <i class="icon icon-back">' +
                '</i><span>Back</span></a></div><div class="right" style="margin-right: 20px;">' +
                '<a href="#" class="link icon-only open-panel"></i></a></div></div>';
        nb.innerHTML = cDom;        
        navbars.append(nb);
        for(var j = 0; j < subjectClasses[classNum+1].length; j++) {
            var lidom = document.createElement("li");
            lidom.className = "item-content"; 
            var dDom = '<a href="subject'+classNum+String.fromCharCode(65+classNum) +
                        '" class="item-link"> <div class="item-content"> <div class="item-inner">' +
                        '<div class="item-title">' + subjectClasses[classNum+1][j] + '</div></div></div></a>';
            var ulname = ".ulsubject" + classNum;
            var ul = $$(ulname);
            lidom.innerHTML = dDom;
            ul.append(lidom);
        }
    }
    for(var i = 0; i < subjects.length; i++) {
        if(mainView.activePage.name == ("subject"+i)) {
            inClassPage = 1;
            classNum = i;
            classPageName = "subject" + i;
        }
    }
}, 500);

$$('#backToIndexBtn').on('click', function() {
    mainView.router.back();
});


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

function addSubjects() {
    var subjectul = $$('#subjectUL');
    for(var i = 0; i < subjects.length; i++) {
        var lidom = document.createElement("li");
        lidom.className = "item-content";
        var aDom = '<a href="#subject' + i + '" class="item-link">' +
                    '<div class="item-content"> <div class="item-inner">' +
                    '<div class="item-title">' + subjects[i] + '</div></div></div></a>';
        lidom.innerHTML = aDom;
        subjectul.append(lidom);
    }
    var allPages = $$('#allPages');
    var navbars = $$('#navbars');
    console.log(subjectClasses);
    for(var i = 0; i < subjects.length; i++) {
        var page = document.createElement("div");
        page.className = ("page cached");
        page.setAttribute("data-page", "subject"+i);
        var bDom = '<form data-search-list=".list-searchsubject' + i + '" data-search-in=".item-title"' +
                'class="searchbar searchbar-init" style="top: 65px; background-color: #4a5965; width: 90%; left: 5%; border-radius: 12px;"> <div class="searchbar-input">' +
                '<input type="search" style="border-radius: 12px" placeholder="Search Class">' +
                '<a href="#" class="searchbar-clear"></a></div></form> <div class="searchbar-overlay">' +
                '</div> <div class="page-content" style="top: 55px; text-align: center;">' +
                '<div class="content-block"> <div class="list-block list-searchsubject' + i + ' searchbar-found">' +
                '<ul class="ulsubject' + i + '"></ul></div></div></div></div>';
        page.innerHTML = bDom;
        allPages.append(page);
        var nb = document.createElement("div");
        nb.className = "navbar-inner cached";
        nb.setAttribute("data-page", "subject"+i);
        var cDom = '<div class="left"><a href="#" class="back link"> <i class="icon icon-back">' +
                '</i><span>Back</span></a></div><div class="right" style="margin-right: 20px;">' +
                '<a href="#" class="link icon-only open-panel"></i></a></div></div>';
        nb.innerHTML = cDom;        
        navbars.append(nb);
        for(var j = 0; j < subjectClasses[i+1].length; j++) {
            var lidom = document.createElement("li");
            lidom.className = "item-content"; 
            var dDom = '<a href="subject'+i+String.fromCharCode(65+i) +
                        '" class="item-link"> <div class="item-content"> <div class="item-inner">' +
                        '<div class="item-title">' + subjectClasses[i+1][j] + '</div></div></div></a>';
            var ulname = ".ulsubject" + i;
            var ul = $$(ulname);
            lidom.innerHTML = dDom;
            ul.append(lidom);
        }
    }
}
