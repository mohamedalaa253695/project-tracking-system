@extends('layouts.app')

@section('content')

    <header class="flex items-end mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal">My Projects</a> / {{ $project->title }}
            </p>

            <a href="{{ $project->path() . '/edit' }}" class="button">Edit Project</a>

        </div>
    </header>

    <main>

        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-6">
                    <h2 class="text-lg text-grey font-normal">Tasks</h2>


                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input name="body" value="{{ $task->body }}"
                                        class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                    <input name="completed" type="checkbox" onChange="this.form.submit()"
                                        {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>

                    @endforeach

                    <div class="card mr-3 mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf

                            <input placeholder="Add a new task..." class="w-full" name="body">
                        </form>
                    </div>

                </div>
                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')

                        <textarea name="notes" class="card w-full mb-4" style="min-height:200px;"
                            placeholder="Any Notes To Add ... ">{{ $project->notes }}</textarea>

                        <button type="submit" class="button">Save</button>

                    </form>
                    @include ('errors')
                </div>
            </div>
            <div class="lg:w-1/4 px-3">


                @include('projects.card')

            </div>
        </div>
    </main>

@endsection
