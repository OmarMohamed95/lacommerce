@extends('admin.layouts.adminTemplate')
@section('content')
<h1 class="alert alert-info pageH">Edit offer</h1>
<div class="col-xs-offset-1">
    <form action="{{ aurl("offers/$single->id") }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group row">
            <label for="name" class="col-xs-2 col-form-label">Name</label>
            <div class="col-xs-8">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $single->name }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-2 col-form-label" for="Description">Description</label>
            <div class="col-xs-8">
                <textarea rows="5" name="desc" id="article-ckeditor" class="form-control" placeholder="Description">{{ $single->desc }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="Price" class="col-xs-2 col-form-label">Price</label>
            <div class="col-xs-8">
                <input type="number" name="price" class="form-control" placeholder="Price" value="{{ $single->price }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="Quantity" class="col-xs-2 col-form-label">Quantity</label>
            <div class="col-xs-8">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity" value="{{ $single->quantity }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="Image" class="col-xs-2 col-form-label">Image</label>
            <div class="col-xs-8">
                <input type="file" name="img[]" class="form-control" multiple>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-2 col-form-label" for="Category">Category</label>
            <div class="col-xs-8">
                <select name="category_id" class="form-control" id="product_category">
                    @foreach ($allcategories as $item)
                    @if (! in_array($item->id, $parentID))
                        <option value="{{ $item->id }}" {{ ($item->id === $single->category_id)? 'selected' : '' }}>{{ $item->name }}</option>                        
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-2 col-form-label" for="Parent">Brand</label>
            <div class="col-xs-8">
                <select name="brand_id" class="form-control" id="brands"></select>
            </div>
        </div>
        <div class="customfields"></div>
        <div class="form-group row">
            <div class="col-sm-10">
                <input type="submit" value="submit" class="btn btn-info pull-right">
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            // custom field and brands ajax

            custom_field();

            $('#product_category').on('change',function(){
                custom_field();
            });
        });

        function custom_field(){
            $('.customfields').children().remove();
            $('#brands').children().remove();
            var id = $('#product_category').val();
            var product_id = $('#product_id').val();
            var url = `{{ aurl('custom_field/editProduct') }}/${id}/${product_id}`;
            var url_B = "{{ aurl('products/getBrandsByCat') }}" + '/' + id;
            var selected_brand_id = {{ $single->brand_id}};

            if (!id) {
                return false;
            }

            $.ajax({
                url: url,
                dataType: 'json',
                success: function(r){
                    $.each(r, function(k, v){
                        
                        if(v.custom_field_product.length === 0){
                            $('.customfields').prepend(`<div class='form-group row'>
                                <label for='${v.custom_field[0].name}' class='col-xs-2 col-form-label'>${v.custom_field[0].name}</label>
                                <div class='col-xs-8'>
                                    <input type='${v.custom_field[0].type}' name='cf[${v.custom_field[0].id}]' placeholder='${v.custom_field[0].name}' class='form-control'>
                                </div>
                            </div>`);
                        }else{
                            $('.customfields').prepend(`<div class='form-group row'>
                                <label for='${v.custom_field[0].name}' class='col-xs-2 col-form-label'>${v.custom_field[0].name}</label>
                                <div class='col-xs-8'>
                                    <input type='${v.custom_field[0].type}' name='cf[${v.custom_field[0].id}]' value='${v.custom_field_product[0].value}' placeholder='${v.custom_field[0].name}' class='form-control'>
                                </div>
                            </div>`);
                        }
                    });
                },
                error: function(data){

                },
                complete: function(){
                    
                }
            });

            $.ajax({
                url: url_B,
                dataType: 'json',
                success: function(r){
                    $.each(r, function(k, v){
                        if(v.brand_id === selected_brand_id){
                            $('#brands').prepend(`<option value="${v.brand_id }" selected>${v.brand.name}</option>`);
                        }else{
                            $('#brands').prepend(`<option value="${v.brand_id }">${v.brand.name}</option>`);
                        }
                    });
                },
                error: function(data){

                },
                complete: function(){
                    
                }
            });
        }
    </script>
@endsection