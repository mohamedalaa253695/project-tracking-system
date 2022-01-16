@extends('layouts.app')

@section('content')

    <header class="flex items-end mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal">My Projects</a> / {{ $project->title }}
            </p>

            <a href="/project/create" class="button"> New project</a>
        </div>
    </header>

    <main>

        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-6">
                    <h2 class="text-lg text-grey font-normal">Tasks</h2>


                    @foreach ($project->tasks as $task)
                        @dump($key, $task)
                        <div class="card mr-3">{{ $task->body }}</div>

                    @endforeach

                </div>
                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                    <textarea class="card w-full" style="height: 200;">Lorem ipsum dolor sit </textarea>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">


                @include('projects.card')

            </div>
        </div>
    </main>

@endsection
