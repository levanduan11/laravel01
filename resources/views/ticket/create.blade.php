<x-app-layout>
   <div class="container p-3">
      <div class="card mt-4">
         <div class="card-body">
            <form action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <input name="title" type="text" class="form-control" id="title" placeholder="Enter title">
                  <div class="text-danger">
                     <x-input-error :messages="$errors->get('title')" class="mt-2" />
                  </div>
               </div>
               <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                  <div class="text-danger">
                     <x-input-error :messages="$errors->get('description')" class="mt-2" />
                  </div>
               </div>
               <div class="mb-3">
                  <label for="attachment" class="form-label">Attachment</label>
                  <input name="attachment" class="form-control" type="file" id="attachment">
                  <div class="text-danger">
                     <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                  </div>
               </div>
               <x-primary-button class="mt-3">
                  {{ __('Create') }}
               </x-primary-button>
            </form>
         </div>
      </div>
   </div>
</x-app-layout>