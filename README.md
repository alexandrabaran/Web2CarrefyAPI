# TPE_Web2API
Grupo 12 - Duarte Victoria, Baran Valeska Alexandra

Autenticacion necesaria para todo el uso de la API
Endpoint GET -/api/admins/token
Permite que el usuario se loguee a través de Basic Auth. El Username es "webadmin", 
 y Password es "admin". Al ingresar se obtiene el token.

# ENDPOINTS:

### - GET api/products
Accede a todo el listado de productos

### - GET api/products/1
Accede producto con el id especificado y su correspondiente detalle.

### - GET /products?category=1
Accede al listado de los productos filtrando por la categoria con el id especificado.

### - GET api/products?stock=true
Accede al listado de productos filtrando por si hay o no stock.
* "stock" puede tomar como valor 'true' para listar los productos disponibles o 'false' para listar los productos agotados.

### - GET api/products/1?&subrecurso=name
Accede al subrecurso del producto con el id especificado.
* "subrecurso" puede tomar como valor 'name', 'price', 'stock' o 'category_id' segun se desee acceder.

### - GET api/products?orderBy=price&order=ASC
Accede al listado de los productos mostrando en orden ascendente segun el precio.
* "orderBy" tambien puede tomar como valor 'id','name','stock' o 'category_id' eligiendo asi por cual campo de los productos ordenar.
* "order" puede tomar como valor 'ASC' para ordenar los productos de forma ascendente o 'DESC' para ordenar los productos de forma descendente. Si no pasamos "order" ordena por defecto de forma ascendente.

### - GET api/products?page=1
Accede al listado de los productos paginando de a 5 productos.
No se puede acceder a paginas sin productos, esta controlado el error por desborde.
 
### - POST api/products
Crea un producto nuevo.
                {
                   "name": "Manteca 100gr",
                   "stock": "2",
                   "price": "2500",
                   "category": 2
               }

### - PUT api/products/1

Edita el producto con el id especificado, sustituyendo la información enviada.
La forma de modificar es colocar en el body lo siguiente: $name, $stock, $price, $category,
               {
                   "name": "Manteca 100gr",
                   "stock": "2",
                   "price": "2500",
                   "category": 2
               }

### - DELETE api/products/1
Elimina el producto con el id especificado.
