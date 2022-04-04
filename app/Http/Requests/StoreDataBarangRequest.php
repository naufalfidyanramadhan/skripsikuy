<?php

namespace App\Http\Requests;

use App\Models\DataBarang;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDataBarangRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('data_barang_create');
    }

    public function rules()
    {
        return [
            'nama' => [
                'string',
                'required',
            ],
            'kategori' => [
                'string',
                'required',
            ],
            'varian' => [
                'string',
                'required',
            ],
        ];
    }
}
