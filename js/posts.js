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

const postMessages = document.querySelectorAll(".user__post__message");

postMessages.forEach((postMessage) => {
  let seeMore = postMessage.querySelector(".see__more");
  if (seeMore) {
    seeMore.addEventListener("click", (e) => {
      let messageInnerHtmlHidden = postMessage.innerHTML;
      let seeMoreRequest = new XMLHttpRequest();

      let dataToSend = "seeMore=&postId=" + postMessage.dataset.postid;

      seeMoreRequest.onreadystatechange = () => {
        if (
          seeMoreRequest.status === 200 &&
          seeMoreRequest.readyState === XMLHttpRequest.DONE
        ) {
          postMessage.innerHTML = seeMoreRequest.responseText;
          let hideSeeMore = document.createElement("mark");
          addClass(hideSeeMore, "hide");
          hideSeeMore.innerHTML = " Show less";
          postMessage.appendChild(hideSeeMore);
          hideSeeMore.addEventListener("click", (e) => {
            postMessage.innerHTML = messageInnerHtmlHidden;
            postMessage.replaceChild(
              seeMore,
              postMessage.querySelector(".see__more")
            );
          });
        }
      };
      seeMoreRequest.open(
        "POST",
        "configs/controllers/usersPostController.php",
        true
      );

      seeMoreRequest.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );

      seeMoreRequest.send(dataToSend);
    });
  }
});

const commentForms = document.querySelectorAll(".comment__form");

commentForms.forEach((commentForm) => {
  commentForm.addEventListener("submit", (e) => {
    let userComment = commentForm.querySelector("textarea");
    const minCommentLength = 1;
    const maxCommentLength = 3000;
    if (
      userComment.value.length >= minCommentLength &&
      userComment.value.length <= maxCommentLength
    ) {
      let addCommentRequest = new XMLHttpRequest();
      let postId = parseInt(commentForm.dataset.postid);

      let commentData = new FormData(commentForm);
      commentData.append("addComment", "true");
      commentData.append("postId", postId);

      addCommentRequest.onreadystatechange = () => {
        if (
          addCommentRequest.status === 200 &&
          addCommentRequest.readyState === XMLHttpRequest.DONE
        ) {
          userComment.value = null;
          let commentsContainer = commentForm.nextElementSibling;
          commentsContainer.innerHTML = addCommentRequest.responseText;
        }
      };

      addCommentRequest.open(
        "POST",
        "configs/controllers/usersPostController.php",
        true
      );
      addCommentRequest.send(commentData);
    }

    if (userComment.value.length > maxCommentLength) {
      userComment.value = null;
    }

    e.preventDefault();
  });
});
