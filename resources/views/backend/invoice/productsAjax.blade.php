
@foreach($data as $d)
    <tr>
        <td><img src="{{ asset('assets/images/uploads/products/'.$d['main_image'])}}" class="rounded" width="75" height="75" alt=""></td>
        <td>{{$d['name']}}</td>
        <td>{{$d['category']}}</td>
        <td>{{$d['price']}} JOD</td>
        <td>
            <input type="number" class="form-control cart_quantity cart_quantity_{{$d['id']}}" min="1" max="10" data-id="{{$d['id']}}" value="{{$d['quantity']}}"></td>
        <td>
            <button class="btn btn-success update-cart-btn" data-id="{{$d['id']}}">Save change</button>
            <button class="btn btn-danger delete-cart-btn" data-id="{{$d['id']}}">Delete</button>
        </td>
    </tr>
@endforeach
