<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-9">
        <div class="notification">
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
        <div class="pt-8 sm:pt-0">
            <div class="add-national-id">
                <h1 class="type-id-hero">Type national Id and choose carefully</h1>
                <form action="/staff/nationalid/add" method='POST'>
                    @csrf
                    <input type="number" name="entered_id" style="margin-left: 19rem;border-width: 2px;border-color: gray;">
                    <input type="submit" value="Add" name="add" class="add-id-btn">
                    <input type="submit" value="Delete" name="delete" class="delete-id-btn">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
