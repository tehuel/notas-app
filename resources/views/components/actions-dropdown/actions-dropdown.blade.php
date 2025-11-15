<div class="dropdown">
    <button
        class="btn btn-sm rounded-circle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        aria-label="{{ __('Acciones') }}"
    >
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        {{ $slot }}
    </ul>
</div>