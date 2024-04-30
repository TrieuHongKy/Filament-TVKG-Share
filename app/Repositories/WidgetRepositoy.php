<?php

namespace App\Repositories;

use App\Interfaces\WidgetRepositoryInterface;
use App\Models\Widget;

class WidgetRepository implements WidgetRepositoryInterface{

    public function all(){
        return Widget::paginate(10);
    }

    public function find($id){
        return Widget::find($id);
    }

    public function getWidget($key){
        return Widget::where('key', $key)->first();
    }

    public function create($data){
        return Widget::create($data);
    }

    public function update($id, $data){
        $widget = Widget::find($id);
        $widget->update($data);

        return $widget;
    }

    public function delete($id){
        return Widget::find($id)->delete();
    }
}
