<?php  
//echo ($sql);
// die();

require_once './app/models/APImodel.php';

class productAPIModel extends APIModel {                                            

public function getProducts($category, $filtroHayStock, $orderBy, $order, $page){ //

//FILTRO POR NRO CATEGORIA
   $maxCategory = 6; //hacer que los cuente y no hardcodearlo
    $countCategories = 'SELECT COUNT(category_id) FROM categories;'
    $query = $this->db->prepare($countCategories);
    $query->execute();
    $maxCategory = (int) $query->fetchColumn();

    $sql = 'SELECT * FROM products ';
    if ($category !== null && $category>0 && $category <= $maxCategory){
        $sql .= 'WHERE category_id = ' . $category;
    }

//FILTRO POR SI HAY O NO STOCK
    if ($filtroHayStock!==null) {
        if ($filtroHayStock == 'true') {
        $sql .= 'WHERE product_stock > 0'; //selecciona los productos que tienen stock
        } else $sql .= 'WHERE product_stock = 0'; //selecciona los productos agotados
    }
   
//ORDENA ASCENDENTE O DESCENDENTE
    if ($order == 'ASC'){
    } else $order == 'DESC';

//SELECCIONA POR CUAL CAMPO ORDENAR
    if ($orderBy){
        switch($orderBy) {
            case 'id':
                $sql .= 'ORDER BY product_id '. $order;
                break;
            case 'name':
                $sql .= 'ORDER BY product_name '. $order;
                break;
            case 'price':
                $sql .= ' ORDER BY product_price ' . $order;
                break;
            case 'stock':
                $sql .= 'ORDER BY product_stock '. $order;
                break;
            case 'category_id':
                $sql .= 'ORDER BY category_id '. $order;
                break;
        }
      }

//Si hay pagina indicada
if ($page !==null){
    //CUENTA PRODUCTOS
    $countProducts = 'SELECT COUNT(product_id) FROM products;'
    $query = $this->db->prepare ($countProducts);
    $query->execute();
    $TotalProducts = (int) $query->fetchColumn();

    //CALCULA CANTIDAD DE PAGINAS
    $cantProductosPorPag = 5;
    $maxPage = $TotalProducts / $cantProductosPorPag;
    
    //PAGINA DE A 5
      if ($page>0 && $page<= $maxPage){
            $cant = 5;
            $offset= $cant * ($page -1);
            $sql .= ' LIMIT '.$cant .' OFFSET '.$offset;
      }}

    $query = $this->db->prepare($sql);
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_OBJ); 
        return $products;
}


public function getProduct($id, $subrecurso){
    
    $sql = 'SELECT ';

    if (isset($subrecurso)){
        switch($subrecurso) {
            case 'name':
                $sql .= 'product_name FROM products WHERE product_id =?';
                break;
            case 'price':
                $sql .= 'product_price FROM products WHERE product_id =?';
                break;
            case 'stock':
                $sql .= 'product_stock FROM products WHERE product_id =?';
                break;
            case 'category_id':
                $sql .= 'category_id FROM products WHERE product_id =?';
                break;
             } 
        } else $sql = 'products.* FROM products WHERE product_id = ?';
        
    
    $query = $this->db->prepare($sql);
    $query->execute([$id]);
    $product = $query->fetchAll(PDO::FETCH_OBJ);
    return $product;
}

public function addProduct($name, $category, $price, $stock){
    $query = $this->db->prepare('INSERT INTO products (product_name, category_id, product_price, product_stock) VALUES (?,?,?,?)');
    $query->execute([$name, $category, $price, $stock]);
    return $this->db->lastInsertId();
}

public function deleteProduct($id){
    $query = $this->db->prepare('DELETE FROM products WHERE product_id = ?');
    $query->execute([$id]);
}

public function updateProduct($name, $stock, $price, $category, $id){
    $query = $this->db->prepare('UPDATE products SET product_name = ? , product_stock = ? , product_price = ? , category_id = ? 
                                                                WHERE product_id = ?');
    $query->execute([$name, $stock, $price, $category, $id]);
    
    }
}
