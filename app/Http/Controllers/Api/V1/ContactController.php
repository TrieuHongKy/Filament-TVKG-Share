<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\ContactService;
use Exception;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller{

    use ApiResponseTrait;

    protected $contactService;

    public function __construct(contactService $contactService){
        $this->contactService = $contactService;
    }

    /**
     * get all contact
     *
     * @return JsonResponse
     */
    public function index()
    : JsonResponse{
        $contact = new ContactCollection($this->contactService->getAllContact());

        return $this->responseWithResourceCollection($contact);
    }

    /**
     * show language by ids
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function show($id)
    : JsonResponse{
        try{
            $contact = new ContactResource($this->contactService->getContactById($id));

            return $this->responseWithResource($contact, 'Hiển thị liên hệ thành công');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**
     * store new contact
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function store(ContactRequest $request)
    : JsonResponse{
        try{
            $contact = new ContactResource($this->contactService->createContact($request->all()));

            return $this->responseWithResource($contact, 'Gửi liên hệ thành công', 201);
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }

    /**`
     * delete contact
     *
     * @param mixed $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    : JsonResponse{
        try{
            $this->contactService->deleteContact($id);

            return $this->responseWithMessage('Xoá liên hệ thành công.');
        }catch (Exception $e){
            return $this->responseWithError($e->getMessage(), 400);
        }
    }
}
