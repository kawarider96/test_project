@vite('resources/js/dialog.js')

<div>
    @if($projects->isEmpty())
        <p>Nincsenek projektek.</p>
    @else
        <ul>
            @foreach($projects as $project)
                <li>
                    <button id="open-dialog-button" data-project-id="{{ $project->id }}">
                        {{ $project->project_name }}
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</div>
