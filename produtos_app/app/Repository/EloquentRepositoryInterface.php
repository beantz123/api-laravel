<?php
/* aqui vai ficar a interface dos metodos que vao ser utilizados pelo sistema */ 
namespace App\Repository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /* metodos para interagir com o sistema */
   public function store(Request $request);
   public function index();
   public function update(Request $request, $productId);
   public function viewProduct($productId);
   public function delete($productId);
   
}