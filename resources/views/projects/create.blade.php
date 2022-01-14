@extends('layouts.app')

@section('content')

    <form method="post" action="/project/store">
        @csrf

        <h1 class="heading is-1">Create Project</h1>
        <div>
            <input type="text" name="title">

        </div>
        <div class="mt-2">
            <textarea type="texterea" name="description"></textarea>

        </div>

        <button>Create</button>
        <a href="/projects"> Cancel</a>



    </form>

@endsection
