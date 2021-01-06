@php
  // using Carbon
  use Carbon\Carbon;
@endphp

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>isin databse</title>
    <link rel="stylesheet" href="css/app.css">
  </head>
  <body>

    {{-- header --}}
    <header>
      <h1 class="text-center">isin database</h1>
    </header>
    {{-- /header --}}

    {{-- main --}}
    <main>

      <div class="heading pt-4">
        <div class="stock__div">Name</div>
        <div class="stock__div">Isin</div>
        <div class="stock__div">Date of start</div>
        <div class="stock__div">Date of end</div>
      </div>

      @if (count($stocks))
        <ul class="stock_list pt-2">
          @foreach ($stocks as $stock)

            <li class="stock my-1">
              {{-- name --}}
              <div class="stock__name stock__div">
                {{ $stock->name }}
              </div>
              {{-- /name --}}

              {{-- isin --}}
              <div class="stock__isin stock__div">
                {{ $stock->isin }}
              </div>
              {{-- /isin --}}

              {{-- date_of_start --}}
              <div class="stock__start stock__div">
                {{ Carbon::parse($stock->date_of_start)->format('d M Y') }}
              </div>
              {{-- /date_of_start --}}

              {{-- date_of_end --}}
              <div class="stock__end stock__div">
                {{ Carbon::parse($stock->date_of_end)->format('d M Y') }}
                @if ($today->lt($stock->date_of_end))
                  (-{{ ($today->diffInDays($stock->date_of_end)) }} days)
                @endif
              </div>
              {{-- /date_of_end --}}

              <button class="btn button edit"><i class="far fa-edit"></i> Edit</button>

              {{-- delete button/form --}}
              <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display: inline-block">

                @csrf
                @method('DELETE')

                <button class="btn button delete" type="submit"><i class="far fa-trash-alt"></i> Delete</button>

              </form>
              {{-- /delete button/form --}}

            </li>

          @endforeach
        </ul>

        <button class="btn button mt-2 mb-4"><i class="fas fa-file-csv"></i> Export CSV</button>
        <button class="btn button mt-2 mb-4"><i class="fas fa-random"></i> Generate random stock</button>

      @else
        <h2>Add new stock with the form below</h2>
      @endif

      {{-- show errors --}}
      @if ($errors->any())
        {{-- @dd($errors) --}}
        <div class="alert alert-danger">
          <ul class="errors">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      {{-- show errors --}}

      <form action="{{ route('stocks.store') }}" method="POST">

        @csrf
        @method('POST')

          <div class="row">

            {{-- name --}}
            <div class="col-3 form-group {{ $errors->has('name') ? 'has-error' :'' }}">
              <label for="name">Name*</label>
              <input id="name" name="name" type="text" class="form-control" placeholder="Name" min="3" max="50" required value="{{old("name")}}">
            </div>
            {{-- /name --}}

            {{-- isin --}}
            <div class="col-3 form-group {{ $errors->has('isin') ? 'has-error' :'' }}">
              <label for="isin">isin*</label>
              <input id="isin" name="isin" type="text" class="form-control" placeholder="isin" min="3" max="50" required value="{{old("isin")}}">
            </div>
            {{-- /name --}}

            {{-- date of start --}}
            <div class="col-2 form-group {{ $errors->has('date_of_start') ? 'has-error' :'' }}">
              <label for="date_of_start">date of start*</label>
              <input name="date_of_start" type="date" class="form-control" id="date_of_start" required value="{{old("date_of_start")}}">
            </div>
            {{-- /date of start --}}

            {{-- date of end --}}
            <div class="col-2 form-group {{ $errors->has('date_of_end') ? 'has-error' :'' }}">
              <label for="date_of_end">date of end*</label>
              <input name="date_of_end" type="date" class="form-control" id="date_of_end" required value="{{old("date_of_end")}}">
            </div>
            {{-- /date of end --}}

            {{-- submit --}}
            <div class="col-2 form-group button_form">
              <button type="submit" class="btn button"><i class="fas fa-chart-line"></i> Add Stock</button>
            </div>
            {{-- /submit --}}
          </div>

      </form>

    </main>
    {{-- /main --}}

  </body>
</html>