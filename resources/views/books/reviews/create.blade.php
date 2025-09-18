@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-3">Add Review for the book {{ $book->title }} </h1>

    <form action="{{ route('books.reviews.store', $book) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="review" class="font-semibold">Review</label>
            <textarea name="review" id="review" required class="input"></textarea>
        </div>

        <div class="mb-4">
            <label for="rating" class="font-semibold">Rating</label>
            <select name="rating" id="rating" class="input" required>
                <option disabled>Select Rating</option>
                @for ($r = 1; $r <= 5; $r++)
                    <option value="{{ $r }}">{{ $r }}</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="btn">Add Review</button>
    </form>
@endsection
