<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if(session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <h1>Type national Id and choose carefully</h1>
            <form action="/nationalid/add" method='POST'>
                @csrf
                <input type="number" name="entered_id">
                <input type="submit" value="Add" name="add">
                <input type="submit" value="Delete" name="delete">
            </form>



        </div>
    </div>
</x-app-layout>
