// =========================================================
// Soft UI Dashboard - v1.0.7
// =========================================================

// Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
// Copyright 2023 Creative Tim (https://www.creative-tim.com)
// Licensed under MIT (https://github.com/creativetimofficial/soft-ui-dashboard/blob/main/LICENSE)

// Coded by www.creative-tim.com

// =========================================================

// The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
const publicKey = "BIwxyzlV6TbuuRpdKP-zISQKJ8J4-TBcLLN0nQzF4amUZ3zHXsGW6DVR17NcTHLXcUATABin_z4xTh9kvRsJl0g";

window.onload = () => {
  // (A1) ASK FOR PERMISSION
  if (Notification.permission === "default") {
    Notification.requestPermission().then(perm => {
      if (Notification.permission === "granted") {
        regWorker().catch(err => console.error(err));
      } else {
        alert("Please allow notifications.");
      }
    });
  } 
 
  // (A2) GRANTED
  else if (Notification.permission === "granted") {
    regWorker().catch(err => console.error(err));
  }

  // (A3) DENIED
  else { alert("Please allow notifications."); }
}
// (B) REGISTER SERVICE WORKER
async function regWorker () {
  // (B1) YOUR PUBLIC KEY - CHANGE TO YOUR OWN!
 
  // (B2) REGISTER SERVICE WORKER
  navigator.serviceWorker.register("sw.js");
 
  // (B3) SUBSCRIBE TO PUSH SERVER
  navigator.serviceWorker.ready
  .then(reg => {
    reg.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: publicKey
    }).then(
      // (B3-1) OK - TEST PUSH NOTIFICATION
      sub => {
        var data = new FormData();
        data.append("sub", JSON.stringify(sub));
        fetch("functions.php", { method: "POST", body : data })
        .then(res => res.text())
        .then(txt => console.log(txt))
        .catch(err => console.error(err));
      },
 
      // (B3-2) ERROR!
      err => console.error(err)
    );
  });
}


"use strict";
(function () {
  var isWindows = navigator.platform.indexOf("Win") > -1 ? true : false;

  if (isWindows) {
    // if we are on windows OS we activate the perfectScrollbar function
    if (document.getElementsByClassName("main-content")[0]) {
      var mainpanel = document.querySelector(".main-content");
      var ps = new PerfectScrollbar(mainpanel);
    }

    if (document.getElementsByClassName("sidenav")[0]) {
      var sidebar = document.querySelector(".sidenav");
      var ps1 = new PerfectScrollbar(sidebar);
    }

    if (document.getElementsByClassName("navbar-collapse")[0]) {
      var fixedplugin = document.querySelector(
        ".navbar:not(.navbar-expand-lg) .navbar-collapse"
      );
      var ps2 = new PerfectScrollbar(fixedplugin);
    }

    if (document.getElementsByClassName("fixed-plugin")[0]) {
      var fixedplugin = document.querySelector(".fixed-plugin");
      var ps3 = new PerfectScrollbar(fixedplugin);
    }
  }
})();

// Verify navbar blur on scroll
navbarBlurOnScroll("navbarBlur");

// initialization of Tooltips
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Fixed Plugin

if (document.querySelector(".fixed-plugin")) {
  var fixedPlugin = document.querySelector(".fixed-plugin");
  var fixedPluginButton = document.querySelector(".fixed-plugin-button");
  var fixedPluginButtonNav = document.querySelector(".fixed-plugin-button-nav");
  var fixedPluginCard = document.querySelector(".fixed-plugin .card");
  var fixedPluginCloseButton = document.querySelectorAll(
    ".fixed-plugin-close-button"
  );
  var navbar = document.getElementById("navbarBlur");
  var buttonNavbarFixed = document.getElementById("navbarFixed");

  if (fixedPluginButton) {
    fixedPluginButton.onclick = function () {
      if (!fixedPlugin.classList.contains("show")) {
        fixedPlugin.classList.add("show");
      } else {
        fixedPlugin.classList.remove("show");
      }
    };
  }

  if (fixedPluginButtonNav) {
    fixedPluginButtonNav.onclick = function () {
      if (!fixedPlugin.classList.contains("show")) {
        fixedPlugin.classList.add("show");
      } else {
        fixedPlugin.classList.remove("show");
      }
    };
  }

  fixedPluginCloseButton.forEach(function (el) {
    el.onclick = function () {
      fixedPlugin.classList.remove("show");
    };
  });

  document.querySelector("body").onclick = function (e) {
    if (
      e.target != fixedPluginButton &&
      e.target != fixedPluginButtonNav &&
      e.target.closest(".fixed-plugin .card") != fixedPluginCard
    ) {
      fixedPlugin.classList.remove("show");
    }
  };

  if (navbar) {
    if (navbar.getAttribute("navbar-scroll") == "true") {
      buttonNavbarFixed.setAttribute("checked", "true");
    }
  }
}

// Tabs navigation

var total = document.querySelectorAll(".nav-pills");

total.forEach(function (item, i) {
  var moving_div = document.createElement("div");
  var first_li = item.querySelector("li:first-child .nav-link");
  var tab = first_li.cloneNode();
  tab.innerHTML = "-";

  moving_div.classList.add("moving-tab", "position-absolute", "nav-link");
  moving_div.appendChild(tab);
  item.appendChild(moving_div);

  var list_length = item.getElementsByTagName("li").length;

  moving_div.style.padding = "0px";
  moving_div.style.width =
    item.querySelector("li:nth-child(1)").offsetWidth + "px";
  moving_div.style.transform = "translate3d(0px, 0px, 0px)";
  moving_div.style.transition = ".5s ease";

  item.onmouseover = function (event) {
    let target = getEventTarget(event);
    let li = target.closest("li"); // get reference
    if (li) {
      let nodes = Array.from(li.closest("ul").children); // get array
      let index = nodes.indexOf(li) + 1;
      item.querySelector("li:nth-child(" + index + ") .nav-link").onclick =
        function () {
          moving_div = item.querySelector(".moving-tab");
          let sum = 0;
          if (item.classList.contains("flex-column")) {
            for (var j = 1; j <= nodes.indexOf(li); j++) {
              sum += item.querySelector("li:nth-child(" + j + ")").offsetHeight;
            }
            moving_div.style.transform = "translate3d(0px," + sum + "px, 0px)";
            moving_div.style.height = item.querySelector(
              "li:nth-child(" + j + ")"
            ).offsetHeight;
          } else {
            for (var j = 1; j <= nodes.indexOf(li); j++) {
              sum += item.querySelector("li:nth-child(" + j + ")").offsetWidth;
            }
            moving_div.style.transform = "translate3d(" + sum + "px, 0px, 0px)";
            moving_div.style.width =
              item.querySelector("li:nth-child(" + index + ")").offsetWidth +
              "px";
          }
        };
    }
  };
});

// Tabs navigation resize

window.addEventListener("resize", function (event) {
  total.forEach(function (item, i) {
    item.querySelector(".moving-tab").remove();
    var moving_div = document.createElement("div");
    var tab = item.querySelector(".nav-link.active").cloneNode();
    tab.innerHTML = "-";

    moving_div.classList.add("moving-tab", "position-absolute", "nav-link");
    moving_div.appendChild(tab);

    item.appendChild(moving_div);

    moving_div.style.padding = "0px";
    moving_div.style.transition = ".5s ease";

    let li = item.querySelector(".nav-link.active").parentElement;

    if (li) {
      let nodes = Array.from(li.closest("ul").children); // get array
      let index = nodes.indexOf(li) + 1;

      let sum = 0;
      if (item.classList.contains("flex-column")) {
        for (var j = 1; j <= nodes.indexOf(li); j++) {
          sum += item.querySelector("li:nth-child(" + j + ")").offsetHeight;
        }
        moving_div.style.transform = "translate3d(0px," + sum + "px, 0px)";
        moving_div.style.width =
          item.querySelector("li:nth-child(" + index + ")").offsetWidth + "px";
        moving_div.style.height = item.querySelector(
          "li:nth-child(" + j + ")"
        ).offsetHeight;
      } else {
        for (var j = 1; j <= nodes.indexOf(li); j++) {
          sum += item.querySelector("li:nth-child(" + j + ")").offsetWidth;
        }
        moving_div.style.transform = "translate3d(" + sum + "px, 0px, 0px)";
        moving_div.style.width =
          item.querySelector("li:nth-child(" + index + ")").offsetWidth + "px";
      }
    }
  });

  if (window.innerWidth < 991) {
    total.forEach(function (item, i) {
      if (!item.classList.contains("flex-column")) {
        item.classList.add("flex-column", "on-resize");
      }
    });
  } else {
    total.forEach(function (item, i) {
      if (item.classList.contains("on-resize")) {
        item.classList.remove("flex-column", "on-resize");
      }
    });
  }
});

function getEventTarget(e) {
  e = e || window.event;
  return e.target || e.srcElement;
}

// End tabs navigation

//Set Sidebar Color
function sidebarColor(a) {
  var parent = a.parentElement.children;
  var color = a.getAttribute("data-color");

  for (var i = 0; i < parent.length; i++) {
    parent[i].classList.remove("active");
  }

  if (!a.classList.contains("active")) {
    a.classList.add("active");
  } else {
    a.classList.remove("active");
  }

  var sidebar = document.querySelector(".sidenav");
  sidebar.setAttribute("data-color", color);

  if (document.querySelector("#sidenavCard")) {
    var sidenavCard = document.querySelector("#sidenavCard");
    let sidenavCardClasses = [
      "card",
      "card-background",
      "shadow-none",
      "card-background-mask-" + color,
    ];
    sidenavCard.className = "";
    sidenavCard.classList.add(...sidenavCardClasses);

    var sidenavCardIcon = document.querySelector("#sidenavCardIcon");
    let sidenavCardIconClasses = [
      "ni",
      "ni-diamond",
      "text-gradient",
      "text-lg",
      "top-0",
      "text-" + color,
    ];
    sidenavCardIcon.className = "";
    sidenavCardIcon.classList.add(...sidenavCardIconClasses);
  }
}

// Set Navbar Fixed
function navbarFixed(el) {
  let classes = [
    "position-sticky",
    "blur",
    "shadow-blur",
    "mt-4",
    "left-auto",
    "top-1",
    "z-index-sticky",
  ];
  const navbar = document.getElementById("navbarBlur");

  if (!el.getAttribute("checked")) {
    navbar.classList.add(...classes);
    navbar.setAttribute("navbar-scroll", "true");
    navbarBlurOnScroll("navbarBlur");
    el.setAttribute("checked", "true");
  } else {
    navbar.classList.remove(...classes);
    navbar.setAttribute("navbar-scroll", "false");
    navbarBlurOnScroll("navbarBlur");
    el.removeAttribute("checked");
  }
}

// Navbar blur on scroll

function navbarBlurOnScroll(id) {
  const navbar = document.getElementById(id);
  let navbarScrollActive = navbar
    ? navbar.getAttribute("navbar-scroll")
    : false;
  let scrollDistance = 5;
  let classes = [
    "position-sticky",
    "blur",
    "shadow-blur",
    "mt-4",
    "left-auto",
    "top-1",
    "z-index-sticky",
  ];
  let toggleClasses = ["shadow-none"];

  if (navbarScrollActive == "true") {
    window.onscroll = debounce(function () {
      if (window.scrollY > scrollDistance) {
        blurNavbar();
      } else {
        transparentNavbar();
      }
    }, 10);
  } else {
    window.onscroll = debounce(function () {
      transparentNavbar();
    }, 10);
  }

  function blurNavbar() {
    navbar.classList.add(...classes);
    navbar.classList.remove(...toggleClasses);

    toggleNavLinksColor("blur");
  }

  function transparentNavbar() {
    if (navbar) {
      navbar.classList.remove(...classes);
      navbar.classList.add(...toggleClasses);

      toggleNavLinksColor("transparent");
    }
  }

  function toggleNavLinksColor(type) {
    let navLinks = document.querySelectorAll(".navbar-main .nav-link");
    let navLinksToggler = document.querySelectorAll(
      ".navbar-main .sidenav-toggler-line"
    );

    if (type === "blur") {
      navLinks.forEach((element) => {
        element.classList.remove("text-body");
      });

      navLinksToggler.forEach((element) => {
        element.classList.add("bg-dark");
      });
    } else if (type === "transparent") {
      navLinks.forEach((element) => {
        element.classList.add("text-body");
      });

      navLinksToggler.forEach((element) => {
        element.classList.remove("bg-dark");
      });
    }
  }
}

// Debounce Function
// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
function debounce(func, wait, immediate) {
  var timeout;
  return function () {
    var context = this,
      args = arguments;
    var later = function () {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}

//Set Sidebar Type
function sidebarType(a) {
  var parent = a.parentElement.children;
  var color = a.getAttribute("data-class");

  var colors = [];

  for (var i = 0; i < parent.length; i++) {
    parent[i].classList.remove("active");
    colors.push(parent[i].getAttribute("data-class"));
  }

  if (!a.classList.contains("active")) {
    a.classList.add("active");
  } else {
    a.classList.remove("active");
  }

  var sidebar = document.querySelector(".sidenav");

  for (var i = 0; i < colors.length; i++) {
    sidebar.classList.remove(colors[i]);
  }

  sidebar.classList.add(color);
}

// Toggle Sidenav
const iconNavbarSidenav = document.getElementById("iconNavbarSidenav");
const iconSidenav = document.getElementById("iconSidenav");
const sidenav = document.getElementById("sidenav-main");
let body = document.getElementsByTagName("body")[0];
let className = "g-sidenav-pinned";

if (iconNavbarSidenav) {
  iconNavbarSidenav.addEventListener("click", toggleSidenav);
}

if (iconSidenav) {
  iconSidenav.addEventListener("click", toggleSidenav);
}

function toggleSidenav() {
  if (body.classList.contains(className)) {
    body.classList.remove(className);
    setTimeout(function () {
      sidenav.classList.remove("bg-white");
    }, 100);
    sidenav.classList.remove("bg-transparent");
  } else {
    body.classList.add(className);
    sidenav.classList.add("bg-white");
    sidenav.classList.remove("bg-transparent");
    iconSidenav.classList.remove("d-none");
  }
}

// Resize navbar color depends on configurator active type of sidenav

let referenceButtons = document.querySelector("[data-class]");

window.addEventListener("resize", navbarColorOnResize);

function navbarColorOnResize() {
  if (window.innerWidth > 1200) {
    if (
      referenceButtons.classList.contains("active") &&
      referenceButtons.getAttribute("data-class") === "bg-transparent"
    ) {
      sidenav.classList.remove("bg-white");
    } else {
      sidenav.classList.add("bg-white");
    }
  } else {
    sidenav.classList.add("bg-white");
    sidenav.classList.remove("bg-transparent");
  }
}

// Deactivate sidenav type buttons on resize and small screens
window.addEventListener("resize", sidenavTypeOnResize);
window.addEventListener("load", sidenavTypeOnResize);

function sidenavTypeOnResize() {
  let elements = document.querySelectorAll('[onclick="sidebarType(this)"]');
  if (window.innerWidth < 1200) {
    elements.forEach(function (el) {
      el.classList.add("disabled");
    });
  } else {
    elements.forEach(function (el) {
      el.classList.remove("disabled");
    });
  }
}

function replay() {
  const xhttp = new XMLHttpRequest();
  xhttp.open("POST", "functions.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


  xhttp.onload = function () {
    var data = JSON.parse(this.responseText);
    console.log(this.responseText);
    if (data.length !== 0) {
      const labelsc = [];
      const value1 = [];
      const value2 = [];
      const value3 = [];
      const value4 = [];
      const value5 = [];
      for (var i = 0; i < data.length; i++) {
        labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
        value1.push(data[i]["device"]);
        value2.push(data[i]["temp"]);
        value3.push(data[i]["v1"]);
        value4.push(data[i]["v2"]);
        value5.push(data[i]["battery"]);
      }

      if (value4[0] < 51){
        navigator.serviceWorker.ready
        .then(reg => {
          reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: publicKey
          }).then(
            // (B3-1) OK - TEST PUSH NOTIFICATION
            sub => {
              var data = new FormData();
              data.append("sub2", JSON.stringify(sub));
              fetch("functions.php", { method: "POST", body : data })
              .then(res => res.text())
              .then(txt => console.log(txt))
              .catch(err => console.error(err));
            },
       
            // (B3-2) ERROR!
            err => console.error(err)
          );
        });
      }

      let temp = document.getElementById("temp");
      temp.innerHTML = value2[0] + " &deg;C";

      let v1 = document.getElementById("v1");
      v1.innerHTML = value3[0] + " V";
      let v2 = document.getElementById("v2");
      v2.innerHTML = value4[0] + " V";

      let battery = document.getElementById("battery");
      battery.innerHTML = value5[0] + "%";

      let batterybar = document.getElementById("battery-bar");
      batterybar.style.width = value5[0]+"%";
      batterybar.ariaValueNow = value5[0];
      let batteryicon = document.getElementById("battery-icon");

      if (value5[0] == 100){
        batteryicon.className = "bi bi-lightning-charge-fill text-lg opacity-10"}
      else{
        batteryicon.className="bi bi-lightning-charge text-lg opacity-10";
      }
      // mainChart1.data.labels = labelsc;
      // mainChart1.data.datasets[0].data = bpm;
      // mainChart1.update();
      // mainChart2.data.labels = labelsc;
      // mainChart2.data.datasets[0].data = o2;
      // mainChart2.update();
      // suhuchart.data.datasets[0].needleValue = value3[0];
      // suhuchart.update();
      // kelembapanchart.data.datasets[0].needleValue = value2[0];
      // kelembapanchart.update();
      // gaschart.data.datasets[0].needleValue = value1[0];
      // gaschart.update();
      //  console.log(suhuchart.data.datasets[0].needleValue);
    }
  };
  xhttp.send("receivedata=receivedata");
}

function replay2() {
  const xhttp = new XMLHttpRequest();
  xhttp.open("POST", "functions.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhttp.onload = function () {
    var data = JSON.parse(this.responseText);
    console.log(this.responseText);
    if (data.length !== 0) {
      const labelsc = [];
      const value1 = [];
      const value2 = [];
      const value3 = [];
      const value4 = [];
      const value5 = [];
      for (var i = 0; i < data.length; i++) {
        labelsc.push(data[i]["DATE_FORMAT(reading_time, '%H:%i:%s')"]);
        value1.push(data[i]["device"]);
        value2.push(data[i]["temp"]);
        value3.push(data[i]["v1"]);
        value4.push(data[i]["v2"]);
        value5.push(data[i]["battery"]);
      }



    
      // mainChart1.data.labels = labelsc;
      // mainChart1.data.datasets[0].data = bpm;
      // mainChart1.update();
      // mainChart2.data.labels = labelsc;
      // mainChart2.data.datasets[0].data = o2;
      // mainChart2.update();
      // suhuchart.data.datasets[0].needleValue = value3[0];
      // suhuchart.update();
      // kelembapanchart.data.datasets[0].needleValue = value2[0];
      // kelembapanchart.update();
      // gaschart.data.datasets[0].needleValue = value1[0];
      // gaschart.update();
      //  console.log(suhuchart.data.datasets[0].needleValue);
    }
  };
  xhttp.send("receivedata=receivedata&sub2=sub2");
}
