/* TODO: Setting up the project */

const desktopWidth = 1280;

const isHome = document.querySelector(".home__main");
const isMessaging = document.querySelector(".messaging__main");
const isUserProfile = document.querySelector(".user__profile__main");

const classToDisplayElement = "active";

/* FIXME: Setting up the project ends */

/* TODO: Header starts */

const headerMobileVersionClass = "header__mobile__version";
const headerDesktopVersion = "header__desktop__version";

const header = document.querySelector(".header");

let headerViewPath;

if (isHome) {
  headerViewPath = "views/templates/headerViews/";
} else if (isMessaging) {
  headerViewPath = "templates/headerViews/";
} else if (isUserProfile) {
  headerViewPath = "templates/headerViews/";
}

getHeaderView(headerViewPath);

window.addEventListener("resize", (e) => {
  getHeaderView(headerViewPath);
});

/* FIXME: Header ends */

/* TODO: Function starts */

function getHeaderView(headerViewPath) {
  const xmlhttp = new XMLHttpRequest();

  let headerView;

  if (window.innerWidth < desktopWidth) {
    addClass(header, headerMobileVersionClass);
    removeClass(header, headerDesktopVersion);
    headerView = headerViewPath + "headerMobileVersion.php";
  } else {
    addClass(header, headerDesktopVersion);
    removeClass(header, headerMobileVersionClass);
    headerView = headerViewPath + "headerDesktopVersion.php";
  }

  xmlhttp.onreadystatechange = function () {
    if (this.status === 200 && this.readyState === 4) {
      header.innerHTML = this.responseText;
    }
  };

  xmlhttp.open("GET", headerView, true);

  xmlhttp.send();
}

function addClass(elementToUse, classToAdd) {
  elementToUse.classList.add(classToAdd);
}

function removeClass(elementToUse, classToRemove) {
  elementToUse.classList.remove(classToRemove);
}

/* FIXME: Function ends */
