<option value="" selected>select city</option>
@foreach ($records as $record)
    <option value="{{ $record->id }}">{{ $record->name }}</option>
@endforeach
