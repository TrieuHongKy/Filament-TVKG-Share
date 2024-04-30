<?php

namespace App\Repositories;

use App\Interfaces\LanguageRepositoryInterface;
use App\Models\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function all()
    {
        return Language::paginate(10);
    }

    public function find($id)
    {
        $language = Language::find($id);
        if (!$language) {
            throw new \Exception('Ngôn ngữ không tồn tại');
        }
        return $language;
    }

    public function create($data)
    {
        return Language::create($data);
    }

    public function update($id, $data)
    {
        $language = $this->find($id);
        return $language->update($data);
    }

    public function delete($id)
    {
        $language = $this->find($id);
        return $language->delete();
    }
}
