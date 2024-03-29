<x-layout>
    <h3>Form information</h3>
    <div>
        <form class="form" action="{{ isset($telegraphText) ? route('texts-update') : route('texts-store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Title:</label>
                <input type="text" name="title" id="text" class="form-control" placeholder="Enter title"
                       value="{{ isset($telegraphText) ? $telegraphText['title'] : '' }}">
            </div>
            <div class="form-group">
                <label for="content">Text:</label>
                <input type="text" name="text" id="text" class="form-control" placeholder="Enter text content"
                       value="{{ isset($telegraphText) ? $telegraphText['text'] : '' }}">
            </div>
            <div class="form-group">
                <label for="content">Author:</label>
                <input type="text" name="author" id="author" class="form-control" placeholder="Enter author"
                       value="{{ isset($telegraphText) ? $telegraphText['author'] : '' }}">
            </div>
            <input type="hidden" name="id" id="id" value="{{ isset($telegraphText) ? $telegraphText['id'] : '' }}">
            <button type="submit" class="btn btn-primary">{{isset($telegraphText) ? 'Update' : 'Create'}}</button>
        </form>
    </div>
</x-layout>
