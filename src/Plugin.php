<?php
/**
 * @link https://carterdigital.com.au/
 * @copyright Copyright (c) Carter Digital.
 * @license MIT
 */

namespace carterdigital\commerce\merchantwarrior;

use yii\base\Event;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\commerce\services\Gateways;
use craft\events\RegisterComponentTypesEvent;

/**
 * Plugin represents the Merchant Warrior integration plugin.
 *
 * @author Andrey Ignatyev <andrey@carterdigital.com.au>
 * @since 1.0
 */
class Plugin extends BasePlugin
{
    public function init()
    {
        parent::init();        

        Event::on(
            Gateways::class,
            Gateways::EVENT_REGISTER_GATEWAY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = Gateway::class;
            }
        );
        
        Craft::info(
            Craft::t(
                'carterdigital-commerce-merchant-warrior',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

}