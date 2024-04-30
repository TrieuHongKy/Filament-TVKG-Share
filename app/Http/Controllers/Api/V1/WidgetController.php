<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WidgetCollection;
use App\Http\Resources\WidgetResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Response\ApiRespone;
use App\Services\WidgetService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WidgetController extends Controller{

    use ApiResponseTrait;

    protected $widgetService;

    public function __construct(WidgetService $widgetService){
        $this->widgetService = $widgetService;
    }

    /**
     * get all widgets
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $widgets = new WidgetCollection($this->widgetService->getAllWidgets());

        return $this->responseWithResourceCollection($widgets);
    }

    /**
     * show widget by id
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function show($id)
    : JsonResponse{
        $widget = new WidgetResource($this->widgetService->getWidgetById($id));

        return $this->responseWithResource($widget, 'Widget retrieved successfully.');
    }

    /**
     * show widget by key
     *
     * @param mixed $key
     *
     * @return JsonResponse
     */
    public function showByKey($key)
    : JsonResponse{
        $widget = new WidgetResource($this->widgetService->getWidgetByKey($key));

        return $this->responseWithResource($widget, 'Widget retrieved successfully.');
    }

    /**
     * store new widget
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    : JsonResponse{
        try{
            $widget = new WidgetResource($this->widgetService->createWidget($request->all()));

            return $this->responseWithResource($widget, 'Widget created successfully.', 201);
        }catch (Exception $e){
            return $this->apiResponse(['success' => FALSE, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * update widget
     *
     * @param mixed $request
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    : JsonResponse{
        try{
            $widget = new WidgetResource($this->widgetService->updateWidget($request, $id));

            return $this->responseWithResource($widget, 'Widget updated successfully.');
        }catch (Exception $e){
            return $this->apiResponse(['success' => FALSE, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * delete widget
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    : JsonResponse{
        try{
            $this->widgetService->deleteWidget($id);

            return $this->apiResponse(['success' => TRUE, 'message' => 'Widget deleted successfully.']);
        }catch (Exception $e){
            return $this->apiResponse(['success' => FALSE, 'message' => $e->getMessage()], 500);
        }
    }
}
