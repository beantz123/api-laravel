<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Produtos;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    //metodo para listar todos os produtos
    public function index() {
        /*forma de especificar as colunas pois o create e update estavam vindo juntos*/
        $produtos = Produtos::select('id', 'name', 'description', 'price', 'stock')->get();
        //convertendo produtos em formato json
        return response()->json($produtos);
    }

    //metodo para cadastrar um novo produto
    public function store(Request $req){

        //valores que não podem ser nulos
        if($req->name && $req->price && $req->stock) {
            
            //verificar se o produto ja existe no banco
            if($this->verifyProdutosCr($req) == false) {

                //verificar se preço é positivo
                if($req->price > 0){
                    //verificar se estoque é positivo e inteiro
                    if(is_int($req->stock) == true && $req->stock > 0){

                        //enviar pro banco
                        Produtos::create([

                        "name" => $req->name,
                        "description" => $req->description,
                        "price" => $req->price,
                        "stock" => $req->stock

                        ]);

                        //retornar novo dado criado
                        $novoProduto = Produtos::select('name', 'description', 'price', 'stock')->where('name', $req->name)->get();
                        return response()->json($novoProduto);

                    } else {
                        return response(["Estoque só aceita numeros positivos e inteiros!"], 400);   
                    }

                } else {
                    return response(["Preço só aceita numeros positivos!"], 400);   
                }

            } else {
                return response(["Esse produto já existe"], 400);   
            }
            
        } else {

            return response(["Insira os dados de nome, preço e estoque!"], 400);

        }
        
    }

    //metodo pra verificar se existe um outro produto com o mesmo nome 
    public function verifyProdutosUp(Request $r){

        $name = $r->name;
        $id = $r->id;
        //consultando no banco
        $produto = DB::select('SELECT * FROM produtos WHERE name = ? && id != ?', [$name, $id]);

        if (count($produto) > 0) {
            return true; 
        } else {
            return false; 
        }

    }

    public function verifyProdutosCr(Request $r){

        $name = $r->name;
        $id = $r->id;
        //consultando no banco
        $produto = DB::select('SELECT * FROM produtos WHERE name = ?', [$name]);

        if (count($produto) > 0) {
            return true; // O produto já existe
        } else {
            return false; // O produto não existe
        }

    }

    //metodo para atualizar (respeitando as regras para adicionar um dado)
    public function update(Request $req, $productId) {
        // Verificar se o produto existe no banco
        $produto = Produtos::find($productId); // Retorna a instância do modelo ou null
    
        if($produto) {
            //verificar se o nome que quer enviar ja existe
            if($this->verifyProdutosUp($req) == false) {

                if($req->price > 0) {

                    if(is_int($req->stock) == true && $req->stock > 0){

                        // Atualizar o produto
                        $produto->name = $req->name;
                        $produto->description = $req->description;
                        $produto->price = $req->price;
                        $produto->stock = $req->stock;

                        $produto->save(); // Salva as alterações no banco de dados

                        //exibir dados atualizados
                        $produtosAtualizados = Produtos::select('name', 'description', 'price', 'stock')->where('id', $productId)->get();
                        return response()->json($produtosAtualizados);

                    } else {

                        return response(["Estoque só aceita numeros inteiros e positivos!"], 400);
                    }
                    

                } else {

                    return response(["O preço dos produtos precisa ser positivo!"], 400);
                }
                

            } else {

                return response(["Já existe um dado com esse nome!"], 400);
            }
            
        } else {
            return response(["Produto não encontrado"], 404); // Produto não encontrado
        }
    }
    

    //metodo para exibir apenas um produto
    public function viewProduct($productId) {

        //verificar se existe um produto com o id fornecido
        $produto = Produtos::find($productId);
        if($produto){

            $produto = Produtos::select('id', 'name', 'description', 'price', 'stock')->where('id', $productId)->get();
            //convertendo produtos em formato json
            return response()->json($produto);

        } else {
            return response(["produto não encontrado!"], 404);
        } 

    }

    //metodo para excluir um produto
    public function delete($productId) {

        //verificar se existe um produto com o id fornecido
        $produto = Produtos::find($productId);
        if($produto){

            $produto->delete();

            return response(["Produto deletado com sucesso!"], 200);

        } else {
            return response(["produto não encontrado!"], 404);
        } 

    }
}
