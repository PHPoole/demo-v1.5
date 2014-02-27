<?php
namespace PHPoole;
use PHPoole\Utils;

/**
 * PHPoole plugin TwBootstrap
 */
Class TwBootstrap extends Plugin
{
    public function preInit($e)
    {
        $phpoole = $e->getTarget();
        $phpoole->addMessage('TwBootstrap plugin available');
    }

    public function postInit($e)
    {
        $phpoole = $e->getTarget();
        $componentsDir = realpath(__DIR__ . '/../../components');
        // bootstrap
        // css
        copy(
            $componentsDir . '/bootstrap/css/bootstrap.min.css',
            $phpoole->getWebsitePath() . '/' . PHPoole::PHPOOLE_DIRNAME . '/' . PHPoole::ASSETS_DIRNAME . '/css/bootstrap.min.css'
        );
        // fonts
        Utils\RecursiveCopy(
            $componentsDir . '/bootstrap/fonts',
            $phpoole->getWebsitePath() . '/' . PHPoole::PHPOOLE_DIRNAME . '/' . PHPoole::ASSETS_DIRNAME . '/fonts'
        );
        // js
        copy(
            $componentsDir . '/bootstrap/js/bootstrap.min.js',
            $phpoole->getWebsitePath() . '/' . PHPoole::PHPOOLE_DIRNAME . '/' . PHPoole::ASSETS_DIRNAME . '/js/bootstrap.min.js'
        );
        // jquery
        copy(
            $componentsDir . '/jquery/jquery.min.js',
            $phpoole->getWebsitePath() . '/' . PHPoole::PHPOOLE_DIRNAME . '/' . PHPoole::ASSETS_DIRNAME . '/js/jquery.min.js'
        );
        $phpoole->addMessage('Twitter Bootstrap assets copied');
    }
}
