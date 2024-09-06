<option value="">Select User </option>
@foreach ($records as $record)
    @if (request()->user)
        <option value="{{ $record->id }}" @if (request()->user == $record->id) selected @endif>
            {{ $record->first_name . ' ' . $record->last_name }}</option>
    @else
        <option value="{{ $record->id }}">
            {{ $record->first_name . ' ' . $record->last_name }}</option>
    @endif
@endforeach
