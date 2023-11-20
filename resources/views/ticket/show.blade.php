<x-app-layout>
  <div class="container p-3">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <strong class="badge bg-success">date</strong>
          <strong class="badge bg-danger">{{$ticket->created_at}}</strong>
        </div>
      </div>
      <div class="card-body">
        <img style="width: 18rem;" src="{{" /storage/$ticket->attachment"}}" class="card-img-top" alt="...">
        <strong class="card-title">{{$ticket->title}}</strong>
        <p class="card-text">{{$ticket->description}}</p>
        <a href="{{route('ticket.index')}}" class="btn btn-primary">Go back</a>
      </div>
    </div>
  </div>
</x-app-layout>