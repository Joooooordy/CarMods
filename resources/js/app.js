import $ from 'jquery';

window.$ = window.jQuery = $;
import Inputmask from "inputmask";
import pikaday from 'pikaday';

window.Pikaday = pikaday;
import '/vendor/yungifez/artisan-ui/dist/artisan.js'
import Typewriter from 'typewriter-effect/dist/core';


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
$(document).on('keydown', '#licensePlateInput, #licensePlateInputCarData', function (e) {
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
$(document).on('input', '#licensePlateInput, #licensePlateInputCarData', function () {
    const $this = $(this);
    const formatted = formatAsLicensePlate($this.val());
    if ($this.val() !== formatted) {
        $this.val(formatted);
    }
});

$(document).on('click', '#licensePlateInputCarData', function () {
    const $this = $(this);
    const search = '#search_button_car_data';

    const formatted = formatAsLicensePlate($this.val());

    if ($this.val() !== formatted) {
        $this.val(formatted);
    }

    $(search).fadeIn(200);
});

$(document).on('blur', '#licensePlateInputCarData', function () {
    const search = '#search_button_car_data';
    const field = $(this);

    if (field.val() === '') {
        $(search).fadeOut(200);
    }
});

const licenseplate = '#licensePlateInput';
const typewriter = new Typewriter(licenseplate, {
    loop: true
});

const app = {
    typewriter: function () {
        $.fn.placeholderTypewriter = function (options) {
            function typeChar($el, textIndex, charIndex, onComplete) {
                const currentText = settings.text[textIndex];
                const currentPlaceholder = $el.attr("placeholder");

                $el.attr("placeholder", currentPlaceholder + currentText[charIndex]);

                if (charIndex < currentText.length - 1) {
                    setTimeout(() => {
                        typeChar($el, textIndex, charIndex + 1, onComplete);
                    }, settings.delay);
                    return true;
                }

                onComplete();
            }

            function eraseChar($el, onComplete) {
                const currentPlaceholder = $el.attr("placeholder");
                const length = currentPlaceholder.length;

                $el.attr("placeholder", currentPlaceholder.substr(0, length - 1));

                if (length > 1) {
                    setTimeout(() => {
                        eraseChar($el, onComplete);
                    }, settings.delay);
                    return true;
                }

                onComplete();
            }

            function loopTyping($el, index) {
                setTimeout(() => {
                    eraseChar($el, function () {
                        typeChar($el, index, 0, function () {
                            loopTyping($el, (index + 1) % settings.text.length);
                        });
                    });
                }, settings.pause);
            }

            const settings = $.extend({
                delay: 80,
                pause: 10000,
                text: []
            }, options);

            return this.each(function () {
                loopTyping($(this), 0);
            });
        };

        $("#licensePlateInput").placeholderTypewriter({
            text: ["1-ABC-23", "08-CMD-1", "HT-260-X", "8-ZTP-72", "3-ZRH-53", "XX-123-X"]
        });
    },
    init: function() {
        app.typewriter();
    }
};
app.init();







