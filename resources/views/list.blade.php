@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div>
                    <form method="GET">
                        <input name="value" value='{{ \Input::get('value') }}'>
                        <button style="background-color:greenyellow" type="submit">Filter</button>
                    </form>
                    <a href="{{ route('values.list') }}">Delete filter</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($values as $value)
                            <tr>
                                <td>
                                    <form method="POST" action="{{ route('values.update', ['value_id' => $value['id']]) }}">
                                        {{ csrf_field() }}
                                        <input name="value" value='{{ $value['name'] }}'/>
                                        <button type="submit">Edit</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('values.delete', ['id' => $value['id']]) }}">
                                        {{ csrf_field() }}
                                        <button type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <form method="POST" action="{{ route('values.create') }}">
                                    {{ csrf_field() }}
                                    <input name="value" placeholder="New value">
                                    <button type="submit">Submit</button>
                                </form>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div>
@endsection
