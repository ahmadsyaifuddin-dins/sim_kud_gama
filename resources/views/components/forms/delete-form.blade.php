{{-- resources/views/components/forms/delete-form.blade.php --}}
@props([
    'action', 
    'title' => 'Yakin ingin menghapus data ini?', 
    'text' => 'Data yang dihapus tidak bisa dikembalikan.',
    'buttonText' => 'Hapus'
])

<form action="{{ $action }}" method="POST" 
      class="inline-block confirm-action"
      data-swal-title="{{ $title }}"
      data-swal-text="{{ $text }}">
    @csrf
    @method('DELETE')
    
    <button type="submit" 
        class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition duration-150">
        <i class="fas fa-trash-alt mr-2"></i> {{ $buttonText }}
    </button>
</form>