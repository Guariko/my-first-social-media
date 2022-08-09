/* TODO: Login register starts */

const classToDisplayElement = "active";

const showingPassword = document.querySelector(
  ".login__register__password__container .fa-eye"
);
const hiddingPassword = document.querySelector(
  ".login__register__password__container .fa-eye-slash"
);

const userPassword = document.querySelector(
  ".login__register__inputs__container input[name='password']"
);

showingPassword.addEventListener("click", (e) => {
  userPassword.setAttribute("type", "password");
  removeClass(showingPassword, classToDisplayElement);
  addClass(hiddingPassword, classToDisplayElement);
});

hiddingPassword.addEventListener("click", (e) => {
  userPassword.setAttribute("type", "text");
  removeClass(hiddingPassword, classToDisplayElement);
  addClass(showingPassword, classToDisplayElement);
});

const loginRegisterForm = document.querySelector(".login__register__form");

loginRegisterForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const buttonType = document.querySelector(
    ".login__register__button__container .button"
  );

  let signUp = false;

  if (buttonType.innerHTML.toLowerCase() === "sign up") {
    signUp = true;
  }

  let userName = null;

  if (signUp) {
    userName = document.querySelector(
      ".login__register__inputs__container input[name='name']"
    );
  }

  const userEmail = document.querySelector(
    ".login__register__inputs__container input[name='email']"
  );
  const userPassword = document.querySelector(
    ".login__register__inputs__container input[name='password']"
  );

  let userData =
    "email=" + userEmail.value + "&password=" + userPassword.value + "&signIn=";

  if (signUp) {
    userData =
      "name=" +
      userName.value +
      "&email=" +
      userEmail.value +
      "&password=" +
      userPassword.value +
      "&signUp=";
  }

  const xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function () {
    if (this.status === 200 && this.readyState === XMLHttpRequest.DONE) {
      const parser = new DOMParser();
      const xmlDom = parser.parseFromString(this.responseText, "text/html");
      const loginRegisterInputsContainer = document.querySelectorAll(
        ".login__register__inputs__container"
      );

      const newLoginRegisterInputsContainer = xmlDom.querySelectorAll(
        ".login__register__inputs__container"
      );

      for (
        let index = 0;
        index < loginRegisterInputsContainer.length;
        index++
      ) {
        loginRegisterInputsContainer[index].innerHTML =
          newLoginRegisterInputsContainer[index].innerHTML;
      }

      const redirect = xmlDom.querySelector("#redirect");
      if (redirect.value.length > 0) {
        window.location.href = redirect.value;
      }

      const showingPassword = document.querySelector(
        ".login__register__password__container .fa-eye"
      );
      const hiddingPassword = document.querySelector(
        ".login__register__password__container .fa-eye-slash"
      );

      const newUserPasswordElement = document.querySelector(
        ".login__register__inputs__container input[name='password']"
      );

      showingPassword.addEventListener("click", (e) => {
        newUserPasswordElement.setAttribute("type", "password");
        removeClass(showingPassword, classToDisplayElement);
        addClass(hiddingPassword, classToDisplayElement);
      });

      hiddingPassword.addEventListener("click", (e) => {
        newUserPasswordElement.setAttribute("type", "text");
        removeClass(hiddingPassword, classToDisplayElement);
        addClass(showingPassword, classToDisplayElement);
      });
    }
  };

  if (signUp) {
    xmlhttp.open("POST", "register.php", true);
  } else {
    xmlhttp.open("POST", "login.php", true);
  }

  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xmlhttp.send(userData);
});

/* FIXME: Login register ends */

/* TODO: Functions start */

function addClass(elementToUse, classToAdd) {
  elementToUse.classList.add(classToAdd);
}

function removeClass(elementToUse, classToRemove) {
  elementToUse.classList.remove(classToRemove);
}

/* FIXME: Functions end */
