<?php

namespace App\Services;

use App\Interfaces\WidgetRepositoryInterface;

class WidgetService{

    protected $widgetRepository;

    public function __construct(WidgetRepositoryInterface $widgetRepository){
        $this->widgetRepository = $widgetRepository;
    }

    public function getAllWidgets(){
        return $this->widgetRepository->all();
    }

    public function getWidgetById($id){
        return $this->widgetRepository->find($id);
    }

    public function getWidgetByKey($key){
        return $this->widgetRepository->getWidget($key);
    }

    public function createWidget($data){
        return $this->widgetRepository->create($data);
    }

    public function updateWidget($id, $data){
        return $this->widgetRepository->update($id, $data);
    }

    public function deleteWidget($id){
        return $this->widgetRepository->delete($id);
    }
}
