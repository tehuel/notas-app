<span>
    <button
        type="button"
        class="btn btn-sm btn-primary"
        title="{{ __('Corregir') }}"
        data-bs-toggle="modal"
        data-bs-target="#modal-{{ $gradeable->id }}-{{ $assessment->id }}"
    >
        <i class="bi bi-journal-plus"></i>
    </button>

    <div
        class="modal fade" 
        id="modal-{{ $gradeable->id }}-{{ $assessment->id }}" 
        tabindex="-1" 
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('Corregir :assessment de :gradeable', [
                            'assessment' => $assessment->title,
                            'gradeable' => $gradeable->name ?? $gradeable->title,
                        ]) }}
                    </h5>
                    <button 
                        type="button" 
                        class="btn-close" 
                        data-bs-dismiss="modal" 
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <x-grades.form 
                        :id="'gradeable-' . $gradeable->id . '-assessment-' . $assessment->id"
                        :assessment="$assessment" 
                        :gradeable="$gradeable" 
                    />
                </div>

            </div>
        </div>
    </div>
</span>
