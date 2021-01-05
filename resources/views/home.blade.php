<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>isin databse</title>
  </head>
  <body>

    {{-- header --}}
    <header>
      <h1>isin database</h1>
    </header>
    {{-- /header --}}

    {{-- main --}}
    <main>

      @if (count($stocks))
        <ul>
          @foreach ($stocks as $stock)

            <li>
              {{-- name --}}
              <span>
                {{ $stock->name }}
              </span>
              {{-- /name --}}

              {{-- isin --}}
              <span>
                {{ $stock->isin }}
              </span>
              {{-- /isin --}}

              {{-- date_of_start --}}
              <span>
                {{ \Carbon\Carbon::parse($stock->date_of_start)->format('d M Y') }}
              </span>
              {{-- /date_of_start --}}
              -
              {{-- date_of_end --}}
              <span>
                {{ \Carbon\Carbon::parse($stock->date_of_end)->format('d M Y') }}
              </span>
              {{-- /date_of_end --}}

              {{-- delete button/form --}}
              <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display: inline-block">

                @csrf
                @method('DELETE')

                <button class="btn button delete" type="submit">Delete</button>

              </form>
              {{-- /delete button/form --}}

            </li>

          @endforeach
        </ul>

      @else
        <h2>Add new stock with the form below</h2>
      @endif

      <form action="{{ route('stocks.store') }}" method="POST">

        @csrf
        @method('POST')

        {{-- name --}}
        <div>
          <label for="name">Name*</label>
          <input id="name" name="name" type="text" placeholder="Name" min="3" max="50" required value="{{old("name")}}">
        </div>
        {{-- /name --}}

        {{-- isin --}}
        <div>
          <label for="isin">isin*</label>
          <input id="isin" name="isin" type="text" placeholder="isin" min="3" max="50" required value="{{old("isin")}}">
        </div>
        {{-- /name --}}

        {{-- date of start --}}
        <div>
          <label for="date_of_start">date of start*</label>
          <input name="date_of_start" type="date" class="form-control" id="date_of_start" required value="{{old("date_of_start")}}">
        </div>
        {{-- /date of start --}}

        {{-- date of end --}}
        <div>
          <label for="date_of_end">date of end*</label>
          <input name="date_of_end" type="date" class="form-control" id="date_of_end" required value="{{old("date_of_end")}}">
        </div>
        {{-- /date of end --}}

        {{-- submit --}}
        <button type="submit">Add Stock</button>
        {{-- /submit --}}

      </form>

      {{-- show errors --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      {{-- show errors --}}

      <button>Export CSV</button>

    </main>
    {{-- /main --}}

  </body>
</html>