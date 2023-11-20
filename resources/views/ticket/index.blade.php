<x-app-layout>
  <div class="container p-3">
    <div class="card">
      @if(session('message'))
      <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <div class="card-body">
        <div class="mt-2">
          <div class="card">
            <div class="d-flex justify-content-center p-3">
              <strong class="text-center"> List Ticket</strong>
            </div>
          </div>
          <a class="mb-4 mt-4 btn btn-success" href="{{route('ticket.create')}}">Create</a>
          <div class="row">
            @foreach ((array)$items as $item )
            <div class="col-6 col-md-4 p-3">
              <a href="{{route('ticket.show',['ticket'=>$item->id])}}">
                <div class="card">
                  <img src="{{" /storage/$item->attachment"}}" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">
                      <strong>
                        {{$item->title}}
                      </strong>
                      @if ($item->status === 'open')
                      <span class="badge bg-secondary">{{$item->status}}</span>   
                      @endif
                      @if ($item->status === 'approved')
                      <span class="badge bg-success">{{$item->status}}</span>   
                      @endif
                      @if ($item->status === 'rejected')
                      <span class="badge bg-danger">{{$item->status}}</span>   
                      @endif
                    </h5>
                    <strong>
                      {{$item->created_at}}
                    </strong>
                    <p class="card-text">{{$item->description}}</p>
                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                      <a class="btn text-white bg-danger" href="{{route('ticket.edit',['ticket'=>$item->id])}}">edit</a>
                      <form action="{{ route('ticket.destroy',['ticket'=>$item->id]) }}" method="post">
                        @method('delete')
                        @csrf
                        <input onclick="return confirm('Are you sure?')" class="btn text-white bg-warning" type="submit"
                          value="Delete" />
                      </form>
                      <a class="btn text-white bg-success"
                        href="{{route('ticket.show',['ticket'=>$item->id])}}">view</a>
                    </div>
                    @if(auth()->user()->isAdmin)
                    <div class="btn-group mt-2" role="group" aria-label="Basic outlined example">
                      <form action="{{route('ticket.update',['ticket'=>$item->id])}}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-outline-primary">Approve</button>
                      </form>
                      <form action="{{route('ticket.update',['ticket'=>$item->id])}}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-outline-primary">Reject</button>
                      </form>
                    </div>
                    @else
                    <span class="bag">{{$ticket->status}}</span>
                    @endif
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>