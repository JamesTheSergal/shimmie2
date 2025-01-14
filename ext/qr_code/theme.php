<?php

declare(strict_types=1);
class QRImageTheme extends Themelet
{
    public function links_block(string $link)
    {
        global $page;

        $page->add_block(new Block(
            "QR Code",
            "<img alt='QR Code' src='//chart.apis.google.com/chart?chs=150x150&amp;cht=qr&amp;chl={$link}' />",
            "left",
            50
        ));
    }
}
