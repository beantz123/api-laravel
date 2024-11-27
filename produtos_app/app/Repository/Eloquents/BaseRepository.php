<?php 
/* aqui vai ficar os metodos que vao ser utilizados pelo sistema */ 

namespace App\Repository\Eloquents;

use App\Repository\EloquentRepositoryInterface;
use App\Models\Produtos;
use Illuminate\Http\Request;
use App\Repository\Eloquents\AuxiliaryRepository;

use function PHPUnit\Framework\isEmpty;

class BaseRepository implements EloquentRepositoryInterface {

    public function store(Request $request) {
        //valores que não podem ser nulos
        if($request->name && $request->price && $request->stock) {

            $auxRepo = new AuxiliaryRepository();
            //verificar se o produto ja existe no banco
            if($auxRepo->verifyProdutosCr($request) == false) {

                //verificar se preço é positivo
                if($request->price > 0){
                    //verificar se estoque é positivo e inteiro
                    if(is_int($request->stock) == true && $request->stock > 0){
                        
                        //enviar pro banco
                        Produtos::create([

                        "name" => $request->name,
                        "description" => $request->description,
                        "price" => $request->price,
                        "stock" => $request->stock,
                        "data_de_fabricação" => $request->data_de_fabricação,
                        "data_de_vencimento" => $request->data_de_vencimento

                        ]);

                        //retornar novo dado criado
                        return response(["Produto cadastrado com sucesso!"], 200); 

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

    public function index() {
        
        $produtos = Produtos::all();
        //convertendo produtos em formato json
        
        if($produtos->isEmpty()){
            
            return response(["nao tem produto"], 400);

        } 

        return response()->json($produtos, 200);
        
    }

    public function update(Request $request, $productId) {
        $produto = Produtos::find($productId); // Retorna a instância do modelo ou null
    
        if($produto) {
            
            $auxRepo = new AuxiliaryRepository();
            //verificar se o nome que quer enviar ja existe
            if($auxRepo->verifyProdutosUp($request, $productId) == false) {

                if($request->price > 0) {

                    if(is_int($request->stock) == true && $request->stock > 0){

                        // Atualizar o produto
                        $produto->name = $request->name;
                        $produto->description = $request->description;
                        $produto->price = $request->price;
                        $produto->stock = $request->stock;
                        $produto->data_de_fabricação = $request->data_de_fabricação;
                        $produto->data_de_vencimento = $request->data_de_vencimento;

                        $produto->save(); // Salva as alterações no banco de dados

                        //exibir dados atualizados
                        $produtosAtualizados = Produtos::select()->where('id', $productId)->get();
                        return $produtosAtualizados;

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

    public function viewProduct($productId){
        //verificar se existe um produto com o id fornecido
        $produto = Produtos::find($productId);
        if($produto){

            $produto = Produtos::select()->where('id', $productId)->get();
            //convertendo produtos em formato json
            return $produto;

        } else {
            return response(["produto não encontrado!"], 404);
        }
    }

    public function delete($productId){
        $produto = Produtos::find($productId);
        if($produto){

            $produto->delete();

            return response(["Produto deletado com sucesso!"], 200);

        } else {
            return response(["produto não encontrado!"], 404);
        } 
    }

    //retornar produtos pela nome fornecido
    public function findNameProduct($nameProduct){

        $productsBrand = Produtos::where('name', 'like', "$nameProduct%")->get();
        
        if($productsBrand->isNotEmpty()){

            return $productsBrand;

        } else {

            return response(["produto não encontrada"]);

        }
    }

    //retornar produtos q estarao vencidos a partir de uma data informada
    public function expiredProducts($date){

        $produto = Produtos::where('data_de_vencimento', '<', $date)->get();

        if($produto->isNotEmpty()){
            return $produto;
        } else {
            return response(["não possui produtos vencidos para antes da data fornecida"]);
        }

    }

    //retornar quais produtos durante um determinado periodo estarão vencidos
    public function expiredProductsPeriod(Request $request){
        
        $dateInit = $request->input('date-init');
        $dateFinal = $request->input('date-final');

        if($dateInit != "" && $dateFinal != ""){

            $dates = Produtos::whereBetween('data_de_vencimento', [$dateInit, $dateFinal])->get();

            if(!$dates->isEmpty()){

                return $dates;

            } else {
                return response(["Dados fornécidos inválidos!"]);
            }

        } else {

            return response(["você precisa inserir uma data inicial e uma data final para conseguir retornar os dados corretamente!"]);
        
        }
        
    }

    //retornar apenas o nome e preço dos produtos
    public function getProductsPrice(){

        $produtos = Produtos::pluck('price', 'name');

        return $produtos; 

    }

}