import $ from 'jquery';
window.$ = window.jQuery = $;
import Inputmask from "inputmask";
import pikaday from 'pikaday';
window.Pikaday = pikaday;
import '/vendor/yungifez/artisan-ui/dist/artisan.js'

// Insert helper
function insertInString(index, str, insertStr) {
    return str.slice(0, index) + insertStr + str.slice(index);
}

// Finnik formatting functie
function formatAsLicensePlate(n) {
    let r, t, i;
    n = n.replace(/[^a-z0-9]/gi, '');
    let u = n.length;
    if (u < 2) return n;
    if (u === 2) {
        let f = n.match(/[a-zA-Z]{2}/);
        if (f && f.length) return n + '-';
    }
    n = n.toUpperCase();
    n = n.replace(/(\d)(\D)/, '$1-$2');
    n = n.replace(/(\D)(\d)/, '$1-$2');
    t = n.match(/[A-Z]{4}/);
    if (t && t.length) {
        r = insertInString(2, t[0], '-');
        n = n.replace(t[0], r);
    }
    i = n.match(/[0-9]{4}/);
    if (i && i.length) {
        r = insertInString(2, i[0], '-');
        n = n.replace(i[0], r);
    }
    return n;
}

// Keydown handler: for backspace/del, do manual removal
$(document).on('keydown', '#licensePlateInput', function (e) {
    const key = e.which || e.keyCode || e.charCode;
    if (key === 8 || key === 46) {
        e.preventDefault();
        let v = $(this).val().replace(/[^a-z0-9]/gi, '').toUpperCase();
        v = v.slice(0, -1);
        $(this).val(formatAsLicensePlate(v));
        return false;
    }
});

// Input handler: format on every input
$(document).on('input', '#licensePlateInput', function () {
    const $this = $(this);
    const formatted = formatAsLicensePlate($this.val());
    if ($this.val() !== formatted) {
        $this.val(formatted);
    }
});





