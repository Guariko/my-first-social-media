const messagingFriendContainers = document.querySelectorAll(
  ".messaging__friend__container"
);

const chat = document.querySelector(".chat");

const chatFriendContainer = document.querySelector(".chat__friend__container");

const chatContainer = document.querySelector(".chat__section");
const sendMessageForm = document.querySelector(".send__message__container");

messagingFriendContainers.forEach((messagingFriendContainer) => {
  messagingFriendContainer.addEventListener("click", (e) => {
    addClass(chatContainer, classToDisplayElement);

    let friendName = messagingFriendContainer.querySelector("h2").innerText;
    let friendImagePath = messagingFriendContainer
      .querySelector("img")
      .getAttribute("src");

    let xmlhttp = new XMLHttpRequest();

    $dataToSend =
      "friendName=" +
      friendName +
      "&friendImagePath=" +
      friendImagePath +
      "&getChatFriendInformations=";

    xmlhttp.onreadystatechange = function () {
      if (this.status === 200 && this.readyState === 4) {
        chatFriendContainer.innerHTML = this.responseText;
        goOutChatFriendContainer = document.querySelector(
          ".chat__friend__container .fa-angle-left"
        );
        goOutChatFriendContainer.addEventListener("click", (e) => {
          removeClass(chatContainer, classToDisplayElement);
          chat.innerHTML = null;
        });
      }
    };

    xmlhttp.open("GET", "messagingViews/chatFriend.php?" + $dataToSend, true);
    xmlhttp.send();
  });
});

messagingFriendContainers.forEach((messagingFriendContainer) => {
  messagingFriendContainer.addEventListener("click", (e) => {
    let friendId = messagingFriendContainer.dataset.friendid;

    const messageViewPath = "messagingViews/messages.php";

    let messageDataNeeds = "?getMessages=&friendId=" + friendId;

    let getChatMessage = new XMLHttpRequest();

    getChatMessage.onreadystatechange = () => {
      if (getChatMessage.status === 200 && getChatMessage.readyState === 4) {
        chat.innerHTML = getChatMessage.responseText;
      }
    };

    getChatMessage.open("GET", messageViewPath + messageDataNeeds, true);
    getChatMessage.send();

    sendMessageForm.onsubmit = (e2) => {
      e2.preventDefault();

      let userMessage = document.querySelector(".user__message__input");

      const userMessageMinLength = 1;
      const userMessageMaxLength = 3000;

      if (
        userMessage.value.trim().length >= userMessageMinLength &&
        userMessage.value.length <= userMessageMaxLength
      ) {
        let sendUserMessage = new XMLHttpRequest();

        let dataToSend =
          "sendMessage=&userMessage=" +
          userMessage.value +
          "&friendId=" +
          friendId;

        sendUserMessage.onreadystatechange = () => {
          if (
            sendUserMessage.status === 200 &&
            sendUserMessage.readyState === XMLHttpRequest.DONE
          ) {
            userMessage.value = null;
            chat.innerHTML = sendUserMessage.responseText;
          }
        };

        sendUserMessage.open("POST", messageViewPath, true);

        sendUserMessage.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );

        sendUserMessage.send(dataToSend);
      } else {
        userMessage.value = null;
      }
    };
  });
});

let dataToSendToGetMessages;

window.addEventListener("load", (e) => {
  dataToSendToGetMessages = "messagingViews/messages.php?dontUpdate=";
  updateMessages(chat, dataToSendToGetMessages);
});

setInterval(() => {
  dataToSendToGetMessages = "messagingViews/messages.php";
  updateMessages(chat, dataToSendToGetMessages);
}, 1000);

/* TODO: Functions start */

function updateMessages(chatToUpdate, dataToSend) {
  let updateMessagesRequest = new XMLHttpRequest();

  updateMessagesRequest.onreadystatechange = () => {
    if (
      updateMessagesRequest.status === 200 &&
      updateMessagesRequest.readyState === 4
    ) {
      if (updateMessagesRequest.responseText) {
        chatToUpdate.innerHTML = updateMessagesRequest.responseText;
      }
    }
  };

  updateMessagesRequest.open("GET", dataToSend, true);
  updateMessagesRequest.send();
}

/* FIXME: Functions end */
