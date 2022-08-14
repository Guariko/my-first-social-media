<?php foreach ($postCommentsData as $postCommendData) : ?>

    <?php
    $commentOwnerData = DataBase::getUserDataById($postCommendData["user_id"]);
    $commentOwnerImage = $commentOwnerData["user_image"];
    $commentOwner = $commentOwnerData["name"];

    ?>

    <div class="comment__container">
        <div class="comment__user__information">
            <img src="<?= "images/" . $commentOwnerImage ?>" alt="" class="comment__image">
            <div class="comment__name__paragraph">

                <h2 class="comment__name"><?= $commentOwner ?></h2>
                <div class="comment__message__container">
                    <p class="comment">
                        <?= $postCommendData["comment"] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>