@include('../header')
<div class="container">
    <a class="pills" href="{{ route('products.create') }}">Add Product</a>

<table id="product_index_table" class="common-table zebra-striped">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity In Stock</th>
            <th>Price Per Item</th>
            <th>Edit</th>
        </tr>
    </thead>
</table>
</div>
<script>
    $(document).ready(function() {
        $("#product_index_table").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.get_data')}}",
            columns: [
                {data: 'product_name', name: 'product_name'},
                {data: 'quantity_in_stock', name: 'quantity_in_stock'},
                {data: 'price_per_item', name: 'price_per_item'},
                {data: 'null', 
                    render: function(data,type, row){
                        return '<button class="edit-btn" data-id="'+row.id+'" data-product_name="'+row.product_name+'"data-quantity="'+row.quantity_in_stock+'"data-price="'+ row.price_per_item +'">Edit</button>'; 
                    },
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#product_index_table').on('click', '.edit-btn', function(){
            var productId = $(this).data('id');
            var productName = $(this).data('product_name');
            var quantity_in_stock = $(this).data('quantity');
            var price_per_item = $(this).data('price');

            $('#editProductId').val(productId);
            $('#editProductName').val(productName);
            $('#editQuantitiyInStock').val(quantity_in_stock);
            $('#editPricePerItem').val(price_per_item);

            $('#editProductModel').show();

        });

        $('#editProductForm').submit(function(e){
            e.preventDefault();

            var form = $(this).serialize();

            $.ajax({
                url: "{{ route('products.update') }}",
                type: "POST",
                data: form,
                success: function(response){
                    toastr.success('product updated successfully');
                    $('#editProductModel').hide();
                    table.ajax.reload();
                },
                error: function(xhr, status, error){
                    toastr.error('Error updating product!');
                }
            });
        });
    });
    
</script>