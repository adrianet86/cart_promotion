# Shopping cart API  
  
### Requirements  
* Docker  
* Docker compose  
  
### Setup  
    docker pull composer
  	
    cd php/src   
      
    docker run --rm -ti -v $PWD:/app -w /app composer install --ignore-platform-reqs  
    
    sudo chmod -R 777 var  
    
    # Back to root path of project  
    
    cd ../../  
    
    docker-compose up -d --build   
      
    curl -S http://127.0.0.1:8080/system/ready  

### API ENDPOINTS  

>POST /cart

	{
		"id" : "cdd7954e-502e-403e-af6f-888e1bdd6450",
	}

>DELETE /cart/{id}

>POST /cart/{id}/product/{code}

>GET /cart/{id}/amount

### Tests
  
	# From path php/src     
	docker run --rm -ti -v $PWD:/app -w /app cart_php php vendor/bin/phpunit -c phpunit.xml.dist

### TODO:
* Fix id validation in order to avoid duplicated.
* Request validations.
* Settings for environments.
* Think about REST endpoints methods used.
* Replace file repositories

### Example workflow
>Items: PEN, TSHIRT, MUG
> 
>Total: 32.50€

    # Create a cart
    curl --location --request POST 'http://127.0.0.1:8080/cart' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json' \
    --data-raw '{
        "id": "865336b4-63ac-47fd-af56-1af9175caa5e"
    }'

    # Add PEN
    curl --location --request POST 'http://127.0.0.1:8080/cart/865336b4-63ac-47fd-af56-1af9175caa5e/product-seller/PEN' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/865336b4-63ac-47fd-af56-1af9175caa5e/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add MUG
    curl --location --request POST 'http://127.0.0.1:8080/cart/865336b4-63ac-47fd-af56-1af9175caa5e/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Get total amount
    curl --location --request GET 'http://127.0.0.1:8080/cart/865336b4-63ac-47fd-af56-1af9175caa5e/amount' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'


>Items: PEN, TSHIRT, PEN
>
>Total: 25.00€

    # Create a cart
    curl --location --request POST 'http://127.0.0.1:8080/cart' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json' \
    --data-raw '{
        "id": "81a34f78-6584-4e1a-8d7e-a89ca5377a0b"
    }'

    # Add PEN
    curl --location --request POST 'http://127.0.0.1:8080/cart/81a34f78-6584-4e1a-8d7e-a89ca5377a0b/product-seller/PEN' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/81a34f78-6584-4e1a-8d7e-a89ca5377a0b/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add PEN
    curl --location --request POST 'http://127.0.0.1:8080/cart/81a34f78-6584-4e1a-8d7e-a89ca5377a0b/product-seller/PEN' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
        
    # Get total amount
    curl --location --request GET 'http://127.0.0.1:8080/cart/81a34f78-6584-4e1a-8d7e-a89ca5377a0b/amount' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'

>Items: TSHIRT, TSHIRT, TSHIRT, PEN, TSHIRT
>
>Total: 65.00€

    # Create a cart
    curl --location --request POST 'http://127.0.0.1:8080/cart' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json' \
    --data-raw '{
        "id": "e3f71cbb-8fc6-48eb-ae9b-bc0c1f55bb77"
    }'

    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/e3f71cbb-8fc6-48eb-ae9b-bc0c1f55bb77/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/e3f71cbb-8fc6-48eb-ae9b-bc0c1f55bb77/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/e3f71cbb-8fc6-48eb-ae9b-bc0c1f55bb77/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add PEN
    curl --location --request POST 'http://127.0.0.1:8080/cart/e3f71cbb-8fc6-48eb-ae9b-bc0c1f55bb77/product-seller/PEN' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/e3f71cbb-8fc6-48eb-ae9b-bc0c1f55bb77/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
            
    # Get total amount
    curl --location --request GET 'http://127.0.0.1:8080/cart/e3f71cbb-8fc6-48eb-ae9b-bc0c1f55bb77/amount' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'

>Items: PEN, TSHIRT, PEN, PEN, MUG, TSHIRT, TSHIRT
>
>Total: 62.50€

    # Create a cart
    curl --location --request POST 'http://127.0.0.1:8080/cart' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json' \
    --data-raw '{
        "id": "da9e9386-1abd-41a0-8be1-8383bd0ee34d"
    }'

    # Add PEN
    curl --location --request POST 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/product-seller/PEN' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'

    # Add PEN
    curl --location --request POST 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/product-seller/PEN' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add PEN
    curl --location --request POST 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/product-seller/PEN' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
      
    # Add MUG
    curl --location --request POST 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/product-seller/MUG' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
    
    # Add TSHIRT
    curl --location --request POST 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/product-seller/TSHIRT' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
            
    # Get total amount
    curl --location --request GET 'http://127.0.0.1:8080/cart/da9e9386-1abd-41a0-8be1-8383bd0ee34d/amount' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json'
