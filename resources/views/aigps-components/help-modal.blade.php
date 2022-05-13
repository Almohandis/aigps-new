@if (session('help'))
    <div>
        <div class="list-group-item my-4">
            It seems like you have encountered an error: 
            <button data-bs-toggle="modal" data-bs-target="#helpModal" class="btn btn-outline-primary">Help</button>
        </div>

        <div class="modal fade" id="helpModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="helpModalLabel">{{ session('help')['title'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">{{ session('help')['message'] }}</p>

                        <ul class="list-group">
                            @foreach (session('help')['steps'] as $index => $step)
                                <li class="list-group-item">
                                    <span class="text-muted text-h3">{{ $index + 1 }}. </span>
                                    {{ $step }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif