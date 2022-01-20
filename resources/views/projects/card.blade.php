    <div class="card flex flex-col" style="height:250px">
        <a href="/project/{{ $project->id }}">
            <h3 class="font-normal text-xl mb-6 -ml-5 border-l-4 border-blue-light pl-4">{{ $project->title }}
            </h3>
        </a>
        <div class="text-grey mb-4 flex-1">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>

        <footer>
            <form method="POST" action="{{ $project->path() }}" class="text-right pt-8">
                @method('DELETE')
                @csrf
                <button type="submit" class="text-xs ">Delete</button>
            </form>
        </footer>
    </div>
