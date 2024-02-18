@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                    </div>

                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="angka">Masukkan angka yang anda inginkan</label>
                                <input type="number" class="form-control" value="{{ old('angka') }}"
                                    placeholder="Masukkan angka" name="angka">
                            </div>
                        </form>
                        <div class="form-group mt-4">
                            <label for="angka">Hasil</label>
                        </div>
                        @for ($i = 1; $i <= $angka; $i++)
                            @for ($j = 1; $j <= $angka - $i; $j++)
                                &nbsp;&nbsp;
                            @endfor
                            @for ($k = 1; $k <= $i; $k++)
                                {{ $k }}
                            @endfor
                            <br>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
