<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        <h1 class="aigps-title">Observe Campaigns</h1>

        <div class="table-responsive text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
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
