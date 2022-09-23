<div class="modal fade " id="modalForm" tabindex="-1" role="dialog">
   <div class="modal-dialog  " role="document">
       <div class="modal-content">
           <form  method="POST">
               @csrf
               @method('POST')
               <input id="id" type="hidden" name="id" value="">
               <div class="modal-header">
                   <h4 class="modal-title" id="modalFormTitle">Modal title</h4>
               </div>
               <div class="modal-body">
                   @yield('input-form')
               </div>
               <div class="modal-footer">
                   <button type="submit" class="btn btn-link waves-effect btn-primary" id='submit'>Simpan</button>
                   <button type="button" class="btn btn-link waves-effect btn-danger" data-dismiss="modal">Tutup</button>
               </div>
           </form>
       </div>
   </div>
</div>
