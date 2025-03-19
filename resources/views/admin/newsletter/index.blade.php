@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Newsletter Management</h2>
    <a href="{{ route('admin.newsletters.create') }}" class="btn btn-primary my-3">Create New Newsletter</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Sent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($newsletters as $newsletter)
                <tr>
                    <td>{{ $newsletter->subject }}</td>
                    <td>{{ $newsletter->sent ? '✅ Sent' : '❌ Not Sent' }}</td>
                    <td>
                        @if (!$newsletter->sent)
                            <form action="{{ route('newsletters.send', $newsletter) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Send</button>
                            </form>
                        @endif
                        <a href="#" onclick="showNewsletter({{ $newsletter->id }})" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Viewing Newsletter -->
<div class="modal fade" id="newsletterModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Newsletter Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="newsletterContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function showNewsletter(id) {
        fetch(`/newsletters/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("newsletterContent").innerHTML = data.content;
                new bootstrap.Modal(document.getElementById("newsletterModal")).show();
            });
    }
</script>
@endsection
