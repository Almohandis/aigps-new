<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">

            <form action="/staff/moh/articles/add" enctype="multipart/form-data" method="POST" class="add-article-form">
                <h1 class="add-hero2">Add new article</h1>
                @csrf
                <div style="margin-left: 18rem;margin-top: 1rem;">
                    <label for="title">Article title</label>
                    <input style="width: 25rem;" type="text" name="title" id="title" placeholder="Enter article title"
                        required>
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="content">Article content</label>
                    <br>
                    <textarea style="margin-left: 7rem;margin-top: -2rem;" name="content" id="content" cols="30" rows="10"
                        placeholder="Enter article content" required></textarea>
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="image">Add image</label>
                    <input type="file" name="image" id="image" style="margin-left: 1.5rem;">
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="full-link">(Optional) Link to the full article</label>
                    <input type="text" name="full_link" id="full-link" placeholder="Enter full article link">
                </div>
                <br>
                <div style="margin-left: 18rem;">
                    <label for="video">(Optional) Link to video</label>
                    <input type="text" name="link" id="video" placeholder="Enter video link">
                </div>
                <br>
                <input type="submit" value="Add article" class="submit" style="margin-top: -2rem;">
                <br>
            </form>

            <h1 class="add-hero">All articles</h1>
            
            <div class="tbl-header">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>

                </table>
            </div>
            <div class="tbl-content">
                <table>
                    @foreach ($articles as $id => $article)
                        <tr>
                            <td>{{ $id + 1 }}</td>
                            <td>{{ $article->title }}</td>
                            <td><a href="/staff/moh/articles/{{$article->id}}/update" class="text-blue-500"> Update </a></td>
                            <td><a href="/staff/moh/articles/{{$article->id}}/delete" class="text-red-500"> Delete </a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            
            
        </div>
    </div>
</x-app-layout>
