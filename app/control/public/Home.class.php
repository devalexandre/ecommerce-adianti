<?php
class Home extends TPage
{
    private $html;
    private $pageNavigation;
    private $cart;

    public function __construct()
    {
        parent::__construct();
        
        // 		inicia o carrinho de compras

        $this->cart = new PCart();
        
        // 		create the HTML Renderer

        $this->html = new THtmlRenderer('app/view/produtos.html');
        
        // 		define replacements for the main section

        $replace = array();
        
        // 		replace the main section variables

        $this->html->enableSection('main', $replace);
        
        
        
        // 		creates the page navigation

        $this->pageNavigation = new PPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
    }


    public function destaque($param)
    {
        try {
            $limit = 6;
            
            // 			load the products

            TTransaction::open('sample');
            $criteria = new TCriteria;
            $criteria->setProperties($param);
            // 			order, offset

            $criteria->setProperty('limit', $limit);

            $filter = new TFilter('featured', '=', true);
            $criteria->add($filter);

            $products = products::getObjects($criteria);

            $criteria->resetProperties();
            // 			reset the criteria for record count

            $count = products::countObjects($criteria);

            TTransaction::close();

            $replace_detail = array();
            if ($products) {
                // 				iterate products

                foreach ($products as $product) {
                    $item = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'imagem' => $product->imagem,
                        'description' => $product->description,
                        'price' => $product->price,
                    ];
                    $replace_detail[] = $item;
                    // 					array of replacements

                }
            }
            
            
            
            // 			enable products section as repeatable

            $this->html->enableSection('products', $replace_detail, true);

            $this->pageNavigation->setCount($count);
            // 			count of records

            $this->pageNavigation->setProperties($param);
            // 			order, page

            $this->pageNavigation->setLimit($limit);
            // 			limit
            
            // 			wrap the page content using vertical box

            $vbox = new TVBox;
            $vbox->add($this->html);
            $vbox->add($this->pageNavigation);

            parent::add($vbox);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function onReload($param)
    {
        try {
            $limit = 6;
            
            // 			load the products

            TTransaction::open('sample');
            $criteria = new TCriteria;
            $criteria->setProperties($param);
            // 			order, offset

            $criteria->setProperty('limit', $limit);

            $products = products::getObjects($criteria);

            $criteria->resetProperties();
            // 			reset the criteria for record count

            $count = products::countObjects($criteria);

            TTransaction::close();

            $replace_detail = array();
            if ($products) {
                // 				iterate products

                foreach ($products as $product) {
                    $item = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'imagem' => $product->imagem,
                        'description' => $product->description,
                        'price' => $product->price,
                    ];
                    $replace_detail[] = $item;
                    // 					array of replacements

                }
            }
            
            
            
            // 			enable products section as repeatable

            $this->html->enableSection('products', $replace_detail, true);

            $this->pageNavigation->setCount($count);
            // 			count of records

            $this->pageNavigation->setProperties($param);
            // 			order, page

            $this->pageNavigation->setLimit($limit);
            // 			limit
            
            // 			wrap the page content using vertical box

            $vbox = new TVBox;
            $vbox->add($this->html);
            $vbox->add($this->pageNavigation);

            parent::add($vbox);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function additem($param)
    {
        try {
            TTransaction::open('sample');

            $item = new products($param['key']);

            if ($this->cart->getIten($param['key'])) {
                $produto = $this->cart->getIten($param['key']);
                $produto->setQtd($produto->getQtd() + 1);
            }
            else {
                $produto = new PProduto();
                $produto->setId($item->id);
                $produto->setNome($item->name);
                $produto->setQtd(1);
                $produto->setPreco($item->price);
                $produto->setDescricao($item->description);
            }
            $this->cart->addItem($produto);



            AdiantiCoreApplication::gotoPage('Home', 'onReload');
        } catch (Exception $e) {
            TDebug::debug($e->getMessage());
        }
    }

    public function meuCarrinho()
    {
        try {
            $this->html = new THtmlRenderer('app/view/carrinho.html');

            $this->html->enableSection('main');

            TTransaction::open('sample');


            $products = PCart::getItens();

            $products_array = [];

            foreach ($products as $p) {
                $products_array[] = [
                    'id' => $p->getId(),
                    'name' => $p->getNome(),
                    'qty' => $p->getQtd(),
                    'price' => number_format($p->getPreco(), 2, ',', '.')
                ];
            }

            $this->html->enableSection('products', $products_array, true);

            $total = number_format($this->cart->getTotal(), 2, ',', '.');

            $url = $this->finalizar();

            $this->html->enableSection('total', ['total_itens' => $total,'url'=>$url]);


            TTransaction::close();

            parent::add($this->html);
        } catch (\Exception $e) {
            
           echo $e->getMessage();
        }
    }

    public function removeItem($param)
    {
        try {
            $this->html = new THtmlRenderer('app/view/carrinho.html');

            $this->html->enableSection('main');

            $this->cart->removeItem($param['key']);


            AdiantiCoreApplication::gotoPage('Home', 'meuCarrinho');
        } catch (Exception $e) {
            TDebug::debug($e->getMessage());
        }
    }

    public function login()
    {
        try {
            $this->html = new THtmlRenderer('app/view/login.html');

            $this->html->enableSection('main');

            parent::add($this->html);
        } catch (Exception $e) {
            TDebug::debug($e->getMessage());
        }
    }




    public function cadastrar()
    {
        try {
            $this->html = new THtmlRenderer('app/view/cadastro.html');

            $this->html->enableSection('main');

            parent::add($this->html);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function retorno($param)
    {

        try {
            TTransaction::open('sample');

            $id = TSession::getValue('myrequest');



            $pg = new PPagSeguro('pagseguro', true);
            $pg->setSandbox(true);



            $obj = $pg->getDados($param['token']);


            $id = $obj['transaction']->getReference();
            $pedido = new requests($id);
            $pedido->transaction_id = $obj['transaction']->getCode();
            $pedido->status = $obj['status'];
            $pedido->store();

            $this->cart->clean();
            AdiantiCoreApplication::gotoPage('Home', 'destaque');


            TTransaction::close();
        } catch (Exception $e) {
            $e->getMessage();
            exit;
        }
    }


    public function finalizar()
    {

        try {
            TTransaction::open('sample');

            if (!TSession::getValue('userid')) {
                echo "Você não esta logado";
                exit;
            }

            $pedidos = new requests();
            $pedidos->total = PCart::getTotal();
            $pedidos->status = 'Aguardando pagamento';
            $pedidos->custumers_id = TSession::getValue('userid');
            $pedidos->store();




            $products = PCart::getItens();
            // 			pagseguro

            $pg = new PPagSeguro('pagseguro', true);
            $pg->setSandbox(true);
            $pg->addCodVenda($pedidos->id);

            $products_array = [];

            foreach ($products as $p) {
                $pg->addItem($p);
                $products_requests = new products_requests();
                $products_requests->requests_id = $pedidos->id;
                $products_requests->products_id = $p->getId();
                $products_requests->qty = $p->getQtd();
                $products_requests->store();
            }

            TTransaction::close();

            $url = $pg->getUrl();
            TSession::setValue('myrequest', $pedidos->id);

            return $url;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function logout()
    {
        TSession::freeSession();
        AdiantiCoreApplication::gotoPage('Home', 'login');
    }
}
