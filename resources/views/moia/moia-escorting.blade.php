<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Observe Campaigns</h1>

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <!-- Modal and button -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                </svg> Help</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" style="top: 100px;" data-backdrop="static" data-keyboard="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-question-circle"
                                    viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                                </svg> &nbsp; What is the "Manage Survey" Page ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="height: 300px; overflow:scroll;">
                            <p><b></b></p>
                            • This page shows all the Campaigns created by the Ministry of Health .
                            <br>
                            • The page contains all campaigns information, to give the Ministry of Internal Affairs useful information to escort the campaign.
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="text-center mb-3"> Current Campaigns </h4>
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Campaign's start date</th>
                        <th scope="col">Campaign's end date</th>
                        <th scope="col">City</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->start_date }}</td>
                            <td>{{ $campaign->end_date }}</td>
                            <td>{{ $campaign->city }}</td>
                            <td>{{ $campaign->address }}</td>
                            <td>{{ $campaign->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <ul class="pagination justify-content-center">
                    @if ($campaigns->previousPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moia/escorting?page={{ $campaigns->currentPage() - 1 }}">Previous</a></li>
                    @endif
                    
                    
                    @for($page = 1; $page <= $campaigns->lastPage(); $page++)
                        <li class="page-item"><a class="page-link" href="/staff/moia/escorting?page={{ $page }}">{{ $page }}</a></li>
                    @endfor

                    @if ($campaigns->nextPageUrl())
                        <li class="page-item"><a class="page-link" href="/staff/moia/escorting?page={{ $campaigns->currentPage() + 1 }}">Next</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
