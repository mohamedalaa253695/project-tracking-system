    <div class="card" style="height:250px">
        <a href="/project/{{ $project->id }}">
            <h3 class="font-normal text-xl mb-6 -ml-5 border-l-4 border-blue-light pl-4">{{ $project->title }}
            </h3>
        </a>
        <div class="text-grey">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
    </div>
