<?php
namespace PHPoole;
use PHPoole\Utils;

/**
 * PHPoole plugin Bootsite
 */
Class Bootsite extends Plugin
{
    public function preInit($e)
    {
        $phpoole = $e->getTarget();
        $phpoole->addMessage('Bootsite plugin available');
    }

    public function postInit($e)
    {
        $phpoole = $e->getTarget();
        Utils\RecursiveCopy(
            __DIR__ . '/assets',
            $phpoole->getWebsitePath() . '/' . PHPoole::PHPOOLE_DIRNAME . '/' . PHPoole::ASSETS_DIRNAME
        );
        Utils\RecursiveCopy(
            __DIR__ . '/layouts',
            $phpoole->getWebsitePath() . '/' . PHPoole::PHPOOLE_DIRNAME . '/' . PHPoole::LAYOUTS_DIRNAME
        );
        $phpoole->addMessage('Bootsite layouts and assets copied');
    }
}
