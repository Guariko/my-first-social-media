<?php

foreach ($usersData as $userData) : ?>

    <div class="messaging__friend__container">

        <figure class="friend__image__container">
            <img src="<?= $friendImagePath ?>" alt="" class="friend__image">
        </figure>

        <h2 class="friend__name"> <?= $userData["name"] ?> </h2>

    </div>

<?php endforeach;
