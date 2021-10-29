<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 syntax=php: */
declare(strict_types=1);

namespace App\Controller;

/**
 *
 * 
 */
trait CommonTrait{
    /**
     * overwride log function
     *
     * @auther ikeda.ver2@gmil.com
     */
    public function log($message, $level = \Psr\Log\LogLevel::ERROR, $context = []): bool
    {
        if (!is_string($message)) {
            $message = var_export($message, true);
        }

        $info = 'CommonTrait::Log ' . var_export($this->request->getParam('controller'), true);
        $caller = debug_backtrace();
        $r = 1; // 呼び出し元階層を指定
        for ($i = 0;$i <= $r;$i++) {
            if (!empty($caller[$i])) {
                $info .= ' ' . basename($caller[$i]['file']) . ':' . $caller[$i]['line'];
            }
        }
        return parent::log("$message\n$info", $level, $context);
    }
}
