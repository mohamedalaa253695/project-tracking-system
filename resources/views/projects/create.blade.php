@extends('layouts.app')

@section('content')

    {{-- <form method="post" action="/project/store">
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



    </form> --}}

    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Let’s start something new
        </h1>


        <form method="POST" action="/project/store">
            @include ('projects._form', [
            'project' => new App\Project,
            'buttonText' => 'Create Project'
            ])
        </form>

    </div>

@endsection
