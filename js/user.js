const userImageInput = document.querySelector(".user__image__input");
const userImageForm = document.querySelector(".select__user__image__form");

userImageInput.addEventListener("change", (e) => {
  let updateUserImageRequest = new XMLHttpRequest();
  let userImageData = new FormData(userImageForm);

  updateUserImageRequest.onreadystatechange = () => {
    if (
      updateUserImageRequest.status === 200 &&
      updateUserImageRequest.readyState === XMLHttpRequest.DONE
    ) {
      if (updateUserImageRequest.responseText !== "error") {
        let headerUserImage = document.querySelector(".user__image__desktop");
        let currentUserImage = document.querySelector(".current__user__image");
        currentUserImage.setAttribute(
          "src",
          updateUserImageRequest.responseText
        );
        headerUserImage.setAttribute(
          "src",
          updateUserImageRequest.responseText
        );
      }
    }
  };
  updateUserImageRequest.open(
    "POST",
    "../configs/controllers/userProfileController.php",
    true
  );

  updateUserImageRequest.send(userImageData);
});

const openChangePasswordContainer = document.querySelector(
  ".change__password__button"
);

const closeChangePasswordContainer = document.querySelector(
  ".change__password__form .fa-times"
);

const changePasswordContainer = document.querySelector(
  ".change__password__container"
);

const changePasswordErrorMessage =
  changePasswordContainer.querySelector(".error__message");

openChangePasswordContainer.addEventListener("click", (e) => {
  addClass(changePasswordContainer, classToDisplayElement);
});

closeChangePasswordContainer.addEventListener("click", (e) => {
  removeClass(changePasswordContainer, classToDisplayElement);
});

const changePasswordForm = document.querySelector(".change__password__form");

changePasswordForm.addEventListener("submit", (e) => {
  let changePasswordRequest = new XMLHttpRequest();

  let changePasswordFormData = new FormData(changePasswordForm);

  changePasswordFormData.append("update__password", "true");

  changePasswordRequest.onreadystatechange = () => {
    if (
      changePasswordRequest.status === 200 &&
      changePasswordRequest.readyState === XMLHttpRequest.DONE
    ) {
      changePasswordForm.innerHTML = changePasswordRequest.responseText;

      changePasswordForm.replaceChild(
        closeChangePasswordContainer,
        changePasswordForm.querySelector(".fa-times")
      );
      closeChangePasswordContainer.onclick = () => {
        const changePasswordInputs =
          changePasswordForm.querySelectorAll("input");
        changePasswordInputs.forEach((changePasswordInput) => {
          changePasswordInput.value = null;
        });

        const changePasswordErrors = changePasswordForm.querySelectorAll("p");
        changePasswordErrors.forEach((error) => {
          if (error.classList.contains(classToDisplayElement)) {
            removeClass(error, classToDisplayElement);
            error.innerHTML = null;
          }
        });
      };
    }
  };

  changePasswordRequest.open(
    "POST",
    "userProfileViews/updatePassword.php",
    true
  );
  changePasswordRequest.send(changePasswordFormData);

  e.preventDefault();
});

const startPostContainer = document.querySelector(".start__post__container");
const openPostContainer = document.querySelector(".post__button");
const closeStartPostContainer = document.querySelector(
  ".start__post__form .fa-times"
);

openPostContainer.addEventListener("click", (e) => {
  addClass(startPostContainer, classToDisplayElement);
});

closeStartPostContainer.addEventListener("click", (e) => {
  removeClass(startPostContainer, classToDisplayElement);

  const unsetPostImageRequest = new XMLHttpRequest();
  let unsetImageDataToSend = "unsetPostImage=";

  unsetPostImageRequest.onreadystatechange = () => {
    if (
      unsetPostImageRequest.status === 200 &&
      unsetPostImageRequest.readyState === unsetPostImageRequest.DONE
    ) {
      let changePostImage = startPostContainer.querySelector("img");
      changePostImage.setAttribute("src", "../images/user.png");
    }
  };

  unsetPostImageRequest.open(
    "POST",
    "../configs/controllers/userViewsController.php",
    true
  );
  unsetPostImageRequest.setRequestHeader(
    "Content-type",
    "application/x-www-form-urlencoded"
  );
  unsetPostImageRequest.send(unsetImageDataToSend);
});

const startPostForm = document.querySelector(".start__post__form");

startPostForm.addEventListener("submit", (e) => {
  const postMessage = document.querySelector(".post__message");
  const postMessageMinLength = 1;
  const postMessageMaxLength = 3000;

  if (
    postMessage.value.length >= postMessageMinLength &&
    postMessage.value.length <= postMessageMaxLength
  ) {
    const startPostRequest = new XMLHttpRequest();

    const startPostData = new FormData(startPostForm);
    startPostData.append("startPost", "true");

    startPostRequest.onreadystatechange = () => {
      if (
        startPostRequest.status === 200 &&
        startPostRequest.readyState === XMLHttpRequest.DONE
      ) {
        if (startPostRequest.responseText === "success") {
          postMessage.value = null;
          let postImageInput =
            startPostForm.querySelector("input[type='file']");
          postImageInput.value = null;
          removeClass(startPostContainer, classToDisplayElement);
          let portImage = startPostForm.querySelector("img");
          portImage.setAttribute("src", "../images/user.png");
        }
      }
    };

    startPostRequest.open(
      "POST",
      "../configs/controllers/userViewsController.php",
      true
    );
    startPostRequest.send(startPostData);
  }

  e.preventDefault();
});

const postImage = document.querySelector("#post__image");

postImage.addEventListener("change", (e) => {
  const displayPostImageRequest = new XMLHttpRequest();

  const postFormData = new FormData(startPostForm);

  postFormData.append("displayPostImage", "true");

  displayPostImageRequest.onreadystatechange = () => {
    if (
      displayPostImageRequest.status === 200 &&
      displayPostImageRequest.readyState === XMLHttpRequest.DONE
    ) {
      if (displayPostImageRequest.responseText !== "error") {
        let postImageContainer = document.querySelector(".post__image");

        postImageContainer.setAttribute(
          "src",
          "../images/postImages/" + displayPostImageRequest.responseText
        );
      }
    }
  };

  displayPostImageRequest.open(
    "POST",
    "../configs/controllers/userViewsController.php",
    true
  );
  displayPostImageRequest.send(postFormData);
});
