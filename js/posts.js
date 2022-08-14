const likes = document.querySelectorAll(".like");

likes.forEach((like) => {
  like.addEventListener("click", (e) => {
    let postId = like.dataset.postid;

    let dataToSend = "updatePostReaction=&postReactionId=" + postId;

    let updateReactionRequest = new XMLHttpRequest();

    updateReactionRequest.onreadystatechange = () => {
      if (
        updateReactionRequest.status === 200 &&
        updateReactionRequest.readyState === XMLHttpRequest.DONE
      ) {
        let postReactions = document.getElementById(postId);
        let dataGiven = updateReactionRequest.responseText.split(",");
        let likeIcon = like.querySelector(".fa-thumbs-up");
        if (dataGiven[0] === "active") {
          addClass(likeIcon, classToDisplayElement);
          postReactions.innerHTML = dataGiven[1];
        } else {
          removeClass(likeIcon, classToDisplayElement);
          postReactions.innerHTML = dataGiven[0];
        }
      }
    };

    updateReactionRequest.open(
      "POST",
      "configs/controllers/usersPostController.php",
      true
    );
    updateReactionRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    updateReactionRequest.send(dataToSend);
  });
});
