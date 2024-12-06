@include('../header')
<form id="product_add">
    <label>Product Name</label>
    <input type="text" name="product_name" value=""></input>
    <label>Quantity In Stock</label>
    <input type="number" name="quantity_in_stock" value=""></input>
    <label>Price Per Item</label>
    <input type="number" name="price_per_item" value=""></input>
    
    <input type="submit" value="submit">
</form>

<script>
    $(document).ready(function(){
        $("#product_add").submit(function(e){
            $.ajax({
                url: "{{'route('products/update', [$id => $product->id])'}}",
                type: "POST",
                dataType: "json",
                data: $this.serialize(),
                success: function(result){
                    toastr(message);
                },
                error: function(error){
                    console.error(error);
                },
            }
            
        );
        });   
    });
</script>