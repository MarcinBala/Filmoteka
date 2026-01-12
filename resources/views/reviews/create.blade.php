@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('review.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-12">

                    @php($user_review = Auth::user()->reviews->where('film_id', $film->id)->first())

                    <div class="form-group">
                        <label for="rating">Twoja Ocena</label>
                        <select multiple class="form-control" id="rating" name="rating" required>
                            <option @if($user_review && $user_review->rating == 0) selected @endif>0</option>
                            <option @if($user_review && $user_review->rating == 1) selected @endif>1</option>
                            <option @if($user_review && $user_review->rating == 2) selected @endif>2</option>
                            <option @if($user_review && $user_review->rating == 3) selected @endif>3</option>
                            <option @if($user_review && $user_review->rating == 4) selected @endif>4</option>
                            <option @if($user_review && $user_review->rating == 5) selected @endif>5</option>
                            <option @if($user_review && $user_review->rating == 6) selected @endif>6</option>
                            <option @if($user_review && $user_review->rating == 7) selected @endif>7</option>
                            <option @if($user_review && $user_review->rating == 8) selected @endif>8</option>
                            <option @if($user_review && $user_review->rating == 9) selected @endif>9</option>
                            <option @if($user_review && $user_review->rating == 10) selected @endif>10</option>
                        </select>

                        @error('rating')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    <div class="form-group">
                        <label for="content">Treść</label>
                        <textarea id="content" name="content" class="form-control" rows="15" required>@if($user_review && !empty($user_review->content)){{$user_review->content}}@endif</textarea>
                        @error('content')
                        <span class="invalid-feedback d-inline" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <input type="hidden" name="film_id" value="{{$film->id}}">

                    <div class="pt-3">
                        @if($user_review && !empty($user_review->content))
                            <button type="submit" class="btn btn-primary">Edytuj Recenzję</button>
                        @else
                            <button type="submit" class="btn btn-primary">Dodaj Recenzję</button>
                        @endif
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
