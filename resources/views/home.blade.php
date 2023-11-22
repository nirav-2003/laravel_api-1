@extends('layouts.app')

@section('content')
    
    <form method="POST" style="text-align: center">
        @csrf
        <label for="fname">Post</label><br>
        <input type="text" name="name"><br>
        <input type="submit" value="Submit">
    </form>
@endsection
