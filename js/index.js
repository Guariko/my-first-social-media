/* TODO: Setting up the project */

const desktopWidth = 1280;

/* FIXME: Setting up the project ends */

/* TODO: Header starts */

const headerMobileVersionClass = "header__mobile__version";
const headerDesktopVersion = "header__desktop__version";

const header = document.querySelector(".header");
getHeaderView();

window.addEventListener("resize", (e) => {
  getHeaderView();
});

/* TODO: Function starts */

function getHeaderView() {
  const xmlhttp = new XMLHttpRequest();

  let headerView;

  if (window.innerWidth < desktopWidth) {
    addClass(header, headerMobileVersionClass);
    removeClass(header, headerDesktopVersion);
    headerView = "views/templates/headerViews/headerMobileVersion.php";
  } else {
    addClass(header, headerDesktopVersion);
    removeClass(header, headerMobileVersionClass);
    headerView = "views/templates/headerViews/headerDesktopVersion.php";
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
