const sortableList = document.querySelector('#sortableList');
const sortSwitch = document.querySelector('#sortSwitch');

function onUpdateSorting(e) {
    const currentUrl = new URL(window.location.href);
    const requestBody = { 
        order: Sortable.get(e.target).toArray(),
    };
    return fetch(`${currentUrl.pathname}/sort`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(requestBody),
    });
};

document.addEventListener('DOMContentLoaded', () => {
    new Sortable(sortableList, { 
        onUpdate: onUpdateSorting,
        ghostClass: 'bg-info',
        animation: 150,
        disabled: !sortSwitch.checked,
    });
});

sortSwitch.addEventListener('input', (e) => {
    Sortable.get(sortableList).option('disabled', !e.target.checked);
});
