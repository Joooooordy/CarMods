import $ from 'jquery';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import flatpickr from "flatpickr";
import Inputmask from "inputmask";
import pikaday from 'pikaday';
import '/vendor/yungifez/artisan-ui/dist/artisan.js'
import Typewriter from 'typewriter-effect/dist/core';
import Swal from "sweetalert2";

window.$ = window.jQuery = $;
window.Pikaday = pikaday;

// ***********************************
// * LICENSE PLATE FUNCTIONS
// ***********************************

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

const licenseplate = '#licensePlateInput';
const el = document.querySelector('#licensePlateInput');
if (el) {
    new Typewriter(el, {loop: true});
}

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
    init: function () {
        app.typewriter();
    }
};
app.init();

// ***********************************
// * TOGGLE BUTTON VEHICLEDATA ON SHOWCARDATA PAGE
// ***********************************
$(function () {
    $(function () {
        $('#toggleVehicleDataBtn').click(function () {
            const content = $('#vehicleDataContent');
            content.slideToggle(200);

            $(this).toggleClass('active');

            if ($(this).hasClass('active')) {
                $(this).text('Hide data');
            } else {
                $(this).text('Load more data...');
            }
        });
    });
});


// ***********************************
// * SHOW ICONS ON CAR DATA PAGE
// ***********************************
const icons = document.querySelectorAll('.icon[data-darkbgimage]');
icons.forEach(el => {
    const bg = el.getAttribute('data-darkbgimage');
    if (bg) {
        const url = bg.replace(/^url\(['"]?/, '').replace(/['"]?\)$/, '');
        const img = new Image();
        img.onload = () => {
            el.style.backgroundImage = bg;
        };
        img.onerror = () => {
            console.warn('Could not load', bg);
        };
        img.src = url;
    }
});

// ***********************************
// * SHOP MESSAGES
// ***********************************
$(document).ready(function () {
    window.addEventListener('product-added', function (event) {
        console.log('Product toegevoegd event:', event.detail);
        Swal.fire({
            title: 'Succesfully added to cart',
            text: `${event.detail[0].name} is succesfully added to your shopping cart.`,
            imageUrl: "/img/car-driving-32.gif",
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: "car-driving-32.gif",
            customClass: {
                image: 'bordered-image',
                confirmButton: 'bg-yellow-400 text-black hover:bg-yellow-500 px-4 py-2 rounded-md'
            },
            width: 600,
            heightAuto: true,
            confirmButtonColor: "#ecc94b",
            cancelButtonColor: "#3b3b3b",
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: `
                <div class="flex items-center gap-2">
                  <span>To your cart</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                     <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
                </div>
              `,
            cancelButtonText: `
                Continue shopping`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = '/cart';
            }
        });
    });
});












