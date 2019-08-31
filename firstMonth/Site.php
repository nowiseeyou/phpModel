<?php
/**
 * Class Site
 */

class Site
{
    private $sites = array(
        1=>"taobao",
        2=>"jd",
        3=>"qq",
        4=>"sina",
        5=>"google",
        6=>"baidu",
    );

    public function getAllSite(){
        return $this->sites;
    }

    public function getSite($id){

        $site = isset($this->sites[$id]) ? $this->sites[$id] : $this->sites[1];
        return $site;

    }
}