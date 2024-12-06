@include('../header')
<html>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <body>
        <script>
            toastr.option = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "positionClass": "toast-top-right",
                "showEasing": "swing",
                "hideEasing": "liner",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        </script>
        <div class="container">

            <form id="product_add">
                <label>Product Name</label>
                <input type="text" name="product_name"></input>
                <label>Quantity In Stock</label>
                <input type="number" name="quantity_in_stock"></input>
                <label>Price Per Item</label>
                <input type="number" name="price_per_item"></input>
                
                <input type="submit" value="submit">
            </form>
        </div>
    </body>
</html>
<script>
    $(document).ready(function(){
        $("#product_add").submit(function(e){
            e.preventDefault();
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('products.store') }}",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: $(this).serialize(),
                success: function(response){
                    if(response.status === 'success'){
                        toastr.success(response.message);
                        window.location.href = "{{ route('products.index')}}";
                    }
                },
                error: function(xhr,error, status){
                    console.error(error);
                    var errors = xhr.responseJSON.errors;
                    if(errors){
                        console.log(errors);
                    }
                },
            });
        });   
    });
</script>