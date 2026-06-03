<?php

declare(strict_types=1);

/**
 * Brand logo mark.
 *
 * @var int $logoSize  Pixel width/height (default 38)
 * @var string $logoClass  Wrapper class (default logo-icon)
 */
$logoSize = (int) ($logoSize ?? 38);
$logoClass = (string) ($logoClass ?? 'logo-icon');
?>
<div class="<?= e($logoClass) ?>" style="width:<?= $logoSize ?>px;height:<?= $logoSize ?>px">
  <img
    src="<?= e(asset('images/logo.png')) ?>"
    alt="New Way Consultancy"
    width="<?= $logoSize ?>"
    height="<?= $logoSize ?>"
    loading="eager"
    decoding="async"
  >
</div>
