<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageLayout
 *
 * @author skwakwa
 */
class PageLayout extends Eloquent {

    protected $table = "cms_page_layout";

    public function pageElements(){
        return $this->hasMany('App\Models\PageElement', 'layout_id', 'id');
    }
    
    public function sublayouts() {
        return $this->hasMany('App\Models\PageElement', 'layout_id', 'id')->where('parent_id',0);
    }

    
    public function layoutSorted(){
        $layouts = $this->layouts();
        $parentOrders = array();
        $startsWith =0;
        foreach ($parentOrders as $value) {
            if($value->parent_id==$startsWith)
            {
                $parentOrders[] = $value;
            }
        }
        
        foreach ($parentOrders as $key=>$value) {
            
        }
    }

}
