<?php


class gjShortUrlTable extends PlugingjShortUrlTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('gjShortUrl');
    }
}