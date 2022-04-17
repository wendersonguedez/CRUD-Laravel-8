<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // valor default é 'false'. valor 'true' para verificação se pode ou não fazer essa ação (cadastrar ou editar). 
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // Validações dos campos do banco.
    public function rules()
    {
        // Capturando o 'id' do post, utilizando o segmento da URL.
        $id = $this->segment(2);

        // Variável para validações.
        $rules = [
            'title' => [
                'required',
                'min:3',
                'max:160',
                // Valor de 'title' é unico na tabela 'posts' e ignora seu 'id'.
                Rule::unique('posts')->ignore($id),
            ],
            'content' => ['nullable', 'min:5', 'max:10000'],
            'image' => ['required', 'image']
        ];

        // Caso o método HTTP seja 'PUT' (edição).
        if ($this->method() == 'PUT') {
            // Atualizando as validações para o campo 'image'. Permitindo que seja null, mas caso tenha valor, garante que seu valor seja uma imagem. 
            $rules['image'] = ['nullable', 'image'];
        }

        return $rules;
    }
}
