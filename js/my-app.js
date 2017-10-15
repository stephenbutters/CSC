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
    //DO SOMETHING ABOUT THE UNAME AND PWD, USE AJAX
    if(uname == "hongkan" && pwd == "1234") {
        //CHANGE THE USER NAME IN SIDE PANEL
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
