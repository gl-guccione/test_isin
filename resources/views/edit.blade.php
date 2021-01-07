<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>isin databse</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
<body>

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

  <form action="{{ route('stocks.update', $stock->id) }}" method="POST">

    @csrf
    @method('PUT')

      <div class="row">

        {{-- name --}}
        <div class="col-3 form-group {{ $errors->has('name') ? 'has-error' :'' }}">
          <label for="name">Name*</label>
          <input id="name" name="name" type="text" class="form-control" placeholder="Name" min="3" max="50" required value="{{ old("name") ? old("name") : $stock->name }}">
        </div>
        {{-- /name --}}

        {{-- isin --}}
        <div class="col-2 form-group {{ $errors->has('isin') ? 'has-error' :'' }}">
          <label for="isin">isin*</label>
          <input id="isin" name="isin" type="text" class="form-control" placeholder="isin" min="3" max="50" required value="{{ old("isin") ? old("isin") : $stock->isin }}">
        </div>
        {{-- /name --}}

        {{-- date of start --}}
        <div class="col-2 form-group {{ $errors->has('date_of_start') ? 'has-error' :'' }}">
          <label for="date_of_start">date of start*</label>
          <input name="date_of_start" type="date" class="form-control" id="date_of_start" required value="{{ old("date_of_start") ? old("date_of_start") : $stock->date_of_start }}">
        </div>
        {{-- /date of start --}}

        {{-- date of end --}}
        <div class="col-2 form-group {{ $errors->has('date_of_end') ? 'has-error' :'' }}">
          <label for="date_of_end">date of end*</label>
          <input name="date_of_end" type="date" class="form-control" id="date_of_end" required value="{{ old("date_of_end") ? old("date_of_end") : $stock->date_of_end  }}">
        </div>
        {{-- /date of end --}}

        {{-- submit --}}
        <div class="col-3 form-group button_form">
          <button type="submit" class="btn button confirm"><i class="fas fa-chart-line"></i> Update Stock</button>
        </div>
        {{-- /submit --}}
        {{-- back --}}
        <div class="col-2 form-group button_form">
          <a class="btn button back" href="{{ route('stocks.index') }}"><i class="fas fa-undo"></i> Back</a>
        </div>
        {{-- /back --}}
      </div>

  </form>
</body>
</html>