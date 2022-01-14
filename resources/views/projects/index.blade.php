@extends('layouts.app')

@section('content')

    <div class="flex items-center mb-3">
        {{-- <h1 class="mr-auto">projects</h1> --}}
        <a href="/project/create"> create project</a>
    </div>

    <div class="flex">

        @forelse ($projects as $project)
            <div class="bg-white mr-4 rounded p-3 shadow-xl w-1/3">
                <h3>{{ $project->title }}</h3>
                <div>{{ Illuminate\Support\Str::limit($project->description) }}</div>
            </div>

        @empty
            <div>No projects yet</div>
        @endforelse

    </div>


@endsection
