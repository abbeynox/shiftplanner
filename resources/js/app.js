import flatpickr from "flatpickr";

/**
 * Add flatpickr for events
 */
function addEvents() {
    const e = new Date();
    e.setHours(0);
    flatpickr(".datepicker", {
        minDate: e,
        enableTime: true,
        time_24hr: true,
    });

    const el = document.getElementById('start');
    if(el !== null) {
        el.addEventListener("change",
            (function () {
                const e1 = new Date(document.getElementById('start').value);
                const e2 = new Date(e1);
                e2.setHours(e2.getHours() + 1);
                document.getElementById('end').flatpickr({
                    defaultDate: e2,
                    minDate: e1,
                    enableTime: true,
                    time_24hr: true,
                });
            })
        );
    }
}

/**
 * Add a confirmation dialog before deleting a shift
 */
function deleteShift() {
    const forms = document.querySelectorAll('form.delete-shift');
    if(forms.length > 0) {
        forms.forEach((form) => {
            const msg = form.dataset['confirmDeleteMsg'];
            form.addEventListener('submit', function (event) {
                if (!confirm(msg)) {
                    event.preventDefault();
                }
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', addEvents);
document.addEventListener('DOMContentLoaded', deleteShift);

function openImport() {
  document.getElementById('importForm').style['display'] = 'block';
  this.style['display']='none';
}
function registerOpenImport() {
  var button = document.getElementById('openImportButton');
  if (button) {
    button.onclick = openImport;
    document.getElementById('import').onchange = function() {
      document.getElementById('importPlanForm').submit();
    };
  }
}
document.addEventListener('DOMContentLoaded', registerOpenImport);
