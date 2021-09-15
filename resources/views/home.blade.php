@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <div class="tables">
                    <h3>Empresas</h3>
                    <div class="container">
                        <table class="table table-bordered">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Sitio Web</th>
                                <th>Logo</th>
                            </tr>
                            @if ($empresas->isEmpty())
                                <p>No hay empresas registradas</p>
                            @else
                                @foreach($empresas as $empresa)
                                <tr>
                                    <td>{{ $empresa['id'] }}</td>
                                    <td>{{ $empresa['nombre'] }}</td>
                                    <td>{{ $empresa['sitioweb'] }}</td>
                                    <td><img src='{{ asset($empresa['logotipo']) }}'></td>
                                </tr>
                                @endforeach
                            @endif
                            
                        </table>
                    </div>
                    
                    {{ $empresas->links() }}

                    <h3>Empleados</h3>
                    <div class="container">
                        <table class="table table-bordered">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Telefono</th>
                                <th>Email</th>
                            </tr>
                            @if ($empleados->isEmpty())
                                <p>No hay empleados registrados</p>

                            @else
                                @foreach($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado['id'] }}</td>
                                    <td>{{ $empleado['nombre'] }}</td>
                                    <td>{{ $empleado['apellido'] }}</td>
                                    <td>{{ $empleado['telefono'] }}</td>
                                    <td>{{ $empleado['email'] }}</td>
                                </tr>
                                @endforeach
                            @endif
                            
                        </table>
                    </div>
                    
                    {{ $empleados->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
