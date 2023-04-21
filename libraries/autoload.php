<?php
class AutoLoad
{
    public function __construct()
    {
        spl_autoload_register(array($this, '_autoLoadLib'));
    }

    private function _autoLoadLib($file)
    {
        $file = LIBRARIES . "class/class." . trim($file) . '.php';
        if (file_exists($file)) require_once $file;
    }
}
?>