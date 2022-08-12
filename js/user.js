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
