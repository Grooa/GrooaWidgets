<?php
namespace Plugin\GrooaWidgets;

class Event
{
    public static function ipBeforeController($data) {
        ipAddCss('assets/grooaWidget.css');
    }
}
