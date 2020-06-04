<?php
/**
 * @link https://carterdigital.com.au/
 * @copyright Copyright (c) Carter Digital.
 * @license MIT
 */

namespace carterdigital\commerce\merchantwarrior;

use yii\base\Event;

use craft\base\Plugin as BasePlugin;
use craft\commerce\services\Gateways;
use craft\events\RegisterComponentTypesEvent;

use carterdigital\commerce\merchantwarrior\gateways\Gateway;

/**
 * Plugin represents the Merchant Warrior integration plugin.
 *
 * @author Andrey Ignatyev <andrey@carterdigital.com.au>
 * @since 1.0
 */
class Plugin extends BasePlugin
{      
    // Static Properties
    // =========================================================================

    /**
     * @var Plugin
     */
    public static $plugin;

    // Public Properties
    // =========================================================================
    
    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
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
    }
}