<x-app-layout>
   <div class="container p-3">
      <div class="card mt-4">
         <div class="card-body">
            <h1>Edit Ticket {{$ticket->title}}</h1>
            <form action="{{route('ticket.update',['ticket'=>$ticket->id])}}" method="post"
               enctype="multipart/form-data">
               @csrf
               @method('patch')
               <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <input name="title" type="text" value="{{$ticket->title}}" class="form-control" id="title" placeholder="Enter title">
                  <div class="text-danger">
                     <x-input-error :messages="$errors->get('title')" class="mt-2" />
                  </div>
               </div>
               <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea name="description" class="form-control p-0" id="description" rows="3">
                     {{$ticket->description}}
                  </textarea>
                  <div class="text-danger">
                     <x-input-error :messages="$errors->get('description')" class="mt-2" />
                  </div>
               </div>
               <div class="mb-3">
                  <label for="attachment" class="form-label">Attachment</label>
                  <img src="{{"/storage/$ticket->attachment"}}" alt="">
                  <input name="attachment" class="form-control" type="file" id="attachment">
                  <div class="text-danger">
                     <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                  </div>
               </div>
               <button type="submit" class="btn bg-success text-white">Update</button>
               <a class="btn btn-danger" href="{{route('ticket.index')}}">Go Back</a>
            </form>
         </div>
      </div>
   </div>
</x-app-layout>