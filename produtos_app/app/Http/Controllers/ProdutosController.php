<?php

namespace App\Http\Controllers;

use App\Repository\Eloquents\BaseRepository;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    protected $BaseRepository;

    public function __construct(BaseRepository $BaseRepository) {
        $this->BaseRepository = $BaseRepository;
    }

    //metodo para listar todos os produtos
    public function index() {

        return $this->BaseRepository->index();

    }

    //metodo para cadastrar um novo produto
    public function store(Request $req){

        return $this->BaseRepository->store($req);
        
    }

    //metodo para atualizar (respeitando as regras para adicionar um dado)
    public function update(Request $req, $productId) {
        
        return $this->BaseRepository->update($req, $productId);
        
    }
    
    //metodo para exibir apenas um produto
    public function viewProduct($productId) {

        return $this->BaseRepository->viewProduct($productId);

    }

    //metodo para excluir um produto
    public function delete($productId) {

        return $this->BaseRepository->delete($productId);

    }

    public function findNameProduct($brand) {

        return $this->BaseRepository->findNameProduct($brand);

    }

    public function expiredProducts($date) {

        return $this->BaseRepository->expiredProducts($date);

    }

    public function expiredProductsPeriod(Request $request){
        
        return $this->BaseRepository->expiredProductsPeriod($request);

    }

    public function getProductsPrice(){
        
        return $this->BaseRepository->getProductsPrice();

    }

}
