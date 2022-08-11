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
