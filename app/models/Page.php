<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Page
 *
 * @author skwakwa
 */
class Page  extends Eloquent {
    
    protected $table="cms_page";
     public function layouts() {
        return $this->hasMany('PageLayout', 'page_id','id');
    }
}
