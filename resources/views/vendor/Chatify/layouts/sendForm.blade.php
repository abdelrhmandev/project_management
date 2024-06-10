<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        <input type="hidden" name="Chat_project_id" id="Chat_project_id" value="{{ $id ?? ''}}">
        @csrf
        <label><span class="fas fa-paperclip"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="{{ __('site.type_a_message') }} .."></textarea>
        <button disabled='disabled'><span class="fas fa-paper-plane"></span></button>
    </form>
</div>
