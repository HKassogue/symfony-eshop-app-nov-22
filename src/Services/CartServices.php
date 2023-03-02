<?php
namespace App\Services;

class PanierServices{
    private $session;
    private $repoProduct;
    private $tva=0.2;

    public function __construct(){
        $this->$session= $session;
        $this->$repoProduct= $repoProduct;
    }

    //fonction ajout au panier
    public function addToCart($id){
        $cart = $this->getCArt();
        if(isset($cart[$id])){
            //produit deja dans le panier
            $cart[$id]++;
        }
        else{
            //produit n'est pas dans le panier
            $cart[$id]=1;
        }
        $this->updateCart($cart);
    }


    //fonction update panier
    public function updateCart($cart){
        $this->$session->set('cart', $cart);
        $this->$session->set('cartData', $this.getFullCart());
        
    } 

    //fonction lire panier
    public function getCart(){
       return $this->$session->get('cart', []);   
    } 

    //fonction creation objet qui contient la quantite,taxe etc  en plus de la session panier
    public function getFullCart(){
        $cart= $this->getCart();
        $fullCart= [];
        $quantityCart= 0;
        $subTotal=0; 

         foreach($cart as $id=>$quantity){
            $product= $this->repoProduct->find($id);
            if($product){
                $fullCart['products'][]=[
                    'quantity'=>$quantity,
                    'product'=> $product
                ];
                $quantityCart += $quantity;
                $subTotal+=$quantity*$product->getPriceProduct()/100;
            }
            else{
                $this->deleteFormCart($id);
            }
        }  
        $fullCart['data']=[
            "quantityCart"=>$quantityCart,
            "subTotatHT"=>$subTotal,
            "taxe"->round($subTotal*$this->tva,2),
            "subTotatTTC"->round(($subTotal+($subTotal*$this->tva)),2)
        ];
        return $fullCart;
     } 

    //function supprimer une unite d'un article du panier en comptant les ids>1
    public function deleteFormCart($id){
        $cart= $this->getCart();
        //Produit est dans le paner
        if(isset($cart[$id])>1){
            $cart[$id]--;
        }
        else{
            unset($cart[$id]);
            
        }
        $this->updateCart($cart);
    }

    //fonction supprimer tout un article du anier
    public function deleteAllCart($id){
        $cart= $this->getCart();
        //Produit est dans le paner
        if(isset($cart[$id])){
            //tout supprimer
            unset($cart[$id]);
            $this->updateCart($cart);
        }
    }
    //foction supprimer tout le panier
    public function deleteCart($id){
        $this->updateCart([]);
        
    } 



}