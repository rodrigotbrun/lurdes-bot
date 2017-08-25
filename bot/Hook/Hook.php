<?php

namespace Hook;

class Hook {

    /** @var Hook */
    private static $instance = null;

    /** @var array */
    private static $hooks = [];

    /**
     * Hook constructor.
     * @internal param $hooks
     * @param array $extras
     */
    public function __construct(array $extras = []) {
        self::$hooks = require base_path('bot/Config/hooks.php');

        if (count($extras) > 0) {
            foreach ($extras as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null)
            self::$instance = new Hook();
        return self::$instance;
    }

    public function fire($hookName, array $extras = []) {
        if (isset(self::$hooks[$hookName])) {
            $class = self::$hooks[$hookName];
            if (!is_array($class)) {
                if (class_exists($class, true)) {
                    $hookClass = new $class($extras);
                    if ($hookClass instanceof Runnable) {
                        $hookClass->run();
                    } else {
                        throw new \Exception('[' . $class . '] Hooks must implements the "\Hook\Runnable" interface!');
                    }
                } else {
                    throw new \Exception('[' . $class . '] Hook not found!');
                }
            } else {
                if (count($class) > 0) {
                    foreach ($class as $c) {
                        if (class_exists($c, true)) {
                            $hookClass = new $c($extras);
                            if ($hookClass instanceof Runnable) {
                                $hookClass->run();
                            } else {
                                throw new \Exception('[' . $c . '] Hooks must implements the "\Hook\Runnable" interface!');
                            }
                        } else {
                            throw new \Exception('[' . $c . '] Hook not found!');
                        }
                    }
                }
            }
        }
    }

}