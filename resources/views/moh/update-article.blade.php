<x-app-layout>
    <link href="{{asset('css/reservation.css')}}" rel="stylesheet">

    <div class="mt-5 text-center">
        @if ($errors->any())
            <div class="container">
                <div class="alert alert-danger" role="alert">
                    <p>Something went wrong. Please check the form below for errors.</p>

                    <ul class="">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="text-start shadow container bg-white mt-5 rounded px-5 py-3 text-dark">
            <h4 class="mb-3 text-center"> Update Article # {{$article->id}} </h4>    
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label>Title</label>
                        <input value="{{$article->title}}" type="text" class="form-control" name="title" placeholder="Enter article title" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>Add image</label>
                        <br>
                        <input class="form-control" type="file" name="image">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 col-md-6">
                        <label>Content</label>
                        <textarea value="{{$article->content}}" class="form-control" rows="5" name="content" placeholder="Enter article content" required></textarea>
                    </div>

                    <div class="col-12 col-md-6">
                        <label>(Optional) Link to the full article</label>
                        <input value="{{$article->full_link}}" class="form-control" type="text" name="full_link" placeholder="Enter full article link">
                    
                        <label class="mt-2">(Optional) Link to video</label>
                        <input value="{{$article->link}}" class="form-control" type="text" name="link" placeholder="Enter full article link">
                    </div>
                </div>

                <div class="container text-center my-3">
                    <button type="submit" style="width: 300px;" class="btn btn-success">Update</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
