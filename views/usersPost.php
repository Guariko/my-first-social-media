<?php

foreach ($postsData as $postData) : ?>

    <?php

    $userId = $postData["user_id"];
    $userPostInformation = DataBase::getUserDataById($userId);

    $userImagesPath = "images/";
    $postImagesPath = "images/postImages/";


    $postDateTime = $postData["datetime"];

    $postDateTime = str_replace("-", "/", $postDateTime);

    $postMessage = $postData["message"];
    $seeMore = null;

    $postMaxLengthToDisplay = 120;

    if (strlen($postMessage) > $postMaxLengthToDisplay) {
        $_SESSION["postDataId" . $postData["id"]]["originalMessage"] = $postMessage;
        $postMessage = substr($postMessage, 0, $postMaxLengthToDisplay);
        $postMessage = trim($postMessage) . "...";
        $seeMore = "see more";
    }

    $displayElement = null;

    $reactionData["userId"] = $_SESSION["userData"]["id"];
    $reactionData["postId"] = $postData["id"];
    $liked = DataBase::reactionExists($reactionData);

    if ($liked) {
        $displayElement = "active";
    }

    $postCommentsData = DataBase::getPostCommentsData($postData["id"]);

    ?>

    <article class="post__container">

        <div class="user__post__information">

            <div class="user__post__image__conainer">
                <img src="<?= $userImagesPath . $userPostInformation["user_image"] ?>" alt="" class="user__post__image">
            </div>
            <div class="user__name__datetime">

                <h2 class="user__post__name">
                    <?= $userPostInformation["name"] ?>
                </h2>
                <mark class="post__datetime"> <?= $postDateTime ?> </mark>
            </div>
        </div>

        <div class="user__post__content__container">
            <p class="user__post__message" data-postid="<?= $postData["id"] ?>"> <?= $postMessage ?>

                <?php if ($seeMore) : ?>
                    <mark class="see__more"><?= $seeMore ?></mark>
                <?php endif; ?>
            </p>
        </div>

        <?php if ($postData["post_image"]) : ?>

            <picture class="post__image__container">
                <img src="<?= $postImagesPath . $postData["post_image"] ?>" alt="" class="post__image">
            </picture>

        <?php endif; ?>

        <div class="reactions__container">

            <div class="mini__reactons__container">
                <i class="fa-solid fa-thumbs-up"></i> <i class="fa-solid fa-heart"></i> <i class="fa-solid fa-face-grin-squint-tears"></i>
                <mark class="number__of__reactions" id="<?= $postData["id"] ?>"> <?= $postData["reactions"] ?> </mark>
            </div>
            <div class="reactions">
                <mark class="reaction like" data-postid="<?= $postData["id"] ?>"> <i class="fa-solid fa-thumbs-up <?= $displayElement ?> "></i> like</mark>
                <mark class="reaction"> <i class="fa-solid fa-comment"></i> comment</mark>
            </div>

        </div>

        <div class="comments__container">

            <form action="" method="POST" class="comment__form" data-postid="<?= $postData["id"] ?>">
                <textarea name="user__comment" cols="30" rows="10" placeholder="Say something about this post" class="user__comment"></textarea>
                <button type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>

            <article class="comments" data-postid="<?= $postData["id"] ?>">

                <?php if ($postCommentsData) {
                    include("configs/controllers/commentsController.php");
                } ?>

            </article>

        </div>

    </article>

<?php endforeach;
