<?php

namespace App\Repository\Eloquents;

use App\Models\Produtos;
use Illuminate\Http\Request;

class AuxiliaryRepository {

    public function verifyProdutosCr(Request $request){

        $produto = Produtos::where('name', $request->name)->get();

        if($produto->isNotEmpty()){

            return true;

        } else {

            return false;

        }

    }

    public function verifyProdutosUp(Request $request, $productId) {

        $produto = Produtos::where('name', $request->name)
                        ->where('id', '!=', $productId)
                        ->exists();
                        
        return $produto;
    }
    
}

