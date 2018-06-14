<?php
namespace Plugin\GrooaWidgets;

class Event
{
    public static function ipBeforeController($data) {
        ipAddCss('assets/grooaWidget.css');

        if (ipConfig()->isDevelopmentEnvironment()) {
            ipAddJs('assets/dist/bundle.js', ['defer' => 'defer']);
        } else {
            ipAddJs('assets/dist/bundle.min.js', ['defer' => 'defer']);
        }
    }
}
