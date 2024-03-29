<x-layout>
    <h3>Text List</h3>
    <table class="table table-success table-striped">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">title</th>
            <th scope="col">text</th>
            <th scope="col">author</th>
            <th scope="col">created-at</th>
            <th scope="col">updated-at</th>
            <th scope="col">delete</th>
            <th scope="col">update</th>
        </tr>
        </thead>
        <tbody>
        @foreach($texts as $text)
            <tr>
                <td>{{$text['id']}}</td>
                <td>{{$text['title']}}</td>
                <td>{{$text['text']}}</td>
                <td>{{$text['author']}}</td>
                <td>{{$text['created_at']}}</td>
                <td>{{$text['updated_at']}}</td>
                <td>
                    <form action="/text-delete/{{ $text->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
                <td>
                    <form action="/text-update/{{ $text->id }}" method="POST">
                        @csrf
                        <button class="btn btn-success" type="submit">Update</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a class="btn btn-primary" href="{{ route('texts-create')}}">Create new text</a>
</x-layout>
