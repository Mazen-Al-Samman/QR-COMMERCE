
@foreach($data as $d)
    <tr>
        <td><img src="{{ asset('storage/uploads/products/'.$d['main_image'])}}" class="rounded" width="75" height="75" alt=""></td>
        <td>{{$d['name']}}</td>
        <td>{{$d['category']}}</td>
        <td>{{$d['price']}} JOD</td>
        <td>{{$d['quantity']}}</td>
    </tr>
@endforeach
