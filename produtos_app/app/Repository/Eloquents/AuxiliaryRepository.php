<?php

namespace App\Repository\Eloquents;

use App\Models\Produtos;
use Illuminate\Http\Request;

class AuxiliaryRepository {

    public function verifyProdutosCr(Request $request){

        if(Produtos::select()->where('name', $request->name)){

            return false;

        } else {

            return true;

        }

    }

    public function verifyProdutosUp(Request $request) {
        return Produtos::where('name', $request->name)
                       ->where('id', '!=', $request->id)
                       ->exists();

    }
    
}

