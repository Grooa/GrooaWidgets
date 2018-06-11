<?php
$hasTransparentBackground = !empty($hasTransparentBackground) ? $hasTransparentBackground : false;
?>

<article class="page-module page-module-compact <?= !$hasTransparentBackground ? 'page-module-light' : '' ?>">
    <?php if (!empty($backgroundCover)): ?>
        <div class="page-module-header">
            <div class="gw-image-container">
                <img src="<?= ipFileUrl('file/repository/' . $backgroundCover[0]) ?>"
                     alt="<?= !empty($title) ? $title : '[Widget header]' ?>">
            </div>
            <div class="gw-title-frame">
                <div class="gw-title-container">
                    <h2><?= $title ?></h2>

                    <?php if (!empty($subTitle)): ?>
                        <em><?= $subTitle ?></em>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <h2 class="gw-title"><?= $title ?></h2>

        <?php if (!empty($subTitle)): ?>
            <em class="gw-sub-title"><?= $subTitle ?></em>
        <?php endif; ?>
    <?php endif; ?>

    <div class="page-module-main gw-page-module-main"><?= !empty($text) ? $text : '' ?></div>
</article>
