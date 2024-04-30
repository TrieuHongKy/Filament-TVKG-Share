<?php

namespace App\Repositories;

use App\Interfaces\ContactRepositoryInterface;
use App\Models\Contact;

class ContactRepository implements ContactRepositoryInterface{

    public function all(){
        return Contact::paginate(10);
    }

    public function find($id){
        $contact = Contact::find($id);
        if (!$contact){
            throw new \Exception('Liên hệ không tồn tại.');
        }

        return $contact;
    }

    public function create($data){
        return Contact::create($data);
    }

    public function delete($id){
        $contact = $this->find($id);

        return $contact->delete();
    }
}
